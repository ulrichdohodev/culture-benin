<#
deploy_prod.ps1
Script interactif pour préparer et déclencher le déploiement

Fonctionnalités:
- Vérifie les dépendances locales (php, node, npm, git, flyctl, pscale, gh)
- Construit le frontend `Front1`
- Génère un `APP_KEY` si nécessaire
- Prépare les commandes pour créer la base PlanetScale ou utilise des credentials fournis
- Définit les secrets Fly et GitHub (si `flyctl` et `gh` sont installés et authentifiés)
- Pousse le repo sur la branche `main` et déclenche les workflows CI

Usage: lancez ce script dans PowerShell (ex: PowerShell en mode administrateur si vous voulez installer des outils)

Remarque: le script demande des tokens / mots de passe au besoin. Ne partagez pas ces valeurs en clair publiquement.
#>

function Check-Command {
    param([string]$cmd)
    $p = Get-Command $cmd -ErrorAction SilentlyContinue
    return $p -ne $null
}

Write-Host "=== Déploiement automatique (interactive) ===" -ForegroundColor Cyan

# Vérifier outils
$tools = @("php","node","npm","git","flyctl","pscale","gh")
$have = @{}
foreach($t in $tools){ $have[$t] = Check-Command $t }

Write-Host "Outils détectés:" -ForegroundColor Green
foreach($t in $tools){ Write-Host " - $t : $($have[$t])" }

if(-not $have['node'] -or -not $have['npm']){
    Write-Warning "Node/npm sont requis pour builder le frontend. Installez-les avant de continuer."; 
}

# 1) Build frontend
if(Test-Path "Front1"){
    if($have['node'] -and $have['npm']){
        Write-Host "Building frontend (Front1)..." -ForegroundColor Cyan
        Push-Location Front1
        npm ci
        npm run build
        Pop-Location
        Write-Host "Frontend build terminé." -ForegroundColor Green
    } else {
        Write-Warning "Ignoré: Node/npm manquant. Construisez le frontend manuellement: 'cd Front1; npm ci; npm run build'"
    }
} else {
    Write-Warning "Répertoire Front1 introuvable. Ignoré.";
}

# 2) Générer APP_KEY
if(-not (Test-Path ".env")){
    Write-Host "Aucun fichier .env local trouvé — je génère un APP_KEY pour vous (affiché à l'écran)." -ForegroundColor Cyan
}
try{
    $appkey = & php artisan key:generate --show 2>$null
    if($LASTEXITCODE -eq 0 -and $appkey){
        $appkey = $appkey.Trim()
        Write-Host "APP_KEY générée: $appkey" -ForegroundColor Green
    } else {
        Write-Warning "Impossible de générer APP_KEY automatiquement (php/artisan peut manquer). Générer manuellement: php artisan key:generate --show"
    }
} catch {
    Write-Warning "Erreur lors de l'exécution de 'php artisan key:generate --show' : $_"
}

# 3) Choix fournisseur DB
$dbChoice = Read-Host "Choisissez le fournisseur de BD: (1) PlanetScale (gratuit)  (2) DigitalOcean/Autre payant -- tapez 1 ou 2"
if($dbChoice -eq '1'){
    $dbProvider = 'planetscale'
} else {
    $dbProvider = 'other'
}

# 4) Récupérer informations DB (prompt)
$db_host = Read-Host "DB_HOST (ex: us-east.connect.psdb.cloud)"
$db_name = Read-Host "DB_DATABASE (ex: culture_benin)"
$db_user = Read-Host "DB_USERNAME"
$db_pass = Read-Host -AsSecureString "DB_PASSWORD (entrée masquée)"
$db_pass_plain = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($db_pass))

# 5) Définir secrets Fly (si flyctl disponible)
if($have['flyctl']){
    Write-Host "Définition des secrets Fly via flyctl..." -ForegroundColor Cyan
    if(-not $appkey){
        $appkey = Read-Host "Aucun APP_KEY automatique. Collez votre APP_KEY (base64:...)"
    }
    # Construire la commande (utiliser des guillemets simples autour des valeurs)
    $flyCmd = "flyctl secrets set APP_KEY='$appkey' DB_HOST='$db_host' DB_DATABASE='$db_name' DB_USERNAME='$db_user' DB_PASSWORD='$db_pass_plain' DB_SSL='true'"
    Write-Host "Exécution: $flyCmd" -ForegroundColor Yellow
    iex $flyCmd
    Write-Host "Secrets Fly définis." -ForegroundColor Green
} else {
    Write-Warning "flyctl introuvable. Voici la commande à exécuter manuellement (sur votre machine avec flyctl connecté):"
    Write-Host "flyctl secrets set APP_KEY='$appkey' DB_HOST='$db_host' DB_DATABASE='$db_name' DB_USERNAME='$db_user' DB_PASSWORD='<your_db_password>' DB_SSL='true'" -ForegroundColor Yellow
}

# 6) Configurer GitHub secrets via gh (si disponible)
if($have['gh']){
    Write-Host "Configuration des secrets GitHub via 'gh'..." -ForegroundColor Cyan
    $repo = & git rev-parse --show-toplevel 2>$null
    if($LASTEXITCODE -ne 0){ Write-Warning "Impossible de détecter le repo Git local. Assurez-vous d'être dans le répertoire du projet et que git est initialisé." }
    else{
        $remote = & git remote get-url origin 2>$null
        if($LASTEXITCODE -ne 0){ Write-Warning "Aucun remote 'origin' détecté. Poussez votre repo sur GitHub avant d'utiliser 'gh' pour définir des secrets." }
        else{
            Write-Host "Remote origin: $remote" -ForegroundColor Green
            $flyToken = Read-Host -AsSecureString "Entrez FLY_API_TOKEN (masqué) ou laissez vide pour sauter"
            if($flyToken.Length -gt 0){
                $val = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($flyToken))
                gh secret set FLY_API_TOKEN --body $val
                Write-Host "Secret GitHub FLY_API_TOKEN défini." -ForegroundColor Green
            }
            $vercelToken = Read-Host -AsSecureString "Entrez VERCEL_TOKEN (masqué) ou laissez vide pour sauter"
            if($vercelToken.Length -gt 0){
                $val = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($vercelToken))
                gh secret set VERCEL_TOKEN --body $val
                Write-Host "Secret GitHub VERCEL_TOKEN défini." -ForegroundColor Green
            }
            $vproj = Read-Host "Entrez VERCEL_PROJECT_ID (ou laissez vide)"
            if($vproj){ gh secret set VERCEL_PROJECT_ID --body $vproj; Write-Host "VERCEL_PROJECT_ID défini." }
            $vorg = Read-Host "Entrez VERCEL_ORG_ID (ou laissez vide)"
            if($vorg){ gh secret set VERCEL_ORG_ID --body $vorg; Write-Host "VERCEL_ORG_ID défini." }
        }
    }
} else {
    Write-Warning "'gh' CLI introuvable. Pour définir les secrets GitHub, installez 'gh' et exécutez : gh auth login; gh secret set <NAME> --body <VALUE>"
}

# 7) Commit & push (optionnel)
$doPush = Read-Host "Souhaitez-vous committer et pousser les changements sur 'main' maintenant ? (y/n)"
if($doPush -eq 'y'){
    & git add -A
    & git commit -m "Prepare deployment: build frontend and deploy configs" || Write-Host "Aucun changement à committer."
    $pushRes = & git push origin main
    if($LASTEXITCODE -eq 0){ Write-Host "Push effectué. Les workflows GitHub vont démarrer." -ForegroundColor Green }
    else { Write-Warning "Push échoué. Vérifiez votre remote/permissions." }
} else { Write-Host "Push ignoré. Vous pouvez pusher manuellement plus tard." }

# 8) Déployer via flyctl (si disponible)
if($have['flyctl']){
    $doDeploy = Read-Host "Souhaitez-vous lancer 'flyctl deploy' maintenant ? (y/n)"
    if($doDeploy -eq 'y'){
        iex "flyctl deploy --config fly.toml --remote-only"
    } else { Write-Host "Déploiement Fly ignoré." }
}

Write-Host "Script terminé. Vérifiez les logs GitHub Actions / Fly pour suivre le déploiement." -ForegroundColor Cyan

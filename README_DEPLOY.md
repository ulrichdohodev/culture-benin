# Déploiement (guide rapide)

Ce fichier décrit les étapes pour déployer le backend Laravel et le frontend.

Pré-requis:
- Avoir un compte GitHub
- Avoir Docker (pour tests locaux)
- Créer un compte Fly.io (backend)
- Créer une base MySQL (PlanetScale recommandé) ou utiliser l'offre de Fly/RDS
- Avoir un compte Vercel (frontend) ou Netlify

Étapes recommandées:

1) Préparer le dépôt
   - Créez un repo GitHub et poussez ce projet.

2) Backend (Fly.io)
   - Installer et configurer `flyctl` localement: `flyctl auth login`.
   - Lancer `flyctl launch` pour créer l'app (ou modifier `fly.toml`).
   - Créer un secret GitHub `FLY_API_TOKEN` (obtenu via `flyctl auth token`).
   - Pousser sur `main` pour déclencher l'action `fly-deploy` qui build et déploie l'image.

3) Base de données (PlanetScale recommandé)
   - Créer une base PlanetScale, puis récupérer les informations de connexion.
   - Définir les variables d'environnement dans Fly: `fly secrets set DB_HOST=... DB_USERNAME=... DB_PASSWORD=... DB_DATABASE=...`
   - Si PlanetScale nécessite TLS, configurez la connexion selon la doc (et utilisez `DB_SSL=true` si nécessaire).

   Générer `APP_KEY` et définir les secrets Fly
   -------------------------------------------

   1) Générer `APP_KEY` localement (dans le répertoire racine du projet) :

   ```pwsh
   php artisan key:generate --show
   # Copiez la valeur renvoyée (ex: base64:...)
   ```

   2) Définir les secrets Fly (exemples) :

   ```pwsh
   flyctl secrets set APP_KEY="base64:..."
   flyctl secrets set DB_HOST="host_from_planetscale"
   flyctl secrets set DB_DATABASE="your_database"
   flyctl secrets set DB_USERNAME="your_user"
   flyctl secrets set DB_PASSWORD="your_password"
   flyctl secrets set MAIL_USERNAME="..." MAIL_PASSWORD="..."
   ```

   Remarques PlanetScale:
   - PlanetScale utilise parfois des certificats et des connexions sans `GRANT` pour les utilisateurs ; suivez leur doc pour la configuration TLS.

   Déploiement frontend (Vercel)
   -----------------------------

   Si vous utilisez Vercel :
   - Créez le projet Vercel et récupérez `VERCEL_TOKEN`, `VERCEL_PROJECT_ID` et `VERCEL_ORG_ID`.
   - Dans GitHub, ajoutez les secrets `VERCEL_TOKEN`, `VERCEL_PROJECT_ID`, `VERCEL_ORG_ID`.
   - Le workflow `.github/workflows/frontend-vercel.yml` construit `Front1` et déploie automatiquement.


4) Migrations
   - Après déploiement, exécutez les migrations: `fly ssh console -C "php artisan migrate --force"` ou via un job de release.

5) Frontend (Vercel)
   - Dans le dossier `Front1`, vérifiez que `package.json` contient un script `build` (ex: `vite build` ou `npm run build`).
   - Créez un projet sur Vercel et connectez-le à votre repo GitHub; configurez les variables publiques (API base URL).
   - Vercel build automatiquement et déploie le frontend.

Commandes utiles (local):

```pwsh
# Construire et lancer en local (docker-compose)
docker compose up --build

# Builder le frontend
cd Front1
npm install
npm run build
```

Notes:
- Si vous préférez Railway ou Render au lieu de Fly, je peux adapter le workflow CI/CD.
- Pensez à ajouter `APP_KEY` dans Fly (ex: `php artisan key:generate --show`) et autres secrets.

Déploiement sur Render et Railway
---------------------------------

Render (via Dockerfile)
- Créez un compte sur Render et un nouveau service de type `Web Service`.
- Sélectionnez `Docker` comme environnement et pointez le `Dockerfile` à la racine (`./Dockerfile`).
- Branche: `main` (ou la branche que vous déployez)
- Variables d'environnement et secrets à ajouter dans le dashboard Render:
   - `APP_KEY` (secret)
   - `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (secrets)
   - `APP_ENV=production` (non-secret)
   - `PORT=8080` (optionnel — le `Dockerfile` expose 8080)

Exemple simplifié local (build image Docker puis tester):

```pwsh
docker build -t culture-benin:latest .
docker run -p 8080:8080 --env APP_KEY="base64:..." --env DB_HOST="..." culture-benin:latest
```

Railway
- Railway accepte les projets Docker ou une `Procfile`. Ce dépôt contient un `Dockerfile`, donc la manière la plus fiable est d'utiliser Docker.
- Alternativement vous pouvez ajouter un `Procfile` à la racine pour que Railway utilise la commande de démarrage sans Docker (ex: `php artisan serve`).

Procfile (exemple) :

```
web: php artisan serve --host=0.0.0.0 --port $PORT
```

- Dans Railway dashboard, ajoutez les variables d'environnement (secrets) `APP_KEY`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Pour une base PlanetScale, suivez la doc PlanetScale pour la configuration TLS et la chaîne de connexion.

Remarques finales
- Préférez Docker (present dans ce repo) pour un comportement identique en local et en production.
- Si vous voulez, je peux générer un `render.yaml` (déclaratif) et ajouter des workflows GitHub Actions pour automatiser les déploiements vers Render ou Railway.


#!/bin/bash
set -e

echo "✅ Début du script Laravel"

# Variables
APP_PATH=/var/www/html
PUBLIC_PATH=$APP_PATH/public
STORAGE_PATH=$APP_PATH/storage

# Se placer dans le répertoire principal
cd $APP_PATH

# Installer les dépendances PHP si besoin (composer déjà dans l'image)
if [ -f composer.json ] && [ "$SKIP_COMPOSER" != "1" ]; then
    echo "📦 Installation des dépendances PHP..."
    composer install --no-dev --optimize-autoloader
fi

# Vérifier et générer la clé d'application si elle n'existe pas
if [ -z "$APP_KEY" ]; then
    echo "🔑 Génération de la clé Laravel..."
    php artisan key:generate
fi

# Nettoyer caches et config
echo "🧹 Nettoyage du cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimiser la config et le cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
echo "🗄️ Exécution des migrations..."
php artisan migrate --force

# Seeder langue (si nécessaire)
if [ "$RUN_SEEDERS" == "1" ]; then
    echo "🌐 Seeders en cours..."
    php artisan db:seed --class=LangueSeeder
fi

# Permissions sur storage et bootstrap/cache
echo "🔧 Ajustement des permissions..."
chown -R www-data:www-data $STORAGE_PATH $APP_PATH/bootstrap/cache
chmod -R 775 $STORAGE_PATH $APP_PATH/bootstrap/cache

echo "✅ Script Laravel terminé"

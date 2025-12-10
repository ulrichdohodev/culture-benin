#!/usr/bin/env bash
set -e  # Stoppe le script si une commande échoue

echo "==> Setting up directories and permissions..."
mkdir -p /var/www/html/storage/logs \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/views \
         /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Installing Composer dependencies..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader --no-interaction

echo "==> Running package discovery..."
php /var/www/html/artisan package:discover

echo "==> Caching config..."
php /var/www/html/artisan config:cache

echo "==> Caching routes..."
php /var/www/html/artisan route:cache

echo "==> Running migrations..."
php /var/www/html/artisan migrate --force --seed

echo "==> Deployment script finished."
echo "==> Application is ready!"

php -S 0.0.0.0:$PORT -t /var/www/html/public

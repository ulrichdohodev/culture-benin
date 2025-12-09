#!/usr/bin/env bash
set -euo pipefail

echo "Starting deployment script"

# Composer
composer install --no-dev --prefer-dist --optimize-autoloader

# Migrations (force en prod)
php artisan migrate --force

# Clear & cache config/routes/views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage symlink
php artisan storage:link || true

# Ensure permissions (adjust for your server user/group)
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

echo "Deployment script finished"

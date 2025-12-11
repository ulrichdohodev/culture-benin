#!/bin/bash
set -e

echo "==> Culture Benin - Deployment Script Starting..."

echo "==> Setting up directories and permissions..."
mkdir -p /var/www/html/storage/logs \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/app/public \
         /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Waiting for database to be ready..."
max_tries=30
count=0
until php /var/www/html/artisan db:show 2>/dev/null || [ $count -eq $max_tries ]; do
  echo "Database not ready yet... attempt $((count+1))/$max_tries"
  count=$((count+1))
  sleep 2
done

if [ $count -eq $max_tries ]; then
  echo "WARNING: Could not connect to database after $max_tries attempts"
  echo "Continuing anyway..."
fi

echo "==> Running package discovery..."
php /var/www/html/artisan package:discover --ansi

if [ -z "$APP_KEY" ]; then
  echo "==> Generating APP_KEY..."
  php /var/www/html/artisan key:generate --force
fi

echo "==> Optimizing application..."
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache

echo "==> Running database migrations..."
php /var/www/html/artisan migrate --force

echo "==> Seeding database (if needed)..."
php /var/www/html/artisan db:seed --force --class=RoleSeeder || echo "RoleSeeder already run"
php /var/www/html/artisan db:seed --force --class=LangueSeeder || echo "LangueSeeder already run"
php /var/www/html/artisan db:seed --force --class=RegionSeeder || echo "RegionSeeder already run"

echo "==> Creating storage link..."
php /var/www/html/artisan storage:link || echo "Storage link already exists"

echo "==> Deployment script finished successfully!"
echo "==> Culture Benin is ready to serve!"

#!/bin/sh
# Release script executed by Fly after deploying the new image.
# It runs database migrations in production.

set -e

echo "Running migrations..."
php artisan migrate --force --no-interaction

echo "Migrations completed."

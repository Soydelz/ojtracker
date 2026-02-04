#!/usr/bin/env bash
# Render.com build script

set -o errexit

# Install Composer dependencies
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install NPM dependencies and build assets
npm ci
npm run build

# Clear and cache Laravel config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"

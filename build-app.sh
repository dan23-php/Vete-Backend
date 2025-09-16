#!/usr/bin/env bash
set -e

# install PHP deps
composer install --no-dev --prefer-dist --optimize-autoloader

# build JS/CSS if present
if [ -f package.json ]; then
  npm ci
  npm run build || true
fi

# clear & cache laravel configs
php artisan config:clear || true
php artisan cache:clear || true

# cache for performance (safe in production)
php artisan route:cache || true
php artisan config:cache || true
php artisan view:cache || true

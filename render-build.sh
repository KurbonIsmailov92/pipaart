#!/usr/bin/env bash
set -euo pipefail

composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
npm ci
npm run build

php artisan optimize:clear || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

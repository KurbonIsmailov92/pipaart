#!/bin/sh
set -e

if [ "${APP_ENV:-production}" = "production" ]; then
  if [ "${DB_CONNECTION:-pgsql}" = "sqlite" ]; then
    echo "ERROR: DB_CONNECTION=sqlite is not allowed in production. Configure PostgreSQL before deploy." >&2
    exit 1
  fi

  if [ -z "${DATABASE_URL:-}" ] && [ -z "${DB_HOST:-}" ]; then
    echo "ERROR: PostgreSQL is not configured. Set DATABASE_URL or DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD." >&2
    exit 1
  fi
fi

php artisan optimize:clear || true
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

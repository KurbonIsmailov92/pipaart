#!/bin/sh
set -e

cd /var/www/html

mkdir -p \
  storage/framework/views \
  storage/framework/cache \
  storage/framework/cache/data \
  storage/framework/sessions \
  bootstrap/cache

a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork || true

apache2ctl -M | grep mpm || true

ensure_app_key() {
  if [ -n "${APP_KEY:-}" ]; then
    echo "APP_KEY loaded from environment"
    return 0
  fi

  if [ -f .env ] && grep -q '^APP_KEY=.+' .env; then
    echo "APP_KEY loaded from .env"
    return 0
  fi

  echo "ERROR: APP_KEY is missing." >&2
  echo "Set APP_KEY in the environment or in .env before starting the container." >&2

  if [ "${APP_ENV:-production}" = "production" ]; then
    echo "Production startup aborted to avoid generating a new runtime application key." >&2
  fi

  exit 1
}

ensure_app_key

if [ "${APP_ENV:-production}" = "production" ]; then
  if [ "${DB_CONNECTION:-pgsql}" = "sqlite" ]; then
    echo "ERROR: DB_CONNECTION=sqlite is not allowed in production. Configure PostgreSQL before startup." >&2
    exit 1
  fi

  if [ -z "${DATABASE_URL:-}" ] && [ -z "${DB_HOST:-}" ]; then
    echo "ERROR: PostgreSQL is not configured. Set DATABASE_URL or DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD." >&2
    exit 1
  fi
fi

php artisan optimize:clear || true
php artisan storage:link || true
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

sed -ri "s/Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/:([0-9]+)>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground

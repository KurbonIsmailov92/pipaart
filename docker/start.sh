#!/bin/sh
set -e

cd /var/www/html

a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork || true

apache2ctl -M | grep mpm || true

ensure_app_key() {
  if [ -n "$APP_KEY" ]; then
    echo "APP_KEY loaded from environment"
    return 0
  fi

  if [ -f .env ] && grep -q '^APP_KEY=.+' .env; then
    echo "APP_KEY loaded from .env"
    return 0
  fi

  if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
  fi

  GENERATED_APP_KEY="$(php -r 'echo "base64:".base64_encode(random_bytes(32));')"

  if [ -f .env ] && grep -q '^APP_KEY=' .env; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${GENERATED_APP_KEY}|" .env
  else
    printf '\nAPP_KEY=%s\n' "$GENERATED_APP_KEY" >> .env
  fi

  echo "WARNING: APP_KEY was missing. Generated a runtime APP_KEY; set a persistent APP_KEY in Railway Variables."
}

ensure_app_key

php artisan optimize:clear || true

if [ ! -L /var/www/html/public/storage ]; then
  php artisan storage:link || true
fi

sed -ri "s/Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/:([0-9]+)>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground

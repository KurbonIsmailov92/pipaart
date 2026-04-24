#!/bin/sh
set -e

a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork || true

apache2ctl -M | grep mpm || true

if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is not set"
  exit 1
fi

if [ ! -L /var/www/html/public/storage ]; then
  php artisan storage:link || true
fi

sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground

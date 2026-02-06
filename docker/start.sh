#!/usr/bin/env bash
set -euo pipefail

if [ -f /var/www/html/artisan ]; then
  php /var/www/html/artisan config:cache || true
  php /var/www/html/artisan route:cache || true
  php /var/www/html/artisan view:cache || true
fi

exec apache2-foreground

#!/usr/bin/env bash

# Установка Composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
php artisan serve --host 0.0.0.0 --port $PORT

# Выполнение миграций
php artisan migrate --force

# Кэширование конфигурации
php artisan config:cache
php artisan route:cache
php artisan view:cache


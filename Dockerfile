# Указываем базовый образ с PHP и Composer
FROM composer:2 AS builder

# Устанавливаем рабочую директорию
WORKDIR /app

# Копируем файлы проекта
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader

# Сборка окончательного образа
FROM php:8.1-apache

# Копируем файлы из предыдущего контейнера
COPY --from=builder /app /var/www/html

# Устанавливаем права на storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Указываем рабочую директорию
WORKDIR /var/www/html

# Экспортируем порт
EXPOSE 80

# Старт приложения
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]

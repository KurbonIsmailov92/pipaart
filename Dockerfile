# Указываем базовый образ с PHP и Apache
FROM php:8.2-apache

# Обновляем пакеты и устанавливаем необходимые расширения PHP
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем все файлы в контейнер
COPY . .

# Создаём файл .env
RUN cp .env.example .env

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader

# Генерация ключа приложения
RUN php artisan key:generate

# Настройка прав для storage и bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Открываем порт
EXPOSE 80

FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

RUN php artisan config:clear

EXPOSE 10000

CMD php artisan config:clear && php artisan cache:clear && php artisan migrate:fresh --force && php artisan serve --host=0.0.0.0 --port=10000# CMD php artisan migrate:fresh --force && php artisan serve --host=0.0.0.0 --port=10000
FROM composer:2 AS composer

WORKDIR /app

COPY . /app

RUN composer install --no-dev && composer dump-autoload --optimize

FROM node:slim AS node

WORKDIR /app

COPY . /app

RUN npm install && npm run build

FROM php:8.2-apache

COPY --chown=www-data:www-data --from=composer /app /var/www/html/
COPY --chown=www-data:www-data --from=node /app/public/build /var/www/html/public/build

RUN apt-get update && \
    apt-get install -y \
    zip \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install \
    pdo_mysql \
    && docker-php-ext-enable \
    pdo_mysql

RUN a2enmod rewrite && \
    sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN cp .env.example .env
RUN php artisan key:generate && php artisan storage:link && php artisan optimize && php artisan migrate:fresh

EXPOSE 80

CMD ["apache2-foreground"]

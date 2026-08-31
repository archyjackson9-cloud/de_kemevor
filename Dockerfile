# Build PHP dependencies
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts

COPY . .

RUN composer dump-autoload --optimize --no-dev --no-scripts


# Production PHP container
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    linux-headers \
    && docker-php-ext-install \
        bcmath \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        zip

WORKDIR /var/www

COPY --from=vendor /app /var/www

RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/php/production.ini /usr/local/etc/php/conf.d/production.ini

EXPOSE 9000

CMD ["php-fpm", "-F"]
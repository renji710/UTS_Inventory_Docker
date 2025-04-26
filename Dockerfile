FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    build-base linux-headers \
    $PHPIZE_DEPS \
    libzip-dev zlib-dev oniguruma-dev \
    icu-dev \
    mariadb-client \
    libpng-dev libjpeg-turbo-dev freetype-dev libwebp-dev \
    curl git unzip

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    gd \
    exif \
    bcmath \
    opcache \
    intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1


COPY src/composer.json src/composer.lock ./

RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --optimize-autoloader

COPY src/ .


RUN composer dump-autoload --optimize

# RUN php artisan config:cache ...

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
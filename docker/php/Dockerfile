FROM php:8.3-fpm-alpine

# Dépendances système
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    linux-headers \
    $PHPIZE_DEPS

# Extensions PHP nécessaires pour Symfony
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    opcache \
    mbstring \
    sysvsem

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Config PHP
COPY php.ini /usr/local/etc/php/conf.d/app.ini

WORKDIR /var/www/html
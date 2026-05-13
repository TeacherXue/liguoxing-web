FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        unzip \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        mysqli \
        pdo_mysql \
        mbstring \
        xml \
        zip \
        intl \
        curl \
        bcmath \
        exif \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY .docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/php/php.ini /usr/local/etc/php/conf.d/eyoucms.ini

WORKDIR /var/www/html

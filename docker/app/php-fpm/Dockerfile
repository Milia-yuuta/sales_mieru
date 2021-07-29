FROM php:8.0.3-fpm-alpine

#app source
WORKDIR /var/www/html
COPY . /var/www/html

COPY ./docker/app/php-fpm/ini/php.ini /usr/local/etc/php/php.ini

# install dependent packages...
RUN apk update \
  && apk add --no-cache libzip-dev icu-libs zlib-dev \
  && apk add --no-cache zip unzip \
  && apk add --no-cache --virtual build-dependencies icu-dev \
  && apk add --no-cache freetype-dev libjpeg-turbo-dev libmcrypt-dev libpng-dev \
  && docker-php-ext-install zip intl pdo_mysql gd

# provide root permission to composer
ENV COMPOSER_ALLOW_SUPERUSER 1 \
    COMPOSER_NO_INTERACTION 1

# install composer...
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN set -xeu \
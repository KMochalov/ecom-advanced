FROM php:8.2-fpm-alpine

RUN apk update \
    && apk add --update linux-headers \
    && apk add autoconf g++ make \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY  ./common/php/conf.d /usr/local/etc/php/conf.d
COPY  ./develop/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

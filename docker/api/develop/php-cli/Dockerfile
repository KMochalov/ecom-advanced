FROM php:8.2-cli-alpine

RUN apk update \
    && apk add --update linux-headers \
    && apk add autoconf g++ make \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN apk update && apk add unzip

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY  ./common/php/conf.d /usr/local/etc/php/conf.d
COPY  ./develop/php/conf.d /usr/local/etc/php/conf.d

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
     --no-plugins --no-scripts \
    && rm -rf /root/.composer/cache

WORKDIR /app

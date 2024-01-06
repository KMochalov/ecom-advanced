FROM php:8.2-fpm-alpine as Builder

RUN apk update && apk add unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && composer global require hirak/prestissimo --no-plugins --no-script \
    && rm -rf /root/.composer/cache

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --no-dev --prefer-dist --no-progress --no-suggest --no-script --optimize-autoloader \
    && rm -rf /root/.composer/cache

### Собираем чистый образ без ненужного мусора типа композера и анзипа

FROM php:8.2-fpm-alpine

RUN docker-php-ext-install opcache

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/prod/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

COPY --from=Builder /app ./
COPY ./ ./
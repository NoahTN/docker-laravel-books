ARG LARAVEL_PATH=/var/www/html

FROM composer:1.9.3 AS composer
ARG LARAVEL_PATH

COPY src/composer.json $LARAVEL_PATH
COPY src/composer.lock $LARAVEL_PATH
RUN composer install --working-dir $LARAVEL_PATH --ignore-platform-reqs --no-progress --no-autoloader --no-scripts

COPY src $LARAVEL_PATH
RUN composer install --working-dir $LARAVEL_PATH --ignore-platform-reqs --no-progress --optimize-autoloader

FROM php:7.4-apache
ARG LARAVEL_PATH

RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install \
        pdo_mysql \
        zip

ENV APACHE_DOCUMENT_ROOT $LARAVEL_PATH/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN mkdir -p /root/.composer
COPY --from=composer /tmp/cache /root/.composer/cache

RUN pecl install xdebug-2.9.2 \
	&& docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer $LARAVEL_PATH $LARAVEL_PATH

RUN chown -R www-data $LARAVEL_PATH/storage

RUN COMPOSER_MEMORY_LIMIT=-1 composer require --dev laravel/dusk \
    && php artisan dusk:install

RUN apt-get install -y npm \
    && apt-get install -y libxpm4 \
    && apt-get install -y libxrender1 \
    && apt-get install -y libgtk2.0-0 \
    && apt-get install -y libnss3 \
    && apt-get install -y libgconf-2-4 \
    && apt-get install -y wget

RUN wget --no-verbose -O /tmp/chrome.deb https://dl.google.com/linux/chrome/deb/pool/main/g/google-chrome-stable/google-chrome-stable_114.0.5735.90-1_amd64.deb \
    && apt install -y /tmp/chrome.deb \
    && rm /tmp/chrome.deb

RUN COMPOSER_MEMORY_LIMIT=-1  composer require  --dev laravel/ui:^1.0 \
    && php artisan ui react

WORKDIR $LARAVEL_PATH
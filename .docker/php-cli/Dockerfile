FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y \
        libicu-dev \
        libzip-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        unzip \
    && docker-php-ext-configure \
        gd --with-jpeg \
    && docker-php-ext-install \
        bcmath \
        pdo_mysql \
        pcntl \
        zip \
        intl \
        gd \
    && docker-php-ext-configure \
        intl

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions xdebug-stable

COPY php-cli/default.ini /usr/local/etc/php/conf.d/default.ini

COPY php-cli/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /var/www/app
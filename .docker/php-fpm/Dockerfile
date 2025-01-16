FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -y \
        libicu-dev \
        libssh-dev \
        libzip-dev \
        libpng-dev \
        unzip \
        wget \
        cron \
        rsyslog \
    && docker-php-ext-install \
        bcmath \
        sockets \
        pcntl \
        zip \
        intl \
        sockets \
        pdo_mysql \
        gd \
    && docker-php-ext-configure \
        intl

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions xdebug-stable

COPY php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

COPY php-fpm/default.ini /usr/local/etc/php/conf.d/default.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /var/www/app

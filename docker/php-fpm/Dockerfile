FROM php:8.0.12-fpm

WORKDIR /application

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN ln -snf /usr/share/zoneinfo/Europe/Warsaw /etc/localtime
RUN echo Europe/Warsaw > /etc/timezone

RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    vim \
    git \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    librabbitmq-dev \
    libssh-dev \
    libpng-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd \
    --with-freetype

RUN docker-php-ext-install \
    zip \
    intl \
    opcache \
    bcmath \
    sockets \
    pdo pdo_mysql \
    gd

RUN pecl install \
    apcu \
    amqp

RUN docker-php-ext-enable \
    opcache \
    apcu \
    amqp

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Alias
RUN echo 'alias sf="bin/console"' >> ~/.bashrc

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/php-ini-overrides.ini

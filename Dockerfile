FROM php:7.4.13-fpm-alpine

# composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN set -eux && \
  apk update && \
  apk add --update --no-cache --virtual=.build-dependencies \
    mysql \
    autoconf \
    gcc \
    g++ \
    make \
    git && \
  apk add --update --no-cache \
    icu-dev \
    libpng-dev \
    libzip-dev && \
  docker-php-ext-install pdo pdo_mysql && \
  docker-php-ext-install gd && \
  docker-php-ext-install zip && \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENV PHPREDIS_VERSION 3.1.4

RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/$PHPREDIS_VERSION.tar.gz  \
    && mkdir /tmp/redis \
    && tar -xf /tmp/redis.tar.gz -C /tmp/redis \
    && rm /tmp/redis.tar.gz \
    && ( \
    cd /tmp/redis/phpredis-$PHPREDIS_VERSION \
    && phpize \
        && ./configure \
    && make -j$(nproc) \
        && make install \
    ) \
    && rm -r /tmp/redis \
    && docker-php-ext-enable redis

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions imagick
RUN docker-php-ext-enable imagick
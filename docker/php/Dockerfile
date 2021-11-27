FROM php:8.0-fpm

# php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/

ENV APP_DIR=/var/www
WORKDIR ${APP_DIR}

# packages
RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
  && docker-php-ext-install zip pdo_mysql

# php extensions & composer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
  && sync \
  && install-php-extensions @composer

# app files
COPY --chown=www-data:www-data ../../src ${APP_DIR}
RUN chmod -R 777 ${APP_DIR}/

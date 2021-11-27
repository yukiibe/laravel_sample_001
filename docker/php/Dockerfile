FROM php:8.0-fpm
COPY ./docker/php/php.ini /usr/local/etc/php/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

ENV APP_DIR=/var/www
WORKDIR ${APP_DIR}

# composer
RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
  && docker-php-ext-install zip pdo_mysql \
  && chmod +x /usr/local/bin/install-php-extensions \
  && sync \
  && install-php-extensions @composer

# app files
COPY --chown=www-data:www-data ../../src ${APP_DIR}
RUN chmod -R 755 ${APP_DIR}/storage
RUN chmod -R 755 ${APP_DIR}/storage/logs
RUN chmod -R 755 ${APP_DIR}/storage/logs/laravel.log

FROM php:8.0-fpm

# php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/

# packages
RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
  && docker-php-ext-install zip pdo_mysql

# php extensions & composer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
  && sync \
  && install-php-extensions @composer

# create user
RUN groupadd --gid 1000 ubuntu \
  && useradd --uid 1000 --gid 1000 -m ubuntu
RUN chmod 755 /home/ubuntu
RUN su - ubuntu -c "umask 022"
RUN echo "" >> /home/ubuntu/.bashrc
RUN echo "umask 022" >> /home/ubuntu/.bashrc

# app files
RUN mkdir -p -m 755 /var/www/
RUN mkdir -p -m 755 /var/www/vhosts
RUN mkdir -p -m 755 /var/www/vhosts/laravel-sample-001
RUN chown -R ubuntu:ubuntu /var/www/vhosts/laravel-sample-001

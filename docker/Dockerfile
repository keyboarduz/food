FROM php:7.3-apache

# Install required libs
RUN apt-get update && \
    apt-get install -y \
        libpng-dev \
        libmcrypt-dev \
        libmagickwand-dev --no-install-recommends \
    && apt-get clean

RUN pecl install mcrypt-1.0.2
RUN docker-php-ext-enable mcrypt

RUN printf "\n" | pecl install imagick

RUN docker-php-ext-enable imagick

#
# Install extensions
#
RUN docker-php-ext-install \
    ctype \
    mbstring \
    pdo_mysql \
    bcmath \
    gd \
    && a2enmod \
    rewrite

RUN chown -R www-data:www-data /var/www/html/
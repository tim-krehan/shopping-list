# Use the official PHP image as the base image
ARG PHP_VERSION=8.4
FROM php:${PHP_VERSION}-apache

# Define application version as a build argument
ARG APP_VERSION=0.0.1

# Install required PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libbz2-dev \
    libcurl4-openssl-dev \
    libpng-dev \
    libxml2-dev \
    libedit-dev \
    libreadline-dev \
    libzip-dev \
    libonig-dev

RUN docker-php-ext-install \
    bz2 \
    curl \
    gd \
    mbstring \
    mysqli \
    # opcache \
    # readline \
    xml \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite module
RUN a2enmod rewrite

# Copy necessary directories from the repository root
COPY 3rd-party /var/www/html/3rd-party
COPY config /var/www/html/config
COPY cont /var/www/html/cont
COPY install /var/www/html/install
COPY js /var/www/html/js
COPY php /var/www/html/php
COPY pic /var/www/html/pic
COPY style /var/www/html/style

# Copy necessary files from the repository root
COPY AUTHORS /var/www/html/AUTHORS
COPY LICENSE /var/www/html/LICENSE
COPY README.md /var/www/html/README.md
COPY index.php /var/www/html/index.php
COPY version.json /var/www/html/version.json
COPY version.php /var/www/html/version.php
COPY web.config /var/www/html/web.config
COPY .htaccess /var/www/html/.htaccess

# Set permissions for the config directory
RUN chown -R www-data:www-data /var/www/html/config && chmod -R 775 /var/www/html/config

LABEL APP_VERSION=${APP_VERSION}

# Expose port 80
EXPOSE 80

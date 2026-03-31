FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libssl-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    pkg-config \
    zip \
    unzip \
    git \
    g++ \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    mbstring \
    opcache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN mkdir -p /var/www/html/var/cache \
             /var/www/html/var/log \
             /var/www/html/var/sessions \
    && chown -R www-data:www-data /var/www/html/var

ENV APP_ENV=dev
ENV APP_DEBUG=1

RUN composer install \
    --no-interaction

ENV DATABASE_URL="mysql://root:root@db:3308/symfony?serverVersion=mariadb-10.6"

WORKDIR /var/www/html

EXPOSE 81

CMD ["apache2-foreground"]

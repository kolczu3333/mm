FROM php:8.2-fpm

# Instalujemy niezbędne pakiety
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libcurl4-openssl-dev pkg-config libevent-dev libz-dev libicu-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Instalujemy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ustawiamy katalog roboczy
WORKDIR /var/www/html

CMD ["php-fpm"]

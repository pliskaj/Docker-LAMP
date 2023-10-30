FROM php:8.2-fpm

# Instalujeme zavislosti pro sestaveni PHP modulu
RUN apt update && \
    apt install -y zip libzip-dev libpng-dev libicu-dev libxml2-dev

# Instalujeme dodatecne PHP moduly
RUN docker-php-ext-install mysqli pdo pdo_mysql gd zip intl xml

# Uklidime APT cache
RUN apt clean
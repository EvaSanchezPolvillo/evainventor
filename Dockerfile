# Usa la imagen base de PHP con Apache
FROM php:8.1-apache

# Instala las extensiones necesarias para MySQL y otras dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql

# Configura el documento raíz para Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Habilita el módulo de reescritura de Apache (necesario para Laravel)
RUN a2enmod rewrite

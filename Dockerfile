FROM php:8.4-fpm-alpine

# Dependencias del sistema
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev

# Extensiones PHP necesarias para Laravel
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    intl \
    zip

# Instalar Composer (oficial)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar composer files primero (mejor cache)
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Copiar el resto del proyecto
COPY . .

# Permisos Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]

FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

FROM php:8.4-fpm-alpine

# Paquetes del sistema necesarios
RUN apk add --no-cache \
    bash \
    curl \
    git \
    nginx \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    libxml2-dev

# Extensiones PHP requeridas por Laravel 12
RUN docker-php-ext-install \
    bcmath \
    mbstring \
    pdo \
    pdo_mysql \
    xml \
    zip \
    intl

# Composer oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Cache de dependencias
COPY composer.json composer.lock ./

# Instalar dependencias (modo CI)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Código fuente
COPY . .

COPY --from=assets /app/public/build /var/www/html/public/build

# Permisos Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]

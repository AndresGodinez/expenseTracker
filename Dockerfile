FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    mysql-client \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www/html

COPY . .
RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate || true

COPY docker/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]

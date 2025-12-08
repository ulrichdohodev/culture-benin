FROM composer:2 AS builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts
COPY . /app

FROM php:8.1-cli
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
 && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd
COPY --from=builder /app /var/www
RUN chown -R www-data:www-data /var/www
ENV PORT=8080
EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]

# Étape 1 : Installer les dépendances PHP via Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts --optimize-autoloader
COPY . /app

RUN apk add --no-cache dos2unix \
    && find . -type f -name "*.sh" -exec dos2unix {} \;

# Étape 2 : Compiler les assets front (Vite)
FROM node:18-alpine AS assets
WORKDIR /app/Front1
COPY Front1/package*.json ./
RUN npm ci --silent
COPY Front1/ ./
RUN npm run build

# Étape 3 : Image finale PHP + Nginx + supervisord
FROM php:8.2-fpm

# Installer les extensions et utilitaires nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
 && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
 && rm -rf /var/lib/apt/lists/*

# Configurer PHP-FPM pour écouter sur TCP
RUN sed -i "s/listen = .*/listen = 9000/" /usr/local/etc/php-fpm.d/www.conf

# Copier le code Laravel et les assets compilés
WORKDIR /var/www
COPY --from=vendor /app /var/www
COPY --from=assets /app/Front1/public/build /var/www/public/build

# Copier les configs Nginx et supervisord
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permissions
RUN chown -R www-data:www-data /var/www

# Variables d'environnement
ENV APP_ENV=production
ENV PORT=8080

EXPOSE 8080

# Démarrage via supervisord
CMD ["/usr/bin/supervisord", "-n"]

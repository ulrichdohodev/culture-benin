FROM node:22-alpine AS builder

WORKDIR /app

# Copy frontend files
COPY package.json package-lock.json postcss.config.js tailwind.config.js vite.config.js ./
COPY resources ./resources

# Install and build frontend assets
RUN npm install --legacy-peer-deps && npm run build

# Stage final : Laravel + Nginx + PHP
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copier le code de l'application
COPY . /var/www/html

# Copier les assets buildés depuis le stage builder
COPY --from=builder /app/public/build /var/www/html/public/build

# Configuration de l'image
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=0
ENV REAL_IP_HEADER=1

# Configuration Laravel (sans secrets embarqués)
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Permissions nécessaires
RUN chown -R nginx:nginx /var/www/html \
	&& chmod -R 755 /var/www/html/storage \
	&& chmod -R 755 /var/www/html/bootstrap/cache

# Copier le script de déploiement
COPY 00-laravel-script.sh /00-laravel-script.sh
RUN chmod +x /00-laravel-script.sh

# Forcer la configuration Nginx Laravel (root + try_files)
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx.conf /etc/nginx/sites-enabled/default.conf

# Exposer le port
EXPOSE 8080

# Démarrage : script Laravel puis entrypoint de l'image
CMD ["/bin/bash", "-c", "/00-laravel-script.sh && /start.sh"]

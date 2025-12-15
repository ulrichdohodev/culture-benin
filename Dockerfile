FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copier le code de l'application
COPY . /var/www/html

# Installer Node.js v22 pour builder le frontend (vite@7.x requiert Node >=20.19.0 ou >=22.12.0)
RUN apk add --no-cache nodejs npm curl && curl -sL https://deb.nodesource.com/setup_22.x | bash - && apk del nodejs npm && apk add --no-cache nodejs npm

# Configuration de l'image
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Configuration Laravel (sans secrets embarqués)
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Builder les assets frontend
RUN npm install && npm run build

# Permissions nécessaires
RUN chown -R nginx:nginx /var/www/html \
	&& chmod -R 755 /var/www/html/storage \
	&& chmod -R 755 /var/www/html/bootstrap/cache

# Copier le script de déploiement
COPY 00-laravel-script.sh /00-laravel-script.sh
RUN chmod +x /00-laravel-script.sh

# Exposer le port
EXPOSE 8080

# Démarrage : script Laravel puis entrypoint de l'image
CMD ["/bin/bash", "-c", "/00-laravel-script.sh && /start.sh"]

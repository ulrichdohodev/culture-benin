FROM richarvey/nginx-php-fpm:3.1.6

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code backend Laravel
COPY . /var/www/html

# Installer les dépendances frontend si nécessaire
# Si tu as un package.json dans Front1
# COPY Front1/package*.json /var/www/html/Front1/
# RUN cd Front1 && npm install && npm run build

# Copier le script de déploiement
COPY 00-laravel-script.sh /00-laravel-script.sh

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Rendre le script exécutable   
RUN chmod +x /00-laravel-script.sh

# Exécuter le script au démarrage
CMD ["/bin/bash", "-c", "/00-laravel-script.sh && /start.sh"]

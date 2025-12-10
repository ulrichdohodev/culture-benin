# Base image avec PHP + FPM + Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tout le backend Laravel
COPY . /var/www/html

# Installer les dépendances frontend et générer le build Vite
# Si ton frontend est dans Front1
WORKDIR /var/www/html/Front1
RUN npm install
RUN npm run build

# Copier le build Vite vers le dossier public de Laravel
RUN cp -r /var/www/html/Front1/public/build /var/www/html/public/build

# Retour au répertoire principal
WORKDIR /var/www/html

# Copier le script de déploiement Laravel
COPY 00-laravel-script.sh /00-laravel-script.sh

# Configuration de l'image
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Configuration Laravel
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Autoriser composer à s’exécuter en root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Rendre le script exécutable   
RUN chmod +x /00-laravel-script.sh

# Exposer le port 8080 (celui de nginx)
EXPOSE 8080

# Lancer le script Laravel puis démarrer Nginx + PHP-FPM
CMD ["/bin/bash", "-c", "/00-laravel-script.sh && /start.sh"]

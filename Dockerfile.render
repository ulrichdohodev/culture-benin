# -------------------------------------------------------
# IMAGE DE BASE
# -------------------------------------------------------
FROM richarvey/nginx-php-fpm:3.1.6

# -------------------------------------------------------
# VARIABLES D'ENVIRONNEMENT
# -------------------------------------------------------
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV RUN_SEEDERS=1   # active l'exécution du LangueSeeder
ENV NODE_ENV=production

# -------------------------------------------------------
# COPIER LE CODE DE L'APPLICATION
# -------------------------------------------------------
COPY . /var/www/html

# -------------------------------------------------------
# COPIER LE SCRIPT DE DÉPLOIEMENT
# -------------------------------------------------------
COPY 00-laravel-script.sh /00-laravel-script.sh
RUN chmod +x /00-laravel-script.sh

# -------------------------------------------------------
# INSTALLER LES DÉPENDANCES FRONT (Vite)
# -------------------------------------------------------
# Installer Node.js si l'image de base ne l'inclut pas
RUN apt-get update && \
    apt-get install -y curl build-essential && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# -------------------------------------------------------
# INSTALLER LES DÉPENDANCES FRONT ET BUILD
# -------------------------------------------------------
WORKDIR /var/www/html
RUN if [ -f package.json ]; then \
        npm install && npm run build; \
    fi

# -------------------------------------------------------
# COMMAND DE DÉMARRAGE
# -------------------------------------------------------
# Démarre le script Laravel puis Nginx+PHP-FPM
CMD ["/bin/bash", "-c", "/00-laravel-script.sh && /start.sh"]

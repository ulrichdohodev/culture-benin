FROM richarvey/nginx-php-fpm:3.1.6

# Copier le code de l'application
COPY . /var/www/html

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
ENV APP_KEY="base64:xWAEZAIi3mvYfCNZVL09TWUrTKJstc8AGIlvU37SbdA="

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Rendre le script exécutable   
RUN chmod +x /00-laravel-script.sh

# Exécuter le script au démarrage
CMD ["/bin/bash", "-c", "/00-laravel-script.sh && /start.sh"]

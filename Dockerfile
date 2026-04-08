FROM php:8.2-apache

# Installer extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Activer mod_rewrite (important pour Laravel)
RUN a2enmod rewrite

# Copier le projet
COPY . /var/www/html

# Définir le bon dossier public Laravel
WORKDIR /var/www/html

# 👉 TRÈS IMPORTANT : pointer Apache vers /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Donner les permissions
RUN chown -R www-data:www-data /var/www/html
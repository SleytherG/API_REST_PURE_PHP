FROM php:8.2-apache

# Instalar extensiones requeridas (pgsql, pdo_pgsql)
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar el código al contenedor
COPY public/ /var/www/html/
COPY src/ /var/www/src/
COPY config/ /var/www/config/

# Habilitar el mod_rewrite de Apache si usas rutas limpias
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html /var/www/src /var/www/config

EXPOSE 80
CMD ["apache2-foreground"]

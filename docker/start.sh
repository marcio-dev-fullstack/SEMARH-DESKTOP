#!/bin/sh

# Define o diretório de trabalho
cd /var/www/html

# Prepara o ambiente Laravel
echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

# Inicia o PHP-FPM em background
php-fpm &

# Inicia o Nginx em foreground (para manter o container rodando)
echo "Starting Nginx..."
nginx -g "daemon off;"
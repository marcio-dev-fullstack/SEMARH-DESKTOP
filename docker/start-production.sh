#!/bin/sh

# Sai imediatamente se um comando falhar
set -e 

# Define o diretório de trabalho
cd /var/www/html 

# Ajusta as permissões para o Laravel poder escrever nos logs e cache
chown -R www-data:www-data storage bootstrap/cache 

# Executa as migrações do banco de dados ao iniciar o container
php artisan migrate --force 

# Inicia o PHP-FPM em background
php-fpm & 

# Inicia o Nginx em foreground para manter o container rodando
nginx -g "daemon off;" 
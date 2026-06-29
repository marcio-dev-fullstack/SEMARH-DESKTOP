#!/bin/sh

# Sai imediatamente se um comando falhar
set -e 

# Define o diretório de trabalho
cd /var/www/html 

# Executa as migrações do banco de dados ao iniciar o container
# Em um ambiente de produção real, considere executar isso como um job separado antes do deploy.
php artisan migrate --force 

# Inicia o Supervisor, que irá gerenciar o Nginx e o PHP-FPM
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
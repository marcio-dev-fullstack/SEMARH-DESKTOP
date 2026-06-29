# ==========================================
# ESTÁGIO 1: Construtor (Builder)
# ==========================================
FROM php:8.3-fpm-alpine AS builder

# Instala as dependências de compilação necessárias para as extensões PHP
RUN apk add --no-cache \
    build-base \
    git \
    curl \
    unzip \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    gd-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev

# Configura e instala extensões do PHP requeridas pelo Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql bcmath pcntl zip gd

# Copia o executável do Composer mais recente para dentro do container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Cria o usuário laravel para evitar problemas de permissão com o Composer
RUN addgroup -g 1000 laravel && adduser -u 1000 -G laravel -s /bin/sh -D laravel

# Copia apenas o arquivo de configuração de dependências
COPY --chown=laravel:laravel composer.json ./

# Instala as dependências do Composer sem rodar scripts ou plugins que dependam de arquivos ausentes
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader --no-plugins --no-scripts

# Copia o restante dos arquivos da aplicação
COPY --chown=laravel:laravel . .

# ==========================================
# ESTÁGIO 2: Produção (Final)
# ==========================================
FROM php:8.3-fpm-alpine AS production

# Instala apenas as bibliotecas de execução necessárias no ambiente final (Nginx, Supervisor e bibliotecas base do Postgres)
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-libs \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype

# Copia as extensões PHP já compiladas do estágio 'builder' (Evita o erro de falta do libpq-fe.h)
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

WORKDIR /var/www/html

# Cria o usuário www-data de execução de forma segura (se não existir no sistema Alpine)
RUN addgroup -g 101 -S www-data-group || true \
    && adduser -u 101 -S -G www-data-group www-data || true

# Copia os arquivos do projeto vindos do construtor com as permissões corretas
COPY --from=builder --chown=www-data:www-data /var/www/html .

# Copia as configurações do Nginx e Supervisor de forma condicional se existirem, ou cria estruturas básicas
COPY docker/nginx.conf* /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf* /etc/supervisor/conf.d/supervisord.conf
COPY docker/start-production.sh* /usr/local/bin/start.sh

# Garante permissões de escrita para pastas de armazenamento e logs do Laravel
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && if [ -f /usr/local/bin/start.sh ]; then chmod +x /usr/local/bin/start.sh; fi

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
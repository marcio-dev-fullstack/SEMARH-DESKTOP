################################################################################
# ESTÁGIO 1: Builder - Instala dependências e compila os assets
################################################################################
FROM php:8.3-fpm-alpine AS builder

ARG UID
ARG GID

# Instala dependências de sistema necessárias para a construção
RUN apk add --no-cache \
    build-base \
    git \
    curl \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    gd-dev freetype-dev libjpeg-turbo-dev libpng-dev

# Instala as extensões do PHP necessárias para o composer e a aplicação
RUN docker-php-ext-install pdo pdo_pgsql pgsql bcmath pcntl zip gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Cria um usuário para não rodar como root
RUN addgroup -g ${GID:-1000} laravel && \
    adduser -u ${UID:-1000} -G laravel -s /bin/sh -D laravel

# Copia os arquivos da aplicação e define as permissões
COPY --chown=laravel:laravel . .

# Muda para o usuário da aplicação
USER laravel

# Instala as dependências de produção do Composer
RUN composer install --no-interaction --no-progress --no-dev --optimize-autoloader

# Otimiza a aplicação para produção
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

################################################################################
# ESTÁGIO 2: Final - Cria a imagem de produção limpa e enxuta
################################################################################
FROM php:8.3-fpm-alpine AS production

# Instala APENAS as dependências de RUNTIME
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-libs # Note: -libs, não -dev

# Instala as extensões do PHP (sem as dependências de build)
RUN docker-php-ext-install pdo pdo_pgsql pgsql bcmath pcntl zip gd

WORKDIR /var/www/html

# Copia os arquivos da aplicação e as dependências do estágio 'builder'
COPY --from=builder /var/www/html .

# Copia o script de inicialização e o torna executável
COPY docker/start-production.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
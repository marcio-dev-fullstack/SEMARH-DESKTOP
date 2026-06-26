#!/bin/bash

# =============================================================================
# Script de Instalação Aprimorado para SEMARH Fiscaliza 1.0
#
# Versão: 1.1
# Autor: Gemini Code Assist
#
# Melhorias:
# - Adicionado 'set -e' para parar em caso de erro.
# - Verificação de versão do PHP.
# - Lógica de diretório mais robusta.
# - Verificações de sucesso mais explícitas.
# - Adicionado passo de permissões de pasta do Laravel.
# =============================================================================

# --- Configuração de Shell ---
# Sai imediatamente se um comando sair com um status diferente de zero.
set -e

# --- Configuração de Cores e Log ---
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # Sem Cor

log_success() { echo -e "${GREEN}✅ $1${NC}"; }
log_error() { echo -e "${RED}❌ ERRO: $1${NC}" >&2; }
log_info() { echo -e "${YELLOW}▶ $1${NC}"; }

# --- Funções de Verificação ---
check_command() {
    if ! command -v "$1" &> /dev/null; then
        log_error "Comando '$1' não encontrado. Por favor, instale-o e tente novamente."
        exit 1
    fi
}

check_php_version() {
    # Extrai a versão do PHP (ex: 8.3.5 -> 80305) e a versão mínima (8.3 -> 80300)
    CURRENT_VERSION=$(php -r 'echo PHP_VERSION_ID;')
    REQUIRED_VERSION_ID=80300 # PHP 8.3

    if [ "$CURRENT_VERSION" -lt "$REQUIRED_VERSION_ID" ]; then
        CURRENT_VERSION_STR=$(php -r 'echo PHP_VERSION;')
        log_error "Versão do PHP incompatível. Requerida: >= 8.3. Encontrada: $CURRENT_VERSION_STR"
        exit 1
    fi
}

# --- Início do Script ---
clear
echo "================================================="
echo "  Instalador do SEMARH Fiscaliza 1.0 (v1.1)"
echo "================================================="
echo

# 1. Verificação de Dependências
log_info "Verificando dependências..."
check_command "git"
check_command "php"
check_php_version
check_command "composer"
log_success "Todas as dependências foram encontradas e são compatíveis!"
echo

# 2. Clonar o Repositório
REPO_URL="https://github.com/marcio-dev-fullstack/SEMARH-DESKTOP.git"
PROJECT_DIR="SEMARH-DESKTOP"

if [ ! -d "$PROJECT_DIR" ]; then
    log_info "Clonando o repositório..."
    git clone "$REPO_URL"
else
    log_info "O diretório '$PROJECT_DIR' já existe. Pulando a clonagem."
fi

# Navega para o diretório do projeto. O 'set -e' garante que o script pare se o cd falhar.
cd "$PROJECT_DIR"
log_success "Trabalhando dentro do diretório: $(pwd)"
echo

# 3. Instalar dependências do Composer
log_info "Instalando dependências do PHP com o Composer (pode levar alguns minutos)..."
composer install --no-interaction --no-progress --prefer-dist
log_success "Dependências do Composer instaladas."
echo

# 4. Configurar o arquivo de ambiente (.env)
log_info "Configurando o arquivo de ambiente..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    log_success "Arquivo .env criado com sucesso."
else
    log_info "O arquivo .env já existe."
fi
echo

# 5. Gerar a chave da aplicação
log_info "Gerando a chave da aplicação (APP_KEY)..."
php artisan key:generate
# Verifica se a chave foi realmente adicionada ao .env
if ! grep -q "APP_KEY=base64:" .env; then
    log_error "Falha ao gerar e salvar a APP_KEY no arquivo .env."
    exit 1
fi
log_success "Chave da aplicação gerada com sucesso."
echo

# 6. Ajustar Permissões (Passo Crítico)
log_info "Ajustando permissões das pastas 'storage' e 'bootstrap/cache'..."
chmod -R 775 storage bootstrap/cache
log_success "Permissões ajustadas."
echo

# 7. Executar as migrações e seeds do banco de dados
log_info "O próximo passo executará as migrações do banco de dados."
log_info "Certifique-se de que seu arquivo .env está configurado com os dados corretos do banco (DB_DATABASE, DB_USERNAME, DB_PASSWORD)."
read -p "Pressione [Enter] para continuar..."

log_info "Executando as migrações..."
php artisan migrate --force # O '--force' é necessário para rodar em ambiente não interativo
log_success "Migrações executadas."

log_info "Populando o banco de dados (seeding)..."
php artisan db:seed --force
log_success "Banco de dados populado."
echo

# 8. Criar o link simbólico de armazenamento
log_info "Criando o link simbólico de armazenamento..."
php artisan storage:link
log_success "Link de armazenamento criado."
echo

# --- Finalização ---
echo "================================================="
log_success "Instalação do SEMARH Fiscaliza 1.0 concluída!"
echo "================================================="
echo
log_info "Próximos passos:"
log_info "1. Verifique se todas as configurações no arquivo .env estão corretas."
log_info "2. Para iniciar o servidor de desenvolvimento, execute o comando:"
echo -e "   ${YELLOW}php artisan serve${NC}"
echo

exit 0


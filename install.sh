#!/bin/bash

# =============================================================================
# Script de Instalação Docker-First para SEMARH Fiscaliza
#
# Versão: 2.0
# Autor: Gemini Code Assist
#
# Melhorias:
# - Todo o setup da aplicação (artisan) é executado dentro do contêiner Docker.
# - Remove a dependência do PHP na máquina local.
# - Adiciona verificação de Docker e Docker Compose.
# =============================================================================

# --- Configuração de Shell ---
# Sai imediatamente se um comando sair com um status diferente de zero.
set -e

# --- Configuração de Cores e Log ---
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
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

# --- Início do Script ---
clear
echo "================================================="
echo "  Instalador Docker do SEMARH Fiscaliza (v2.0)"
echo "================================================="
echo

# 1. Verificação de Dependências
log_info "Verificando dependências..."
check_command "git"
check_command "docker"
check_command "docker-compose"
log_success "Todas as dependências foram encontradas e são compatíveis!"
echo

# 4. Configurar o arquivo de ambiente (.env) e permissões
log_info "Configurando o arquivo de ambiente..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    log_success "Arquivo .env criado com sucesso."
else
    log_info "O arquivo .env já existe, pulando criação."
fi

# 5. Pausa para configuração do .env
log_info "O próximo passo irá construir e iniciar os contêineres Docker (build & up)."
log_info "VERIFIQUE SEU ARQUIVO .env: Certifique-se de que as variáveis DB_DATABASE, DB_USERNAME e DB_PASSWORD estão preenchidas."

if grep -qE "^DB_PASSWORD=('?secret'?|\"?secret\"?)$" .env || grep -q "^DB_PASSWORD=$" .env; then
    log_error "A senha padrão 'secret' ou uma senha vazia foi encontrada no .env. Por favor, edite o arquivo e defina uma senha segura."
    exit 1
fi

read -p "Pressione [Enter] para continuar..."

# 6. Construir e iniciar os contêineres
log_info "Construindo e iniciando os contêineres Docker (pode levar vários minutos na primeira vez)..."
docker-compose up -d --build
log_success "Contêineres iniciados com sucesso."
echo

log_info "Aguardando o banco de dados iniciar (15 segundos)..."
sleep 15

# 7. Executar comandos Artisan DENTRO do contêiner
log_info "Executando comandos de setup da aplicação dentro do contêiner..."

log_info "Ajustando permissões das pastas 'storage' e 'bootstrap/cache' dentro do contêiner..."
# Define o dono como 'www-data' e o grupo como 'www-data', e aplica permissões 775.
docker-compose exec -T app sh -c "chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache"
log_success "Permissões ajustadas."

log_info "Gerando a chave da aplicação (APP_KEY)..."
docker-compose exec app php artisan key:generate
log_success "Chave da aplicação gerada."

log_info "Executando as migrações do banco de dados..."
docker-compose exec app php artisan migrate --force
log_success "Migrações concluídas."

log_info "Populando o banco de dados com dados iniciais (seeding)..."
docker-compose exec app php artisan db:seed --force
log_success "Banco de dados populado."

log_info "Criando o link simbólico de armazenamento..."
docker-compose exec app php artisan storage:link
log_success "Link de armazenamento criado."
echo

# --- Finalização ---
echo "================================================="
log_success "Instalação Docker do SEMARH Fiscaliza concluída!"
echo "================================================="
echo
log_info "Próximos passos:"
log_info "1. A aplicação está rodando! Acesse em seu navegador: ${BLUE}http://localhost:8000${NC}"
log_info "2. Para gerenciar o ambiente (parar, ver logs, etc), use o painel:"
echo -e "   ${YELLOW}./gerenciar.sh${NC} (no Git Bash) ou ${YELLOW}./gerenciar.ps1${NC} (no PowerShell)"
echo

exit 0

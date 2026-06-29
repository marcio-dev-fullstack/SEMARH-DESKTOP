#!/bin/bash

# =============================================================================
# Script de Deploy por Imagem Docker para SEMARH Fiscaliza
#
# Versão: 3.0
# Autor: Márcio
#
# Uso: ./deploy.sh
#
# Este script orquestra o deploy a partir de uma nova imagem Docker
# previamente baixada pelo pipeline de CI/CD. Ele não constrói imagens.
# =============================================================================

# --- Configuração de Shell ---
# Sai imediatamente se um comando sair com um status diferente de zero.
set -e

# --- Trap de Segurança ---
# Função para ser executada em caso de erro (ERR), interrupção (INT) ou ao final do script (EXIT).
cleanup() {
    EXIT_CODE=$?
    if [ $EXIT_CODE -ne 0 ]; then
        log_error "O DEPLOY FALHOU (código de saída: $EXIT_CODE). Revertendo modo de manutenção..."
    fi

    # Garante que a aplicação volte ao ar, a menos que o deploy tenha sido bem-sucedido.
    if [ -f ".maintenance" ] && [ $EXIT_CODE -ne 0 ]; then
        log_info "Tentando desativar o modo de manutenção..."
        docker-compose $COMPOSE_FILES exec -T app php artisan up || log_error "Não foi possível desativar o modo de manutenção. Verifique manualmente."
    fi
    rm -f .maintenance
}
trap cleanup EXIT INT ERR

# --- Configuração de Cores e Log ---
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # Sem Cor

log_success() { echo -e "${GREEN}✅ $1${NC}"; }
log_error() { echo -e "${RED}❌ ERRO: $1${NC}" >&2; }
log_info() { echo -e "${YELLOW}▶ $1${NC}"; }
log_header() { echo -e "\n${BLUE}--- $1 ---${NC}"; }

# --- Variáveis ---
# Define os arquivos do Docker Compose a serem usados em produção.
COMPOSE_FILES="-f docker-compose.yml -f docker-compose.prod.yml"

# --- Início do Script ---
clear
echo "================================================="
echo "  Iniciando Deploy por Imagem - SEMARH Fiscaliza"
echo "================================================="
echo

# 1. Ativar modo de manutenção
log_header "ATIVANDO MODO DE MANUTENÇÃO"
# Usamos -T para desabilitar o pseudo-TTY, ideal para automação.
# Criamos um arquivo local para controle no trap.
touch .maintenance
docker-compose $COMPOSE_FILES exec -T app php artisan down || log_info "Aplicação já em modo de manutenção."
log_success "Modo de manutenção ativado."

# 2. Backup do Banco de Dados (Segurança Crítica)
log_header "BACKUP DO BANCO DE DADOS"
DB_BACKUP_FILE="backup-db-$(date +%Y%m%d-%H%M%S).sql.gz"
log_info "Criando backup do banco de dados em: $DB_BACKUP_FILE"
docker-compose $COMPOSE_FILES exec -T db pg_dump -U "${DB_USERNAME:-semarh_user}" -d "${DB_DATABASE:-semarh_db}" | gzip > "$DB_BACKUP_FILE"
log_success "Backup do banco de dados criado com sucesso."

# 3. Reiniciar os serviços com a nova imagem
log_header "REINICIANDO OS SERVIÇOS"
log_info "Reiniciando os contêineres para usar a nova imagem baixada..."
docker-compose $COMPOSE_FILES up -d --force-recreate --remove-orphans
log_success "Contêineres reiniciados com a nova versão."

# 4. Executar comandos pós-deploy
log_header "EXECUTANDO TAREFAS PÓS-DEPLOY"

log_info "Executando migrações do banco de dados..."
docker-compose $COMPOSE_FILES exec -T app php artisan migrate --force
log_success "Migrações concluídas."

log_info "Otimizando a aplicação para produção (cache de config e rotas)..."
# Limpa todos os caches antigos antes de criar os novos para evitar conflitos.
docker-compose $COMPOSE_FILES exec -T app php artisan optimize:clear
docker-compose $COMPOSE_FILES exec -T app php artisan optimize
log_success "Aplicação otimizada."

# 5. Desativar modo de manutenção
log_header "DESATIVANDO MODO DE MANUTENÇÃO"
docker-compose $COMPOSE_FILES exec -T app php artisan up
rm -f .maintenance # Remove o arquivo de controle
log_success "Aplicação está online."

# --- Finalização ---
echo
echo "================================================="
log_success "  DEPLOY CONCLUÍDO COM SUCESSO!"
echo "================================================="
echo

exit 0
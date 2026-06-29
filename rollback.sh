#!/bin/bash

# =============================================================================
# Script de Rollback Automatizado para SEMARH Fiscaliza 1.0
#
# Versão: 1.0
# Autor: Gemini Code Assist
#
# Uso: ./rollback.sh [commit_hash | HEAD~N]
# Exemplo 1 (reverter para o commit anterior): ./rollback.sh HEAD~1
# Exemplo 2 (reverter para um hash específico): ./rollback.sh a1b2c3d
#
# Este script reverte a aplicação para uma versão anterior e a reimplanta.
# =============================================================================

set -e

# --- Configuração de Cores e Log (importado do deploy.sh) ---
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log_success() { echo -e "${GREEN}✅ $1${NC}"; }
log_error() { echo -e "${RED}❌ ERRO: $1${NC}" >&2; }
log_info() { echo -e "${YELLOW}▶ $1${NC}"; }
log_header() { echo -e "\n${BLUE}--- $1 ---${NC}"; }

# --- Validação de Entrada ---
if [ -z "$1" ]; then
    log_error "Nenhum alvo de rollback especificado."
    log_info "Uso: $0 [commit_hash | HEAD~N]"
    log_info "Exemplo: $0 HEAD~1  (para reverter para o commit anterior)"
    exit 1
fi

TARGET_COMMIT=$1

# --- Início do Script ---
clear
echo "================================================="
echo "  Iniciando Rollback do SEMARH Fiscaliza 1.0"
echo "================================================="
log_info "Alvo da reversão: $TARGET_COMMIT"
echo

read -p "Você tem certeza que deseja reverter para esta versão? [s/N] " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    log_error "Rollback cancelado pelo usuário."
    exit 1
fi

log_header "REVERTENDO CÓDIGO-FONTE"
git checkout "$TARGET_COMMIT"
log_success "Código revertido para o commit $(git rev-parse --short HEAD)."

log_header "INICIANDO PROCESSO DE DEPLOY COM A VERSÃO ANTIGA"
./deploy.sh

log_success "ROLLBACK E DEPLOY CONCLUÍDOS!"
exit 0
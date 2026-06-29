#!/bin/bash

# =============================================================================
# Painel de Gerenciamento de Ambiente Docker - SEMARH Fiscaliza
#
# IMPORTANTE: Este é um script Bash (.sh).
# Para executá-lo no Windows, você DEVE usar um terminal compatível, como:
#   - Git Bash (que vem com a instalação do Git for Windows)
#   - WSL (Windows Subsystem for Linux)
#
# Ele não funcionará no CMD ou PowerShell padrão.
# =============================================================================

# Cores para o terminal
GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # Sem cor

echo -e "${BLUE}=== SEMARH DESKTOP - Painel de Gerenciamento ===${NC}"

exibir_menu() {
    echo ""
    echo "1) Iniciar Ambiente (Docker Up)"
    echo "2) Parar Ambiente (Docker Down)"
    echo "3) Reiniciar Ambiente"
    echo "4) Ver Logs da Aplicação"
    echo "5) Acessar Terminal do Container (Bash)"
    echo "6) Rodar Migrations (Artisan Migrate)"
    echo "7) Sair"
    echo ""
    echo -n "Escolha uma opção: "
}

while true; do
    exibir_menu
    read opcao
    case $opcao in
        1)
            echo -e "${GREEN}Iniciando os contêineres...${NC}"
            docker-compose up -d
            ;;
        2)
            echo -e "${RED}Parando e removendo os contêineres...${NC}"
            docker-compose down
            ;;
        3)
            echo -e "${BLUE}Reiniciando o ambiente...${NC}"
            docker-compose restart
            ;;
        4)
            echo -e "${BLUE}Exibindo logs (Pressione Ctrl+C para sair)...${NC}"
            docker-compose logs -f
            ;;
        5)
            # Ajuste o nome do serviço 'app' se no seu docker-compose.yml for diferente (ex: 'web', 'laravel')
            echo -e "${GREEN}Entrando no container da aplicação...${NC}"
            docker-compose exec app bash || docker-compose exec web bash
            ;;
        6)
            echo -e "${BLUE}Rodando as migrações do banco de dados...${NC}"
            docker-compose exec app php artisan migrate || docker-compose exec web php artisan migrate
            ;;
        7)
            echo -e "${GREEN}Saindo...${NC}"
            break
            ;;
        *)
            echo -e "${RED}Opção inválida! Tente novamente.${NC}"
            ;;
    esac
done
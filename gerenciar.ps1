<#
.SYNOPSIS
    Painel de Gerenciamento de Ambiente Docker - SEMARH Fiscaliza (Versão PowerShell)
.DESCRIPTION
    Este script fornece um menu interativo para gerenciar os contêineres Docker do projeto
    SEMARH Fiscaliza diretamente do PowerShell no Windows.
.NOTES
    Autor: Gemini Code Assist
    Versão: 1.0
#>

# --- Configuração Inicial ---
$ErrorActionPreference = "Stop" # Para o script em caso de erro

function Show-Menu {
    Clear-Host
    Write-Host "=== SEMARH DESKTOP - Painel de Gerenciamento (PowerShell) ===" -ForegroundColor Blue
    Write-Host ""
    Write-Host "1) Iniciar Ambiente (Docker Up)"
    Write-Host "2) Parar Ambiente (Docker Down)"
    Write-Host "3) Reiniciar Ambiente"
    Write-Host "4) Ver Logs da Aplicação"
    Write-Host "5) Acessar Terminal do Container (Bash)"
    Write-Host "6) Rodar Migrations (Artisan Migrate)"
    Write-Host "7) Sair"
    Write-Host ""
}

while ($true) {
    Show-Menu
    $opcao = Read-Host "Escolha uma opção"

    switch ($opcao) {
        "1" {
            Write-Host "Iniciando os contêineres..." -ForegroundColor Green
            docker-compose up -d
            Read-Host "Pressione Enter para continuar..."
        }
        "2" {
            Write-Host "Parando e removendo os contêineres..." -ForegroundColor Red
            docker-compose down
            Read-Host "Pressione Enter para continuar..."
        }
        "3" {
            Write-Host "Reiniciando o ambiente..." -ForegroundColor Blue
            docker-compose restart
            Read-Host "Pressione Enter para continuar..."
        }
        "4" {
            Write-Host "Exibindo logs (Pressione Ctrl+C para sair)..." -ForegroundColor Blue
            docker-compose logs -f
        }
        "5" {
            Write-Host "Entrando no container da aplicação... Digite 'exit' para sair." -ForegroundColor Green
            # Tenta o serviço 'app' primeiro, se falhar, tenta 'web'
            try {
                docker-compose exec app bash
            } catch {
                docker-compose exec web bash
            }
        }
        "6" {
            Write-Host "Rodando as migrações do banco de dados..." -ForegroundColor Blue
            try {
                docker-compose exec app php artisan migrate
            } catch {
                docker-compose exec web php artisan migrate
            }
            Read-Host "Pressione Enter para continuar..."
        }
        "7" {
            Write-Host "Saindo..." -ForegroundColor Green
            return
        }
        default {
            Write-Host "Opção inválida! Tente novamente." -ForegroundColor Red
            Read-Host "Pressione Enter para continuar..."
        }
    }
}
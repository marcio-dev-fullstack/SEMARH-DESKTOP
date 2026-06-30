# 📖 Manual de Instalação - SEMARH Fiscaliza 1.0

Este manual fornece instruções detalhadas para a instalação e configuração do ambiente de desenvolvimento do sistema SEMARH Fiscaliza 1.0.

---

## 📋 Pré-requisitos

Antes de iniciar, certifique-se de que seu ambiente de desenvolvimento atende aos seguintes requisitos:

- **Git:** Para clonar o repositório do projeto.
- **PHP:** Versão 8.3 ou superior.
- **Composer:** Para gerenciamento de dependências do PHP.
- **Banco de Dados:** PostgreSQL (versão 14 ou superior) com a extensão **PostGIS** habilitada.
- **Node.js e NPM:** Para compilação dos assets de frontend (JavaScript/CSS).
- **Acesso à linha de comando/terminal.**

---

## 🚀 Opção 1: Instalação Automatizada (Recomendado para Linux/macOS)

O projeto inclui um script de instalação (`install.sh`) que automatiza a maioria dos passos.

### Passo 1: Baixar o Script

Se você ainda não tem o projeto, pode baixar apenas o script de instalação para iniciar o processo.

```bash
# Exemplo usando curl
curl -o install.sh https://raw.githubusercontent.com/marcio-dev-fullstack/SEMARH-DESKTOP/main/install.sh
```

### Passo 2: Conceder Permissão de Execução

Abra o terminal e conceda permissão de execução ao script:

```bash
chmod +x install.sh
```

### Passo 3: Executar o Script

Execute o script e siga as instruções que aparecerão no terminal:

```bash
./install.sh
```

O script irá:

1.  Verificar se todas as dependências (Git, PHP, Composer) estão instaladas e compatíveis.
2.  Clonar o repositório do projeto.
3.  Instalar as dependências do Composer.
4.  Criar o arquivo de ambiente `.env`.
5.  Gerar a chave da aplicação (`APP_KEY`).
6.  Ajustar as permissões das pastas `storage` e `bootstrap/cache`.
7.  Pausar e solicitar que você configure as credenciais do banco de dados no arquivo `.env`.
8.  Após sua confirmação, executará as migrações e populará o banco de dados (`migrate` e `db:seed`).
9.  Criará o link simbólico para a pasta `storage`.

Ao final, o ambiente estará pronto para ser iniciado.

---

## 🛠️ Opção 2: Instalação Manual Passo a Passo

Siga estes passos se preferir fazer a instalação manualmente ou se estiver em um ambiente Windows.

### 1. Clonar o Repositório

Abra seu terminal ou Git Bash e clone o projeto:

```bash
git clone https://github.com/marcio-dev-fullstack/SEMARH-DESKTOP.git
```

### 2. Acessar o Diretório do Projeto

Navegue para a pasta recém-criada:

```bash
cd SEMARH-DESKTOP
```

### 3. Instalar Dependências do Composer

Execute o Composer para baixar e instalar todas as bibliotecas PHP necessárias:

```bash
composer install
```

### 4. Configurar o Arquivo de Ambiente

Copie o arquivo de exemplo `.env.example` para criar seu próprio arquivo de configuração `.env`:

```bash
# Para Linux/macOS
cp .env.example .env

# Para Windows
copy .env.example .env
```

Abra o arquivo `.env` em um editor de texto e **configure as variáveis de conexão com o banco de dados**:

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sua_base_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Gerar a Chave da Aplicação

Este comando irá gerar uma chave de criptografia única para a sua aplicação e a inserirá automaticamente no arquivo `.env`.

```bash
php artisan key:generate
```

### 6. Executar as Migrações e Seeds

Os comandos a seguir criarão a estrutura de tabelas no banco de dados e o popularão com dados iniciais.

```bash
php artisan migrate --seed
```

### 7. Criar o Link de Armazenamento

Este passo cria um atalho público para a pasta de armazenamento, permitindo o acesso a arquivos como documentos e imagens.

```bash
php artisan storage:link
```

### 8. Iniciar o Servidor de Desenvolvimento

Finalmente, inicie o servidor local do Laravel.

```bash
php artisan serve
```

Acesse http://127.0.0.1:8000 em seu navegador para ver a aplicação em funcionamento.

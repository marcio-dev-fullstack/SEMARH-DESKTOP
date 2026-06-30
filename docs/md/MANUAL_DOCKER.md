# 🐋 Manual de Instalação com Docker (Recomendado)

Este guia detalha a instalação do sistema **SEMARH Fiscaliza 1.0** utilizando Docker. Este é o método mais recomendado por criar um ambiente de desenvolvimento isolado, padronizado e que funciona de forma consistente em qualquer máquina.

Ele encapsula a aplicação e todos os seus serviços (banco de dados, servidor web, etc.) em contêineres, eliminando a necessidade de instalar PHP, PostgreSQL ou Nginx diretamente no seu sistema operacional.

---

## 📋 Pré-requisitos

- **Git:** Para baixar o código-fonte do projeto.
- **Docker e Docker Compose:** Para construir e orquestrar os contêineres da aplicação.

---

## 🚀 Passo a Passo

### Passo 1: Clonar o Projeto

Abra seu terminal e clone o repositório do projeto para a sua máquina.

```bash
git clone https://github.com/marcio-dev-fullstack/SEMARH-DESKTOP.git
```

### Passo 2: Acessar o Diretório do Projeto

Navegue para a pasta que acabou de ser criada.

```bash
cd SEMARH-DESKTOP
```

### Passo 3: Criar o Arquivo de Configuração de Ambiente

Copie o arquivo de exemplo `.env.example` para criar seu próprio arquivo de configuração local, o `.env`.

```bash
# Se estiver usando Linux ou macOS
cp .env.example .env

# Se estiver usando Windows (no PowerShell)
copy .env.example .env
```

### Passo 4: Configurar as Variáveis de Ambiente

Abra o arquivo `.env` que você acabou de criar em um editor de texto. Você precisará definir as credenciais do banco de dados. O `docker-compose.yml` está configurado para usar estes valores para provisionar o banco de dados automaticamente.

**Ajuste as seguintes linhas no seu arquivo `.env`:**

```ini
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=semarh_db
DB_USERNAME=semarh_user
DB_PASSWORD=sua_senha_secreta_aqui
```

> **Importante:** Mantenha `DB_HOST=db`. Este é o nome do serviço do banco de dados na rede interna do Docker, conforme definido no `docker-compose.yml`.

### Passo 5: Construir e Iniciar os Contêineres

No terminal, dentro da pasta do projeto, execute o seguinte comando. Ele irá baixar as imagens necessárias, construir a imagem da sua aplicação e iniciar todos os serviços em segundo plano.

```bash
docker-compose up -d --build
```

### Passo 6: Executar os Comandos de Finalização

Com os contêineres rodando, execute os seguintes comandos do Laravel _dentro_ do contêiner da aplicação para finalizar a configuração.

1.  **Gerar a chave da aplicação:**

    ```bash
    docker-compose exec app php artisan key:generate
    ```

2.  **Criar as tabelas e popular o banco de dados:**

    ```bash
    docker-compose exec app php artisan migrate --seed
    ```

3.  **Criar o link simbólico para o armazenamento de arquivos:**
    ```bash
    docker-compose exec app php artisan storage:link
    ```

### Passo 7: Acessar a Aplicação

Pronto! O ambiente está totalmente configurado. Abra seu navegador e acesse: **http://localhost:8000**

---

## ⚙️ Comandos Úteis do Docker

- **Para parar todos os contêineres:**
  ```bash
  docker-compose down
  ```
- **Para ver os logs da aplicação em tempo real:**
  ```bash
  docker-compose logs -f app
  ```
- **Para acessar o terminal do contêiner da aplicação:**
  ```bash
  docker-compose exec app bash
  ```

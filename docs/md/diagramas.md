# 📊 Diagramas da Arquitetura e Fluxos do SEMARH Fiscaliza 1.0

Este documento consolida os principais diagramas que representam a arquitetura, os fluxos e as interações do sistema **SEMARH Fiscaliza 1.0**, conforme descrito no `README.md`.

Os diagramas foram gerados utilizando a sintaxe Mermaid e podem ser renderizados em qualquer visualizador de Markdown compatível (como GitHub, GitLab, VS Code, ou editores online).

---

## 1. Diagrama de Contexto do Sistema (Modelo C4 - Nível 1)

Este diagrama oferece uma visão de alto nível do sistema `SEMARH Fiscaliza`, mostrando como os diferentes usuários (atores) e sistemas externos interagem com ele.

```mermaid
graph TD
    subgraph "Atores Externos"
        cidadao[Cidadão]
        agente[Agente de Fiscalização]
        analista[Analista Ambiental]
        gestor[Gestor Público]
    end

    subgraph "SEMARH Fiscaliza 1.0"
        sistema(Sistema SEMARH Fiscaliza)
    end

    subgraph "Sistemas Externos"
        govbr[GOV.BR]
        inpe[INPE / NASA FIRMS]
        mapbiomas[MapBiomas]
        sicar[SICAR]
        outros_sistemas[Outros Sistemas<br/>(Tributação, Obras, etc.)]
        icp[ICP-Brasil]
    end

    %% Interações dos Atores
    cidadao -- "Solicita licenças, consulta processos" --> sistema
    agente -- "Usa App Mobile, registra fiscalizações" --> sistema
    analista -- "Analisa processos, emite pareceres" --> sistema
    gestor -- "Acessa Dashboards de BI" --> sistema

    %% Interações com Sistemas Externos
    sistema -- "Autenticação e Assinatura Digital" --> govbr
    sistema -- "Autenticação e Assinatura Digital" --> icp
    sistema -- "Consome dados de queimadas e monitoramento" --> inpe
    sistema -- "Consome camadas de mapeamento" --> mapbiomas
    sistema -- "Consulta Cadastro Ambiental Rural" --> sicar
    sistema -- "Integra com sistemas municipais" --> outros_sistemas
```

---

## 2. Diagrama de Contêineres (Modelo C4 - Nível 2)

Este diagrama detalha a arquitetura tecnológica do sistema, mostrando os principais "contêineres" (aplicações, bancos de dados, etc.) que compõem o `SEMARH Fiscaliza`.

```mermaid
graph TD
    subgraph "Usuários"
        browser[Usuário via<br/>Navegador Web]
        mobile_user[Fiscal em Campo via<br/>App Mobile]
    end

    subgraph "Ecossistema SEMARH Fiscaliza"
        subgraph "Aplicação Web"
            frontend[Frontend<br/>(Blade, Livewire, Alpine.js)]
            backend[Backend API<br/>(Laravel 12 / PHP 8.3)]
        end

        subgraph "Armazenamento de Dados"
            db[(Banco de Dados<br/>PostgreSQL 16 + PostGIS)]
            redis[(Redis<br/>Filas e Cache)]
        end

        subgraph "Serviços de Geo"
            geoserver[GeoServer]
        end

        subgraph "Processamento Assíncrono"
            worker[Background Worker<br/>(Laravel Horizon)]
        end

        mobile_app[Aplicativo Mobile<br/>(Android/iOS)]
    end

    %% Conexões
    browser -- "HTTPS" --> frontend
    frontend -- "Interage com" --> backend
    mobile_user -- "HTTPS" --> mobile_app
    mobile_app -- "API REST" --> backend

    backend -- "Lê/Escreve" --> db
    backend -- "Usa" --> redis
    backend -- "Envia jobs para" --> worker
    worker -- "Processa e atualiza" --> db
    backend -- "Consulta/Publica" --> geoserver
    geoserver -- "Lê dados espaciais de" --> db
```

---

## 3. Diagrama de Componentes do Backend

Este diagrama foca no contêiner "Backend" e o divide em seus principais componentes lógicos, conforme descrito nas funcionalidades do `README.md`.

```mermaid
graph TD
    subgraph "Backend (Laravel 12)"
        A(API Controller)

        subgraph "Módulos Principais"
            B[Licenciamento]
            C[Fiscalização]
            D[Gestão Documental]
            E[Portal do Cidadão]
            F[Business Intelligence]
        end

        subgraph "Módulos de Inteligência"
            G[IA Analista]
            H[IA Fiscal]
            I[IA Jurídica]
        end

        subgraph "Serviços de Suporte"
            J[Autenticação (Sanctum)]
            K[Geoprocessamento]
            L[Assinatura Digital]
            M[Blockchain de Auditoria]
        end
    end

    A --> B
    A --> C
    A --> D
    A --> E
    A --> F

    B -- "Utiliza" --> G
    C -- "Utiliza" --> H
    B & C & D -- "Utiliza" --> I

    B & C & D -- "Utiliza" --> L
    B & C & D & E & F -- "Utiliza" --> M
    B & C & E -- "Utiliza" --> K
    A -- "Protegido por" --> J
```

---

## 4. Diagrama de Caso de Uso

Este diagrama ilustra as principais interações de cada perfil de usuário (ator) com o sistema, ajudando a entender o escopo funcional sob a perspectiva de quem o utiliza.

```mermaid
graph TD
    subgraph "Atores"
        cidadao[Cidadão]
        agente[Agente de Fiscalização]
        analista[Analista Ambiental]
        gestor[Gestor Público]
    end

    subgraph "Casos de Uso do Sistema"
        uc1(Solicitar Licença Ambiental)
        uc2(Consultar Processo)
        uc3(Registrar Denúncia Ambiental)
        uc4(Obter Suporte via Chatbot)
        uc5(Realizar Fiscalização em Campo)
        uc6(Lavrar Documentos Fiscais<br>Auto de Infração, Embargo, etc.)
        uc7(Analisar Processo de Licenciamento)
        uc8(Gerar Pareceres e Relatórios)
        uc9(Utilizar IA de Suporte<br>Analista, Fiscal, Jurídica)
        uc10(Acessar Painel de BI)
        uc11(Monitorar Indicadores ESG)
        uc12(Gerenciar Camadas de Geoprocessamento)
        uc13(Gerenciar Documentos do Sistema)
    end

    %% Conexões dos Atores com os Casos de Uso
    cidadao -- "Interage com" --> uc1
    cidadao -- "Interage com" --> uc2
    cidadao -- "Interage com" --> uc3
    cidadao -- "Interage com" --> uc4

    agente -- "Executa" --> uc5
    agente -- "Executa" --> uc6
    agente -- "Utiliza" --> uc9
    agente -- "Consulta" --> uc12
    agente -- "Gera" --> uc13

    analista -- "Executa" --> uc7
    analista -- "Executa" --> uc8
    analista -- "Utiliza" --> uc9
    analista -- "Consulta" --> uc12
    analista -- "Gera" --> uc13

    gestor -- "Acessa" --> uc10
    gestor -- "Acessa" --> uc11
    gestor -- "Consulta" --> uc12
```

---

## 5. Diagrama de Entidade-Relacionamento (DER)

Este diagrama modela a estrutura lógica do banco de dados para os módulos de **Licenciamento** e **Fiscalização**, mostrando as principais entidades e como elas se conectam.

```mermaid
erDiagram
    Cidadao {
        int id PK
        string nome
        string cpf_cnpj
        string email
    }

    ProcessoLicenciamento {
        int id PK
        int cidadao_id FK
        string tipo_licenca
        string status
        date data_solicitacao
        geometry geometria
    }

    Licenca {
        int id PK
        int processo_id FK
        string numero
        date data_emissao
        date data_validade
    }

    Condicionante {
        int id PK
        int licenca_id FK
        string descricao
        string status
        date prazo
    }

    AgenteFiscal {
        int id PK
        string nome
        string matricula
    }

    Fiscalizacao {
        int id PK
        int agente_id FK
        int processo_id FK "Opcional"
        date data_ocorrencia
        geometry localizacao
        string relatorio
    }

    DocumentoFiscal {
        int id PK
        int fiscalizacao_id FK
        string tipo "Auto de Infração, Embargo, etc."
        string fundamentacao_legal
        decimal valor_multa "Opcional"
    }

    Denuncia {
        int id PK
        int fiscalizacao_id FK "Opcional"
        string descricao
        geometry localizacao
        string status
    }

    Cidadao ||--o{ ProcessoLicenciamento : "solicita"
    ProcessoLicenciamento ||--o| Licenca : "gera"
    Licenca ||--|{ Condicionante : "possui"
    AgenteFiscal ||--o{ Fiscalizacao : "realiza"
    Fiscalizacao ||--|{ DocumentoFiscal : "resulta em"
    Denuncia }o--|| Fiscalizacao : "pode gerar"
    ProcessoLicenciamento }o--o{ Fiscalizacao : "pode ser alvo de"
```

---

## 6. Diagrama de Fluxo de Licenciamento Ambiental

Este diagrama de atividades ilustra o processo para obtenção das licenças ambientais (LP, LI, LO), conforme a seção `Fluxo de Licenciamento` do README.

```mermaid
graph TD
    start((Início)) --> A{Solicitação de<br/>Licença Prévia (LP)};
    A --> B[Análise de Requisitos<br/>- Viabilidade locacional<br/>- Memorial descritivo<br/>- Documentação];
    B --> C{Decisão};
    C -- "Aprovado" --> D[Emissão da LP];
    C -- "Reprovado" --> E[Comunicação de Pendências];
    E --> A;

    D --> F{Solicitação de<br/>Licença de Instalação (LI)};
    F --> G[Análise de Requisitos<br/>- LP válida<br/>- Projetos ambientais<br/>- Sistemas de controle];
    G --> H{Decisão};
    H -- "Aprovado" --> I[Emissão da LI];
    H -- "Reprovado" --> J[Comunicação de Pendências];
    J --> F;

    I --> K{Solicitação de<br/>Licença de Operação (LO)};
    K --> L[Análise de Requisitos<br/>- LI válida<br/>- Vistoria técnica<br/>- Comprovação de implantação];
    L --> M{Decisão};
    M -- "Aprovado" --> N[Emissão da LO];
    M -- "Reprovado" --> O[Comunicação de Pendências];
    O --> K;

    N --> finish((Fim do Processo));
```

---

## 7. Diagrama de Sequência: Geração de Auto de Infração

Este diagrama mostra a interação entre o Agente de Fiscalização, o Aplicativo Mobile e os componentes do sistema no backend durante a geração de um Auto de Infração Digital.

```mermaid
sequenceDiagram
    participant Agente as Agente de Fiscalização
    participant App as Aplicativo Mobile
    participant Backend as Backend (API)
    participant IA_Fiscal as IA Fiscal
    participant DB as Banco de Dados
    participant Blockchain as Blockchain de Auditoria

    Agente->>App: Inicia "Novo Auto de Infração"
    activate App
    App->>App: Coleta dados (GPS, fotos, descrição)
    
    opt Consulta à IA
        App->>Backend: POST /api/ia/sugerir-enquadramento (dados parciais)
        activate Backend
        Backend->>IA_Fiscal: Analisar dados da infração
        activate IA_Fiscal
        IA_Fiscal->>DB: Consultar reincidência e legislação
        activate DB
        DB-->>IA_Fiscal: Retorna dados
        deactivate DB
        IA_Fiscal-->>Backend: Retorna sugestões (enquadramento, multa)
        deactivate IA_Fiscal
        Backend-->>App: Responde com sugestões da IA
        deactivate Backend
        App->>Agente: Exibe sugestões para o agente
    end

    Agente->>App: Confirma/ajusta dados e gera documento
    App->>App: Gera pré-visualização do Auto de Infração
    
    Agente->>App: Solicita assinatura digital
    App->>Agente: Coleta assinatura (via GOV.BR ou similar)
    
    Note right of App: O App pode operar offline.<br/>A sincronização ocorre quando<br/>há conexão.

    App->>Backend: POST /api/fiscalizacoes/sincronizar (Auto de Infração assinado + fotos)
    activate Backend
    Backend->>DB: Salva dados da fiscalização e do auto
    activate DB
    DB-->>Backend: Confirma gravação
    deactivate DB
    
    Backend->>Blockchain: Registra hash da transação (criação do auto)
    activate Blockchain
    Blockchain-->>Backend: Confirma registro imutável
    deactivate Blockchain
    
    Backend-->>App: Confirma sincronização (Status: Sucesso)
    deactivate Backend
    
    App->>Agente: Notifica "Auto de Infração enviado com sucesso"
    deactivate App
```

---

## 8. Diagrama de Implantação (Deployment)

Este diagrama ilustra como os componentes de software são distribuídos e implantados na infraestrutura de hardware ou em contêineres, mostrando a topologia física do sistema.

```mermaid
graph TD
    subgraph "Usuários Finais"
        browser["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/window-maximize.svg' width='20' height='20'> <br> Usuário Web (Browser)"].->|HTTPS| lb
        mobile_device["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/mobile-screen-button.svg' width='20' height='20'> <br> Agente em Campo (App Mobile)"]-.->|HTTPS / API Calls| lb
    end

    subgraph "Infraestrutura em Nuvem / Data Center"
        lb["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/network-wired.svg' width='20' height='20'> <br> Load Balancer / Reverse Proxy"]

        subgraph "Servidor de Aplicação"
            nginx["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/nginx.svg' width='20' height='20'> <br> Nginx"]
            laravel["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/brands/laravel.svg' width='20' height='20'> <br> Laravel 12 (PHP-FPM) <br><i>(Backend API, Frontend Blade/Livewire)</i>"]
            horizon["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/gears.svg' width='20' height='20'> <br> Laravel Horizon <br><i>(Processador de Filas)</i>"]
        end

        subgraph "Servidor de Banco de Dados"
            postgres["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/database.svg' width='20' height='20'> <br> PostgreSQL 16 + PostGIS"]
        end

        subgraph "Servidor GIS"
            geoserver["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/map-location-dot.svg' width='20' height='20'> <br> GeoServer"]
        end

        subgraph "Serviços Auxiliares"
            redis["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/cube.svg' width='20' height='20'> <br> Redis <br><i>(Cache e Filas)</i>"]
            blockchain["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/link.svg' width='20' height='20'> <br> Nó de Blockchain <br><i>(Auditoria)</i>"]
        end

        lb --> nginx
        nginx --> laravel
        laravel -->|Lê/Escreve| postgres
        laravel -->|Lê/Escreve| redis
        laravel -->|Publica Camadas| geoserver
        laravel -->|Registra Hash| blockchain
        horizon -->|Consome Jobs| redis
        horizon -->|Processa e Atualiza| postgres
        geoserver -->|Lê Dados Espaciais| postgres
    end

    subgraph "Serviços Externos (APIs)"
        govbr["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/building-shield.svg' width='20' height='20'> <br> GOV.BR"]
        inpe["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/satellite.svg' width='20' height='20'> <br> INPE / NASA"]
        mapbiomas["<img src='https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/earth-americas.svg' width='20' height='20'> <br> MapBiomas"]
    end

    laravel -->|API Calls| govbr
    laravel -->|API Calls| inpe
    laravel -->|API Calls| mapbiomas
```

---

## 9. Diagrama de Sequência: Consulta de Processo pelo Cidadão

Este diagrama ilustra o fluxo de como um cidadão autenticado consulta a lista de seus processos e visualiza os detalhes de um deles no Portal do Cidadão.

```mermaid
sequenceDiagram
    participant Cidadao as Cidadão
    participant Browser as Navegador (Frontend)
    participant Backend as Backend (Laravel)
    participant Auth as Middleware de Autenticação
    participant DB as Banco de Dados (PostgreSQL)

    Cidadao->>Browser: Acessa o Portal do Cidadão e clica em "Login"
    Browser->>Backend: Requisição de autenticação (ex: via GOV.BR ou local)
    Backend-->>Browser: Retorna sucesso com token/sessão

    Note over Browser, Backend: Cidadão está autenticado

    Cidadao->>Browser: Clica em "Meus Processos"
    Browser->>Backend: GET /api/meus-processos
    
    activate Backend
    Backend->>Auth: Verificar token/sessão
    activate Auth
    Auth-->>Backend: Usuário autenticado
    deactivate Auth

    Backend->>DB: SELECT * FROM processos WHERE cidadao_id = [ID do usuário]
    activate DB
    DB-->>Backend: Retorna lista de processos
    deactivate DB
    Backend-->>Browser: Responde com a lista de processos (JSON)
    deactivate Backend

    Browser->>Cidadao: Exibe a lista de processos (número, tipo, status)

    Cidadao->>Browser: Clica para ver detalhes de um processo específico
    Browser->>Backend: GET /api/processos/{id}
    
    activate Backend
    Backend->>Auth: Verificar se usuário pode ver este processo (policy)
    activate Auth
    Auth-->>Backend: Autorizado
    deactivate Auth

    Backend->>DB: SELECT ... FROM processos WHERE id = {id}
    activate DB
    DB-->>Backend: Retorna detalhes completos do processo
    deactivate DB
    Backend-->>Browser: Responde com os detalhes (JSON)
    deactivate Backend

    Browser->>Cidadao: Exibe a página de detalhes do processo (timeline, documentos, etc.)
```
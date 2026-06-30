# 📡 Documentação da API REST - SEMARH Fiscaliza 1.0

**Versão da API:** 1.0
**URL Base:** `/api/v1`

Este documento detalha os endpoints da API REST do sistema SEMARH Fiscaliza, projetada para ser consumida pelo aplicativo mobile dos agentes de fiscalização e pelo portal do cidadão.

---

## Authentication

A autenticação é realizada via Laravel Sanctum. O cliente deve primeiro obter um token de API através do endpoint de login e, em seguida, enviar este token no cabeçalho `Authorization` de todas as requisições subsequentes como um `Bearer Token`.

`Authorization: Bearer <token>`

---

## 👤 Módulo de Autenticação

### `POST /login`

Autentica um usuário (agente ou cidadão) e retorna um token de API.

**Request Body:**

```json
{
  "email": "agente@email.com",
  "password": "sua_senha",
  "device_name": "Meu App Mobile"
}
```

**Success Response (200 OK):**

```json
{
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...",
  "user": {
    "id": 1,
    "name": "Agente Fiscal 001",
    "email": "agente@email.com",
    "role": "Agente"
  }
}
```

### `POST /logout`

Invalida o token de API do usuário autenticado. Requer autenticação.

**Success Response (204 No Content):**

---

## 📱 Módulo Mobile (Agente de Fiscalização)

Endpoints focados nas necessidades do agente em campo.

### `GET /tasks`

Retorna a lista de tarefas (fiscalizações) atribuídas ao agente autenticado.

**Success Response (200 OK):**

```json
[
  {
    "id": 1,
    "protocol": "FSC-2026-001",
    "origin": "Denúncia DEN-2026-002",
    "status": "Agendada",
    "date": "2026-06-28",
    "location": {
      "latitude": -16.6869,
      "longitude": -49.2648
    }
  }
]
```

### `POST /inspections/sync`

Endpoint principal para sincronização de dados do modo offline. Permite o envio de uma ou mais fiscalizações completas, incluindo autos de infração, relatórios e mídias.

**Request Body:**

```json
{
  "inspections": [
    {
      "local_id": "uuid-123-abc",
      "protocol": "FSC-2026-003",
      "date": "2026-06-26T10:30:00Z",
      "location": { "latitude": -16.758, "longitude": -49.432 },
      "report": "Desmatamento ilegal confirmado em área de APP.",
      "documents": [
        {
          "type": "Auto de Infração",
          "legal_basis": "Lei 9.605/1998, Art. 50",
          "fine_value": 5000.0,
          "digital_signature": "..."
        }
      ],
      "media": [
        {
          "filename": "foto1.jpg",
          "content_base64": "data:image/jpeg;base64,/9j/4AAQSkZJRg...",
          "location": { "latitude": -16.7581, "longitude": -49.4322 }
        }
      ]
    }
  ]
}
```

**Success Response (200 OK):**

```json
{
  "message": "Sincronização concluída com sucesso.",
  "results": [
    {
      "local_id": "uuid-123-abc",
      "server_id": 4,
      "status": "created"
    }
  ]
}
```

---

## 🤖 Módulo de Inteligência Artificial (IA)

Endpoints de suporte para o agente em campo.

### `POST /ia/suggest-infraction`

Com base nos dados preliminares de uma infração, a IA Fiscal sugere o enquadramento legal e o valor da multa.

**Request Body:**

```json
{
  "description": "Despejo de resíduos sólidos em margem de córrego.",
  "location": { "latitude": -16.758, "longitude": -49.432 },
  "offender_cnpj_cpf": "12.345.678/0001-99"
}
```

**Success Response (200 OK):**

```json
{
  "suggestions": [
    {
      "legal_basis": "Decreto 6.514/2008, Art. 62, Inciso II",
      "description": "Lançar resíduos sólidos em recursos hídricos.",
      "penalty_range": "Multa de R$ 5.000,00 a R$ 50.000.000,00",
      "suggested_fine": 15000.0,
      "is_recidivist": true
    }
  ]
}
```

---

## 🌐 Módulo Cidadão

Endpoints para o Portal do Cidadão.

### `GET /citizen/processes`

Retorna a lista de processos de licenciamento associados ao cidadão autenticado.

**Success Response (200 OK):**

```json
[
  {
    "id": 101,
    "protocol": "202601-12345",
    "license_type": "Licença de Operação (LO)",
    "status": "Em Análise",
    "request_date": "2026-01-15"
  }
]
```

### `GET /citizen/processes/{id}`

Retorna os detalhes de um processo específico, incluindo seu histórico (timeline) e documentos.

**URL Parameters:**

- `id` (integer, required): O ID do processo.

**Success Response (200 OK):**

```json
{
  "id": 101,
  "protocol": "202601-12345",
  "status": "Em Análise",
  "timeline": [
    { "date": "2026-02-20", "event": "Parecer técnico emitido" },
    { "date": "2026-01-15", "event": "Processo protocolado" }
  ],
  "documents": [{ "id": 205, "name": "parecer_tecnico.pdf", "url": "..." }]
}
```

### `POST /citizen/complaints`

Permite que um cidadão (autenticado ou anônimo, dependendo da configuração do sistema) registre uma nova denúncia ambiental.

**Request Body:**

```json
{
  "description": "Há um forte cheiro de produtos químicos vindo de uma indústria na Rua das Flores, principalmente à noite.",
  "location": {
    "latitude": -16.6799,
    "longitude": -49.255
  },
  "media_base64": ["data:image/jpeg;base64,/9j/..."]
}
```

**Success Response (201 Created):**

```json
{
  "message": "Denúncia registrada com sucesso.",
  "protocol": "DEN-2026-005"
}
```

# 🤝 Guia de Contribuição para o SEMARH Fiscaliza

Olá! Agradecemos seu interesse em contribuir para o **SEMARH Fiscaliza**. Sua ajuda é muito bem-vinda para tornar este projeto ainda melhor.

Para garantir um ambiente de desenvolvimento colaborativo, organizado e de alta qualidade, pedimos que siga as diretrizes abaixo.

## Código de Conduta

Este projeto e todos que participam dele são regidos pelo nosso [Código de Conduta](CODE_OF_CONDUCT.md). Ao participar, você concorda em seguir seus termos. _(Nota: O arquivo `CODE_OF_CONDUCT.md` será adicionado em breve)_.

## 💬 Como Contribuir

Existem várias formas de contribuir:

- **Reportando Bugs:** Se encontrar um problema, abra uma issue detalhando o erro, os passos para reproduzi-lo e o comportamento esperado.
- **Sugerindo Melhorias:** Tem uma ideia para uma nova funcionalidade ou melhoria? Abra uma issue para discutirmos.
- **Enviando Código:** Se deseja corrigir um bug ou implementar uma funcionalidade, siga o processo de Pull Request descrito abaixo.

## 🚀 Processo de Desenvolvimento (Pull Requests)

### 1. Faça o Fork e Clone

Comece fazendo um **fork** do repositório principal e, em seguida, clone o seu fork para sua máquina local.

```bash
git clone https://github.com/SEU-USUARIO/SEMARH-DESKTOP.git
cd SEMARH-DESKTOP
```

Adicione o repositório original como "upstream" para manter seu fork atualizado:

```bash
git remote add upstream https://github.com/marcio-dev-fullstack/SEMARH-DESKTOP.git
```

### 2. Crie uma Branch

Sempre crie uma nova branch para trabalhar em uma funcionalidade ou correção específica. Use um nome descritivo, seguindo o padrão abaixo:

- **Novas Funcionalidades:** `feature/nome-da-funcionalidade` (ex: `feature/exportar-relatorio-pdf`)
- **Correções de Bugs:** `bugfix/descricao-do-bug` (ex: `bugfix/validacao-campo-cpf`)
- **Documentação:** `docs/topico-documentado` (ex: `docs/atualizar-readme`)

```bash
# Exemplo para uma nova funcionalidade
git checkout -b feature/login-com-gov-br
```

### 3. Codifique!

Agora é a hora de fazer suas alterações. Siga os padrões de código do projeto.

#### Padrões de Código

- **PHP:** Siga o padrão **PSR-12**. Você pode usar ferramentas como o `PHP-CS-Fixer` para formatar seu código automaticamente.
- **Comentários:** Documente classes e métodos complexos usando o padrão PHPDoc.
- **Livewire & Blade:** Mantenha o código limpo e organizado. Use componentes sempre que possível para reutilização.

### 4. Faça Commits Atômicos

Faça commits pequenos e focados em uma única alteração lógica. Isso facilita a revisão do código. Siga o padrão **Conventional Commits** para as mensagens de commit.

**Formato:** `<tipo>(<escopo>): <assunto>`

- **Tipos comuns:** `feat` (nova funcionalidade), `fix` (correção de bug), `docs` (documentação), `style` (formatação), `refactor` (refatoração), `test` (testes).
- **Escopo (opcional):** A parte do código afetada (ex: `auth`, `processos`, `deploy`).

**Exemplos:**

```
feat(auth): adiciona integração com login GOV.BR
fix(processos): corrige cálculo de paginação na listagem
docs(readme): atualiza manual de instalação com Docker
```

### 5. Mantenha sua Branch Atualizada

Antes de enviar seu Pull Request, atualize sua branch com as últimas alterações do repositório principal.

```bash
git fetch upstream
git rebase upstream/main
```

### 6. Envie o Pull Request (PR)

Envie sua branch para o seu fork no GitHub e abra um Pull Request para a branch `main` do repositório original.

No seu PR, inclua:

- Um **título claro e descritivo**.
- Uma **descrição detalhada** do que foi feito e por quê.
- Se o PR resolve uma issue existente, mencione-a com `Closes #123`.

Após o envio, um dos mantenedores do projeto irá revisar seu código, fornecer feedback e, se tudo estiver correto, aprovar e fazer o merge.

---

Obrigado por sua contribuição! 🎉

# CPSA 2025 — Sistema de Gestão de Inscrições

> **1º Congresso de Psiquiatria e Saúde Mental em Angola**  
> Sistema web completo para gestão de inscrições, comprovativos, aprovações e certificados.

---

## Índice

- [Visão Geral](#visão-geral)
- [Stack Tecnológica](#stack-tecnológica)
- [Arquitectura do Sistema](#arquitectura-do-sistema)
- [Módulos Implementados](#módulos-implementados)
- [Modelo de Dados](#modelo-de-dados)
- [Estrutura de Pastas](#estrutura-de-pastas)
- [Instalação e Configuração](#instalação-e-configuração)
- [Variáveis de Ambiente](#variáveis-de-ambiente)
- [Autenticação e Controlo de Acesso](#autenticação-e-controlo-de-acesso)
- [Fluxo de Inscrição](#fluxo-de-inscrição)
- [Painel Administrativo](#painel-administrativo)
- [Certificados e Exportações](#certificados-e-exportações)
- [Sistema de Emails](#sistema-de-emails)
- [Segurança](#segurança)
- [Deploy em Produção](#deploy-em-produção)
- [Contas de Teste](#contas-de-teste)
- [Comandos Úteis](#comandos-úteis)

---

## Visão Geral

O CPSA 2025 é um sistema web desenvolvido em **Laravel 11** para gerir o processo completo de inscrições do 1º Congresso de Psiquiatria e Saúde Mental em Angola. O sistema cobre dois domínios principais:

**Portal do Participante** — permite que qualquer pessoa se inscreva online, faça upload do comprovativo de pagamento, acompanhe o estado da inscrição em tempo real e descarregue o certificado após aprovação.

**Painel da Comissão Organizadora** — permite que administradores e organizadores analisem inscrições, visualizem comprovativos, aprovem ou rejeitem pedidos com motivo, exportem dados e gerem certificados individualmente ou em lote.

```
Participante                          Comissão
    │                                     │
    ├─ Preenche formulário                ├─ Recebe notificação por email
    ├─ Upload comprovativo                ├─ Analisa comprovativo
    ├─ Recebe email de confirmação        ├─ Aprova ou rejeita
    ├─ Acompanha status                   ├─ Participante é notificado
    └─ Descarrega certificado             └─ Gera certificado PDF
```

---

## Stack Tecnológica

| Camada | Tecnologia |
|---|---|
| Backend | Laravel 11 / PHP 8.2+ |
| Base de dados | MySQL 8.0+ |
| Frontend | Blade · Tailwind CSS · Vite |
| Autenticação | Laravel Session Auth |
| Controlo de acesso | RBAC via tabela `roles` |
| Filas de trabalho | Laravel Queue (driver: database) |
| Geração de PDF | barryvdh/laravel-dompdf |
| Exportação Excel/CSV | maatwebsite/excel |
| Upload seguro | Laravel Storage (disco `private`) |
| Tipografia | Inter (Google Fonts) |

---

## Arquitectura do Sistema

```
┌─────────────────────────────────────────────────────────┐
│                        routes/web.php                   │
│   /          /inscricao        /admin/*                 │
└────────────────────┬────────────────────────────────────┘
                     │
        ┌────────────┴────────────┐
        │                        │
   Participant/             Admin/
   Controllers              Controllers
        │                        │
   InscricaoService         InscricaoService
   CertificadoService       CertificadoService
                            ExportacaoController
        │                        │
        └────────────┬───────────┘
                     │
              Models (Eloquent)
    Inscricao · Comprovativo · Certificado
    User · Role
                     │
              Jobs (Queue)
    EnviarEmailConfirmacao
    EnviarEmailAprovacao
    EnviarEmailRejeicao
    EnviarCertificado
    NotificarComissao
```

---

## Módulos Implementados

### 1. Autenticação
- Registo e login por sessão
- Logout com invalidação de sessão
- Redirecionamento automático por role
- Middleware `CheckRole` para protecção de rotas

### 2. RBAC — Controlo de Acesso

Três roles disponíveis:

| Role | Acesso |
|---|---|
| `admin` | Painel admin completo + todas as acções |
| `organizador` | Painel admin completo + todas as acções |
| `participante` | Portal público + área pessoal |

### 3. Inscrição do Participante
- Formulário com drag & drop de ficheiro
- Validação completa via `InscricaoRequest`
- Geração automática do número no formato `CPSA-2025-0001`
- Upload seguro para `storage/app/private/comprovativos/{ano}/`
- Hash SHA-256 do comprovativo para verificação de integridade
- Email de confirmação via queue

### 4. Painel Administrativo
- Dashboard com estatísticas em tempo real
- Distribuição por categoria e modalidade
- Últimas inscrições
- Acções rápidas

### 5. Gestão de Inscrições
- Listagem com filtros por status, categoria e modalidade
- Busca por nome, email, número ou instituição
- Paginação estilizada
- Detalhe completo com visualização do comprovativo (URL temporária 5 min)
- Aprovação com um clique
- Rejeição com motivo obrigatório

### 6. Exportação de Dados

| Formato | Endpoint | Conteúdo |
|---|---|---|
| Excel (.xlsx) | `GET /admin/exportar/excel` | Todas as inscrições com formatação |
| CSV | `GET /admin/exportar/csv` | Todas as inscrições |
| Lista de Presença | `GET /admin/exportar/presenca` | PDF A4 com coluna de assinatura |

### 7. Certificados
- Geração individual ou em lote
- Formato A4 horizontal com design oficial
- Código de verificação único (UUID)
- Armazenamento em `storage/app/private/certificados/{ano}/`
- Envio automático por email como anexo PDF
- Download seguro pelo participante e pelo admin

---

## Modelo de Dados

```
users
  id · name · email · password · telefone · ativo
  └──< role_user >──── roles
                         id · name · display_name

inscricoes
  id · numero (CPSA-2025-XXXX) · nome_completo · email
  telefone · instituicao · cargo
  categoria (medico|enfermeiro|psicologo|estudante|outro)
  tipo_participacao (presencial|online)
  status (pendente|em_analise|aprovada|rejeitada)
  avaliado_por · avaliado_em · motivo_rejeicao
  user_id · presente · checkin_em
  │
  ├──< comprovativos
  │      id · inscricao_id · nome_original · path
  │      mime_type · tamanho · hash
  │      status (pendente|aceite|rejeitado)
  │      revisto_por · revisto_em
  │
  └──  certificados
         id · inscricao_id (unique)
         path · codigo_verificacao · gerado_em · enviado_em
```

---

## Estrutura de Pastas

```
cpsa2025/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/AuthController.php
│   │   │   ├── Participant/InscricaoController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── InscricaoController.php
│   │   │       ├── CertificadoController.php
│   │   │       └── ExportacaoController.php
│   │   ├── Middleware/CheckRole.php
│   │   └── Requests/
│   │       ├── Auth/LoginRequest.php
│   │       ├── Auth/RegisterRequest.php
│   │       ├── InscricaoRequest.php
│   │       └── AvaliacaoRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Inscricao.php
│   │   ├── Comprovativo.php
│   │   └── Certificado.php
│   ├── Services/
│   │   ├── InscricaoService.php
│   │   └── CertificadoService.php
│   ├── Jobs/
│   │   ├── EnviarEmailConfirmacao.php
│   │   ├── EnviarEmailAprovacao.php
│   │   ├── EnviarEmailRejeicao.php
│   │   ├── EnviarCertificado.php
│   │   └── NotificarComissao.php
│   ├── Mail/
│   │   ├── InscricaoConfirmada.php
│   │   ├── InscricaoAprovada.php
│   │   ├── InscricaoRejeitada.php
│   │   ├── CertificadoDisponivel.php
│   │   └── NovaInscricaoComissao.php
│   └── Exports/
│       └── InscricoesExport.php
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_roles_table.php
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_inscricoes_table.php
│   │   ├── ..._create_comprovativos_table.php
│   │   └── ..._create_certificados_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php
│       └── InscricaoSeeder.php
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php             ← layout público
│   │   │   └── admin.blade.php           ← layout admin com sidebar
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── participant/
│   │   │   ├── index.blade.php           ← landing page
│   │   │   ├── inscricao.blade.php       ← formulário + drag & drop
│   │   │   ├── sucesso.blade.php         ← confirmação pós-submissão
│   │   │   └── minha-inscricao.blade.php ← área pessoal + timeline
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── inscricoes/index.blade.php
│   │   │   ├── inscricoes/show.blade.php
│   │   │   ├── certificados/index.blade.php
│   │   │   └── partials/status-badge.blade.php
│   │   ├── components/
│   │   │   ├── badge.blade.php
│   │   │   ├── card.blade.php
│   │   │   └── alert.blade.php
│   │   ├── emails/
│   │   │   ├── inscricao-confirmada.blade.php
│   │   │   ├── inscricao-aprovada.blade.php
│   │   │   ├── inscricao-rejeitada.blade.php
│   │   │   ├── certificado-disponivel.blade.php
│   │   │   └── nova-inscricao-comissao.blade.php
│   │   ├── pdf/
│   │   │   ├── certificado.blade.php     ← A4 landscape
│   │   │   └── lista-presenca.blade.php  ← A4 portrait
│   │   └── errors/
│   │       ├── 403.blade.php
│   │       ├── 404.blade.php
│   │       └── 500.blade.php
│   └── vendor/pagination/
│       └── tailwind.blade.php            ← paginação customizada
│
├── routes/web.php
│
└── storage/app/private/
    ├── comprovativos/{ano}/              ← uploads (nunca públicos)
    └── certificados/{ano}/              ← PDFs gerados
```

---

## Instalação e Configuração

### Pré-requisitos

- PHP 8.2+ com extensões: `pdo_mysql mbstring openssl gd xml bcmath`
- Composer 2+
- MySQL 8.0+
- Node.js 20+

### Passo a passo

```bash
# 1. Clonar o repositório
git clone https://github.com/sua-org/cpsa2025.git
cd cpsa2025

# 2. Instalar dependências PHP
composer install

# 3. Instalar dependências frontend
npm install

# 4. Copiar e configurar o ambiente
cp .env.example .env
php artisan key:generate

# 5. Configurar base de dados no .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Executar migrations e seeders
php artisan migrate --seed

# 7. Criar link simbólico para storage público
php artisan storage:link

# 8. Compilar assets
npm run dev      # desenvolvimento (com HMR)
npm run build    # produção

# 9. Iniciar servidor de desenvolvimento
php artisan serve
```

---

## Variáveis de Ambiente

```ini
# Aplicação
APP_NAME="CPSA 2025"
APP_ENV=local                          # local | production
APP_KEY=                               # gerado com key:generate
APP_DEBUG=true                         # false em produção obrigatoriamente
APP_URL=http://localhost:8000
APP_TIMEZONE=Africa/Luanda
APP_LOCALE=pt

# Base de dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cpsa2025
DB_USERNAME=root
DB_PASSWORD=

# Cache e sessões
CACHE_STORE=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Filas de trabalho
QUEUE_CONNECTION=database              # sync apenas para testes rápidos

# Email
MAIL_MAILER=log                        # log em dev · smtp em produção
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@cpsa2025.ao"
MAIL_FROM_NAME="CPSA 2025"
```

> Em desenvolvimento, use `MAIL_MAILER=log` para ver os emails em `storage/logs/laravel.log` sem configurar SMTP.

---

## Autenticação e Controlo de Acesso

### Mapa de rotas

```
Público (sem autenticação)
  GET  /
  GET  /inscricao
  POST /inscricao              ← throttle: 3 req / 10 min por IP
  GET  /inscricao/sucesso
  GET  /login · POST /login    ← throttle: 5 req / min por email+IP
  GET  /registro · POST /registro

Autenticado (qualquer role)
  GET  /minha-inscricao
  GET  /minha-inscricao/certificado

Admin ou Organizador
  GET   /admin/dashboard
  GET   /admin/inscricoes
  GET   /admin/inscricoes/{id}
  PATCH /admin/inscricoes/{id}/aprovar
  PATCH /admin/inscricoes/{id}/rejeitar
  GET   /admin/exportar/excel
  GET   /admin/exportar/csv
  GET   /admin/exportar/presenca
  GET   /admin/certificados
  POST  /admin/certificados/{id}/gerar
  POST  /admin/certificados/gerar-todos
  GET   /admin/certificados/{id}/download
```

### Uso do middleware

```php
// Aplicar numa rota
Route::middleware(['auth', 'role:admin,organizador'])->group(...);

// Verificar num controller ou service
$user->hasRole('admin');
$user->hasRole(['admin', 'organizador']);
```

---

## Fluxo de Inscrição

```
1. Participante acede /inscricao
   └─ Preenche: nome, email, telefone, instituição,
                cargo, categoria, modalidade + comprovativo

2. Submissão (POST /inscricao)
   ├─ InscricaoRequest valida todos os campos
   ├─ InscricaoService::criar()
   │   ├─ Gera número CPSA-2025-XXXX (sequencial por ano)
   │   ├─ Cria registo com status = pendente
   │   ├─ Salva ficheiro em storage/app/private/comprovativos/
   │   ├─ Calcula hash SHA-256 do ficheiro
   │   ├─ Cria registo Comprovativo
   │   ├─ Dispatch: EnviarEmailConfirmacao → queue:emails
   │   └─ Dispatch: NotificarComissao → queue:emails
   └─ Redireciona para /inscricao/sucesso

3. Comissão analisa em /admin/inscricoes/{id}
   ├─ Visualiza comprovativo (URL temporária 5 min)
   ├─ Aprova → status = aprovada
   │   └─ Dispatch: EnviarEmailAprovacao → queue:emails
   └─ Rejeita (motivo obrigatório) → status = rejeitada
       └─ Dispatch: EnviarEmailRejeicao → queue:emails

4. Participante acede /minha-inscricao
   └─ Timeline mostra estado actual em tempo real

5. Após aprovação, admin gera certificado
   ├─ CertificadoService::gerar()
   │   ├─ Gera PDF A4 landscape via DomPDF
   │   ├─ Salva em storage/app/private/certificados/
   │   ├─ Cria registo com código de verificação UUID
   │   └─ Dispatch: EnviarCertificado → queue:emails (PDF em anexo)
   └─ Participante descarrega em /minha-inscricao
```

---

## Painel Administrativo

### Dashboard
- Total de inscrições e distribuição por status (pendente, em análise, aprovada, rejeitada)
- Barras de progresso por categoria profissional
- Distribuição presencial vs online
- Atalhos rápidos para inscrições pendentes, exportação e certificados
- Tabela das últimas 8 inscrições com link directo para detalhe

### Listagem de Inscrições
- Filtros de status com contadores em badge (Todas / Pendentes / Em Análise / Aprovadas / Rejeitadas)
- Filtro por categoria e modalidade
- Busca full-text em nome, email, número de inscrição e instituição
- Paginação (15 por página) com indicação "A mostrar X–Y de Z resultados"
- Indicador visual de comprovativo enviado

### Detalhe da Inscrição
- Todos os dados do participante em tabela clara
- Pré-visualização do comprovativo (imagens) ou link temporário de 5 minutos (PDFs)
- Painel lateral de acções: aprovar / rejeitar com campo de motivo obrigatório
- Histórico de avaliação: quem avaliou e quando
- Botão de geração de certificado disponível após aprovação

---

## Certificados e Exportações

### Certificado PDF (A4 landscape)
- Faixa gradiente azul → violeta no topo
- Bordas decorativas duplas (azul externo + azul claro interno)
- Nome do participante em destaque (26pt azul)
- Categoria e modalidade de participação
- Número de inscrição e data de emissão
- Duas linhas de assinatura: Comissão Científica + Comissão Organizadora
- Código de verificação UUID no rodapé direito

### Exportação Excel (.xlsx)
- Cabeçalho formatado em fundo `#1e40af` com texto branco
- 14 colunas com larguras optimizadas para leitura
- Inclui: número, dados pessoais, categoria, modalidade, status, avaliação, motivo de rejeição
- Filtrável por status: `?status=aprovada`

### Lista de Presença (PDF A4 portrait)
- Ordenada alfabeticamente por nome
- Colunas: nº sequencial, número de inscrição, nome, cargo, instituição, categoria, modalidade, assinatura
- Coluna de assinatura com linha tracejada para rubrica no dia
- Rodapé com data e hora de geração automática

---

## Sistema de Emails

Todos os emails são enviados de forma assíncrona via queue (fila `emails`).

| Evento | Destinatário | Assunto |
|---|---|---|
| Inscrição submetida | Participante | Inscrição Confirmada — CPSA-2025-XXXX |
| Inscrição submetida | Todos os admins/organizadores | Nova Inscrição — CPSA-2025-XXXX |
| Inscrição aprovada | Participante | ✅ Inscrição Aprovada — CPSA-2025-XXXX |
| Inscrição rejeitada | Participante | ❌ Inscrição Não Aprovada — CPSA-2025-XXXX |
| Certificado gerado | Participante | 🏅 O seu Certificado — CPSA-2025-XXXX (PDF anexo) |

Cada job tem `tries = 3` com `backoff = 60` segundos entre tentativas.

```bash
# Processar queue em desenvolvimento
php artisan queue:work --queue=emails --tries=3 --sleep=3

# Ver emails no log (quando MAIL_MAILER=log)
tail -f storage/logs/laravel.log
```

---

## Segurança

| Medida | Detalhe |
|---|---|
| CSRF | Activado em todas as rotas POST / PATCH / DELETE |
| Rate Limiting | 3 inscrições / 10 min por IP · 5 logins / min por email+IP |
| Upload seguro | Disco `private` — ficheiros inacessíveis por URL directa |
| URLs temporárias | Comprovativos com acesso máximo de 5 minutos |
| Integridade de ficheiros | Hash SHA-256 calculado e armazenado em cada upload |
| RBAC | Middleware `CheckRole` obrigatório em todas as rotas `/admin/*` |
| FormRequests | Validação de todas as entradas antes de qualquer lógica |
| Soft Deletes | Inscrições nunca são eliminadas fisicamente da base de dados |
| XSS | Blade escapa todo o output por defeito com `{{ }}` |
| SQL Injection | Eloquent ORM com queries parametrizadas |

---

## Deploy em Produção

### Requisitos do servidor
- PHP 8.2+ com extensões: `pdo_mysql mbstring openssl gd xml bcmath`
- MySQL 8.0+
- Nginx ou Apache
- Supervisor (para o queue worker persistente)
- Certificado SSL (HTTPS obrigatório)

### Passos

```bash
# 1. Dependências sem pacotes de desenvolvimento
composer install --no-dev --optimize-autoloader

# 2. Compilar assets para produção
npm run build

# 3. Ambiente de produção
APP_ENV=production
APP_DEBUG=false

# 4. Migrations
php artisan migrate --force

# 5. Apenas roles e admin padrão
php artisan db:seed --class=RoleSeeder

# 6. Link de storage
php artisan storage:link

# 7. Optimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 8. Permissões correctas
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Configuração do Supervisor

Ficheiro `/etc/supervisor/conf.d/cpsa-worker.conf`:

```ini
[program:cpsa-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/cpsa2025/artisan queue:work database --queue=emails --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/cpsa2025/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
supervisorctl reread && supervisorctl update
supervisorctl start cpsa-worker:*
```

### Checklist pós-deploy

- [ ] `APP_DEBUG=false` confirmado
- [ ] HTTPS activo com SSL válido
- [ ] `storage/app/private` inacessível por URL directa
- [ ] Senha do admin padrão alterada imediatamente
- [ ] SMTP configurado e email de teste enviado
- [ ] Queue worker activo e a monitorizar via Supervisor
- [ ] Backup automático da base de dados agendado

---

## Contas de Teste

Após `php artisan migrate --seed`:

| Nome | Email | Senha | Role |
|---|---|---|---|
| Administrador CPSA | `admin@cpsa2025.ao` | `Admin@2025!` | admin + organizador |
| Ana Paula Ferreira | `ana.ferreira@hospital.ao` | `Password@123` | participante |
| Carlos Manuel Neto | `carlos.neto@clinica.ao` | `Password@123` | participante |
| Maria da Conceição Silva | `msilva@univ.ao` | `Password@123` | participante |
| João António Lopes | `joao.lopes@estudante.ao` | `Password@123` | participante |
| Esperança Domingos | `esperanca.d@saude.gov.ao` | `Password@123` | participante |
| Paulo Sebastião Mbala | `paulo.mbala@hpd.ao` | `Password@123` | participante |
| Luísa Beatriz Tavares | `luisa.tavares@univ.ao` | `Password@123` | participante |
| Domingos Cardoso | `domingos.c@hospital.ao` | `Password@123` | participante |

**Distribuição dos dados de seed:**

| Status | Quantidade |
|---|---|
| Aprovada | 3 |
| Pendente | 2 |
| Em Análise | 1 |
| Rejeitada | 1 (com motivo) |

---

## Comandos Úteis

```bash
# ── Desenvolvimento ───────────────────────────────────────
php artisan serve                          # servidor local :8000
npm run dev                                # Vite com HMR
php artisan queue:work --queue=emails      # processar emails

# ── Base de dados ─────────────────────────────────────────
php artisan migrate                        # correr migrations pendentes
php artisan migrate:fresh --seed           # reset completo + seed
php artisan db:seed --class=RoleSeeder     # apenas roles e admin

# ── Optimização ───────────────────────────────────────────
php artisan optimize                       # cache config + routes + views
php artisan optimize:clear                 # limpar todos os caches

# ── Diagnóstico ───────────────────────────────────────────
php artisan about                          # info do ambiente Laravel
php artisan route:list                     # todas as rotas registadas
php artisan queue:monitor                  # estado da queue

# ── Tinker (console interactivo) ──────────────────────────
php artisan tinker
>>> App\Models\Inscricao::count()
>>> App\Models\Inscricao::gerarNumero()
>>> App\Models\User::first()->hasRole('admin')
>>> App\Models\Inscricao::where('status','aprovada')->count()
>>> Storage::disk('private')->files('certificados/2025')
```

---

## Componentes Blade Reutilizáveis

```blade
{{-- Badge de estado --}}
<x-badge type="success">Aprovada</x-badge>
<x-badge type="warning">Pendente</x-badge>
<x-badge type="danger" size="sm">Rejeitada</x-badge>
<x-badge type="info">Em Análise</x-badge>

{{-- Card base --}}
<x-card padding="p-8" class="mt-4">
    Conteúdo aqui
</x-card>

{{-- Alerta dismissível --}}
<x-alert type="warning" title="Atenção" :dismissible="true">
    O seu comprovativo está a ser analisado.
</x-alert>
```

Tipos de badge: `success` · `warning` · `danger` · `info` · `purple` · `default`

---

## Design System

```js
// tailwind.config.js
colors: {
  primary:    { DEFAULT: '#1e40af', hover: '#1d3899', light: '#dbeafe' },
  secondary:  { DEFAULT: '#7c3aed', hover: '#6d28d9', light: '#ede9fe' },
  success:    { DEFAULT: '#10b981', hover: '#059669', light: '#d1fae5' },
  warning:    { DEFAULT: '#f59e0b', hover: '#d97706', light: '#fef3c7' },
  danger:     { DEFAULT: '#ef4444', hover: '#dc2626', light: '#fee2e2' },
  background: '#f9fafb',
}
```

| Elemento | Fonte | Peso | Tamanho |
|---|---|---|---|
| Títulos | Inter | Bold (700) | 24px |
| Subtítulos | Inter | SemiBold (600) | 18px |
| Texto corpo | Inter | Regular (400) | 14px |
| Labels | Inter | Medium (500) | 12px |

---

## Configuração Regional

| Parâmetro | Valor |
|---|---|
| Fuso horário | `Africa/Luanda` (UTC+1) |
| Idioma da aplicação | Português (Angola) |
| Moeda | AOA — Kwanza Angolano |
| Formato de número de inscrição | `CPSA-{ANO}-{0001}` |
| Formato de datas na UI | `dd/mm/YYYY HH:mm` |

---

*Desenvolvido para o 1º Congresso de Psiquiatria e Saúde Mental em Angola · CPSA 2025 · Luanda, Angola*

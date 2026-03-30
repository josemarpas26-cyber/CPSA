@extends('layouts.app')
@section('title','Inscrição')
@section('content')
<style>
/* ── Reset de base ───────────────────────────────────── */
.form-wrap{max-width:760px;margin:0 auto;padding:3rem 1.5rem 4rem;}

/* ── Stepper ─────────────────────────────────────────── */
.stepper{
  display:flex;align-items:flex-start;gap:0;
  margin-bottom:2.5rem;position:relative;
}
.stepper::before{
  content:'';position:absolute;top:18px;left:18px;
  right:18px;height:2px;background:var(--divider);z-index:0;
}
.step-item{
  flex:1;display:flex;flex-direction:column;align-items:center;
  gap:.45rem;position:relative;z-index:1;cursor:pointer;
  user-select:none;
}
.step-bullet{
  width:36px;height:36px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:.72rem;font-weight:800;letter-spacing:.01em;
  border:2px solid var(--divider);background:white;
  color:var(--text-3);transition:all .25s;
  position:relative;z-index:1;
}
.step-label{
  font-size:.62rem;font-weight:700;letter-spacing:.06em;
  text-transform:uppercase;color:var(--text-4);
  text-align:center;line-height:1.35;transition:color .25s;
  max-width:70px;
}

/* Estados do step */
.step-item.completed .step-bullet{
  background:var(--blue-vivid);border-color:var(--blue-vivid);color:white;
}
.step-item.active .step-bullet{
  background:white;border-color:var(--blue-vivid);
  color:var(--blue-vivid);box-shadow:0 0 0 4px rgba(37,99,235,.12);
}
.step-item.active .step-label{ color:var(--blue-vivid); }
.step-item.completed .step-label{ color:var(--text-2); }
.step-item.locked{ cursor:not-allowed;opacity:.5; }
.step-item.locked .step-bullet{ cursor:not-allowed; }

/* Ícone de check */
.step-item.completed .step-bullet::after{
  content:'';display:block;width:10px;height:6px;
  border-left:2px solid white;border-bottom:2px solid white;
  transform:rotate(-45deg) translate(1px,-1px);
}

/* ── Painel de cartão ────────────────────────────────── */
.form-card{
  background:var(--card);border:1px solid var(--card-border);
  border-radius:var(--r-xl);box-shadow:var(--shadow-md);overflow:hidden;
}

/* ── Cabeçalho do passo ──────────────────────────────── */
.step-header{
  padding:1.5rem 2rem 1.25rem;
  border-bottom:1px solid var(--divider);
  background:var(--surface);
}
.step-header-num{
  font-size:.6rem;font-weight:800;letter-spacing:.1em;
  text-transform:uppercase;color:var(--blue-vivid);margin-bottom:.2rem;
}
.step-header-title{
  font-family:var(--font-display);font-style:italic;
  font-size:1.2rem;color:var(--text-1);margin:0;
}

/* ── Painel de passo ─────────────────────────────────── */
.step-panel{ display:none;padding:1.75rem 2rem; }
.step-panel.active{ display:block; }

/* ── Inputs ──────────────────────────────────────────── */
.field-grid-2{ display:grid;grid-template-columns:1fr 1fr;gap:.875rem; }
.field-grid-3{ display:grid;grid-template-columns:1fr 1fr 1fr;gap:.875rem; }
.field-group{ display:flex;flex-direction:column;gap:.875rem; }
.field-group + .field-group{ margin-top:.875rem; }

/* ── Radio options ───────────────────────────────────── */
.radio-option{
  display:flex;align-items:center;gap:.75rem;
  padding:.75rem 1rem;border:1px solid var(--card-border);border-radius:var(--r-sm);
  cursor:pointer;transition:all .18s;background:white;flex:1;
}
.radio-option:has(input:checked){border-color:var(--blue-vivid);background:#f0f6ff;}

/* ── Course cards ────────────────────────────────────── */
.course-cards{display:flex;flex-direction:column;gap:.625rem;margin-top:.5rem;}
.course-card{
  display:flex;align-items:flex-start;gap:.875rem;
  padding:1rem 1.125rem;border:2px solid var(--card-border);
  border-radius:var(--r-md);cursor:pointer;
  transition:border-color .18s,background .18s,box-shadow .18s;background:white;
}
.course-card:has(input:checked){
  border-color:var(--blue-vivid);background:rgba(37,99,235,.03);
  box-shadow:0 0 0 3px rgba(37,99,235,.08);
}
.course-card.full{opacity:.6;cursor:not-allowed;background:var(--surface);border-color:var(--card-border);}
.course-card input[type=radio]{margin-top:2px;width:15px;height:15px;accent-color:var(--blue-vivid);flex-shrink:0;}
.course-badge{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:99px;white-space:nowrap;
}

/* ── Upload zone ─────────────────────────────────────── */
.upload-zone{
  border:2px dashed var(--card-border);border-radius:var(--r-lg);
  padding:2rem 1.5rem;text-align:center;
  transition:all .2s;cursor:pointer;background:var(--surface);
}
.upload-zone:hover,.upload-zone.dragover{border-color:var(--blue-vivid);background:#f0f6ff;}
.upload-zone.has-file{border-color:var(--success);background:var(--success-bg);}

/* ── Navegação ───────────────────────────────────────── */
.step-nav{
  padding:1.25rem 2rem;border-top:1px solid var(--divider);
  background:var(--surface);
  display:flex;align-items:center;justify-content:space-between;gap:1rem;
}
.btn-back{
  display:inline-flex;align-items:center;gap:.4rem;
  padding:.6rem 1.2rem;border:1px solid var(--card-border);border-radius:var(--r-sm);
  font-size:.8rem;font-weight:600;color:var(--text-2);background:white;
  cursor:pointer;transition:all .15s;
}
.btn-back:hover{ border-color:var(--text-3);color:var(--text-1); }
.btn-next{
  display:inline-flex;align-items:center;gap:.4rem;
  padding:.65rem 1.5rem;border-radius:var(--r-sm);border:none;
  font-size:.82rem;font-weight:700;color:white;background:var(--blue-vivid);
  cursor:pointer;transition:all .15s;
}
.btn-next:hover{ background:var(--blue-dark,#1d4ed8); }
.btn-next:disabled{ opacity:.5;cursor:not-allowed; }

/* ── Progresso ───────────────────────────────────────── */
.progress-bar{
  height:3px;background:var(--divider);position:relative;overflow:hidden;
}
.progress-fill{
  height:100%;background:var(--blue-vivid);
  transition:width .4s cubic-bezier(.4,0,.2,1);
}

/* ── Erros inline ────────────────────────────────────── */
.field-error{
  font-size:.72rem;color:var(--danger);margin-top:.3rem;
  display:flex;align-items:center;gap:.25rem;
}
.field-error::before{ content:'⚠'; font-size:.65rem; }
.input-err{ border-color:var(--danger)!important;background:#fff5f5!important; }

/* ── Resumo final ────────────────────────────────────── */
.summary-grid{
  display:grid;grid-template-columns:1fr 1fr;gap:.75rem 2rem;
  font-size:.82rem;
}
.summary-row{ display:contents; }
.summary-label{ color:var(--text-3);padding:.3rem 0; }
.summary-value{ color:var(--text-1);font-weight:600;padding:.3rem 0; }
.summary-divider{
  grid-column:1/-1;height:1px;background:var(--divider);margin:.25rem 0;
}

@keyframes slideIn{
  from{opacity:0;transform:translateX(18px);}
  to{opacity:1;transform:translateX(0);}
}
.step-panel.active{ animation:slideIn .28s ease; }
@media(max-width:560px){
  .field-grid-2,.field-grid-3{ grid-template-columns:1fr; }
  .step-panel{ padding:1.25rem 1rem; }
  .step-nav{ padding:1rem; }
  .step-header{ padding:1.25rem 1rem 1rem; }
  .summary-grid{ grid-template-columns:1fr; }
  .summary-label{ padding-bottom:0; }
  .summary-value{ padding-top:.1rem;border-bottom:1px solid var(--divider); }
}
</style>

<div class="form-wrap">

  {{-- Cabeçalho --}}
  <div style="margin-bottom:2rem;">
    <p class="section-label" style="margin-bottom:.3rem;">CPSM 2026</p>
    <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.75rem;
               color:var(--text-1);margin:0 0 .5rem;">Formulário de Inscrição</h1>
    <p style="font-size:.82rem;color:var(--text-3);margin:0;">
      Iº Congresso de Psiquiatria e Saúde Mental em Angola
    </p>
  </div>

  {{-- Stepper --}}
  <div class="stepper" id="stepper">
    @php
      $steps = [
        ['Dados','Pessoais'],
        ['Dados','Profissionais'],
        ['Contacto','& Local'],
        ['Curso','& Modo'],
        ['Comprovativo','& Envio'],
      ];
    @endphp
    @foreach($steps as $i => $s)
    <div class="step-item {{ $i===0?'active':'locked' }}" data-step="{{ $i }}" id="step-item-{{ $i }}">
      <div class="step-bullet">{{ $i+1 }}</div>
      <span class="step-label">{{ $s[0] }}<br>{{ $s[1] }}</span>
    </div>
    @endforeach
  </div>

  {{-- Cartão do formulário --}}
  <div class="form-card">

    {{-- Barra de progresso --}}
    <div class="progress-bar"><div class="progress-fill" id="progress-fill" style="width:20%"></div></div>

    <form method="POST" action="{{ route('inscricao.store') }}"
          enctype="multipart/form-data" id="form-inscricao" novalidate>
      @csrf

      {{-- ══════════════════════════════════════════
           PASSO 1 — Dados Pessoais
      ══════════════════════════════════════════ --}}
      <div class="step-header" id="header-0">
        <p class="step-header-num">Passo 1 de 5</p>
        <h2 class="step-header-title">Dados Pessoais</h2>
      </div>
      <div class="step-panel active" id="panel-0">
        <div class="field-group">
          <div>
            <label class="form-label">Nome completo <span style="color:var(--danger);">*</span></label>
            <input type="text" name="full_name" id="full_name"
                   value="{{ old('full_name') }}"
                   class="form-input" placeholder="Nome tal como consta no documento de identificação">
            <p class="field-error" id="err-full_name" style="display:none;"></p>
          </div>

          <div class="field-grid-2">
            <div>
              <label class="form-label">Género <span style="color:var(--danger);">*</span></label>
              <select name="gender" id="gender" class="form-input">
                <option value="">Seleccionar...</option>
                @foreach(['masculino'=>'Masculino','feminino'=>'Feminino','outro'=>'Outro'] as $v=>$l)
                  <option value="{{ $v }}" {{ old('gender')===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
              </select>
              <p class="field-error" id="err-gender" style="display:none;"></p>
            </div>
            <div>
              <label class="form-label">Data de nascimento <span style="color:var(--danger);">*</span></label>
              <input type="date" name="date_of_birth" id="date_of_birth"
                     value="{{ old('date_of_birth') }}" class="form-input">
              <p class="field-error" id="err-date_of_birth" style="display:none;"></p>
            </div>
          </div>

          <div class="field-grid-2">
            <div>
              <label class="form-label">Nacionalidade <span style="color:var(--danger);">*</span></label>
              <select name="nationality" id="nationality" class="form-input">
                @php
                  $countries=['AO'=>'Angolana','BR'=>'Brasileira','PT'=>'Portuguesa',
                               'US'=>'Americana','FR'=>'Francesa','CN'=>'Chinesa',
                               'ZA'=>'Sul-Africana','NA'=>'Namibiana','MZ'=>'Moçambicana'];
                  $selected=old('nationality','AO');
                @endphp
                @foreach($countries as $code=>$name)
                  <option value="{{ $code }}" {{ $selected===$code?'selected':'' }}>{{ $name }}</option>
                @endforeach
              </select>
              <p class="field-error" id="err-nationality" style="display:none;"></p>
            </div>
            <div>
              <label class="form-label">Nº BI / Passaporte <span style="color:var(--danger);">*</span></label>
              <input type="text" name="document_number" id="document_number"
                     value="{{ old('document_number') }}"
                     class="form-input" placeholder="Ex: 0123456789LA041">
              <p class="field-error" id="err-document_number" style="display:none;"></p>
            </div>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════════════
           PASSO 2 — Dados Profissionais
      ══════════════════════════════════════════ --}}
      <div class="step-header" id="header-1" style="display:none;">
        <p class="step-header-num">Passo 2 de 5</p>
        <h2 class="step-header-title">Dados Profissionais</h2>
      </div>
      <div class="step-panel" id="panel-1">
        <div class="field-group">
          <div class="field-grid-2">
            <div>
              <label class="form-label">Profissão <span style="color:var(--danger);">*</span></label>
              <input type="text" name="profession" id="profession"
                     value="{{ old('profession') }}"
                     class="form-input" placeholder="Ex: Médico Psiquiatra">
              <p class="field-error" id="err-profession" style="display:none;"></p>
            </div>
            <div>
              <label class="form-label">Instituição <span style="color:var(--danger);">*</span></label>
              <input type="text" name="institution" id="institution"
                     value="{{ old('institution') }}"
                     class="form-input" placeholder="Local de trabalho ou estudo">
              <p class="field-error" id="err-institution" style="display:none;"></p>
            </div>
          </div>

          <div>
            <label class="form-label">Categoria <span style="color:var(--danger);">*</span></label>
            <select name="category" id="category" class="form-input">
              <option value="">Seleccionar...</option>
              @foreach(['profissional'=>'Profissional de Saúde','estudante'=>'Estudante',
                        'orador'=>'Orador','convidado'=>'Convidado','imprensa'=>'Imprensa'] as $v=>$l)
                <option value="{{ $v }}" {{ old('category')===$v?'selected':'' }}>{{ $l }}</option>
              @endforeach
            </select>
            <p class="field-error" id="err-category" style="display:none;"></p>
          </div>

          <div>
            <label class="form-label">Observações <span style="color:var(--text-4);font-weight:400;">(opcional)</span></label>
            <textarea name="observations" rows="3" class="form-input" style="resize:vertical;"
                      placeholder="Informações adicionais relevantes...">{{ old('observations') }}</textarea>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════════════
           PASSO 3 — Contacto & Localização
      ══════════════════════════════════════════ --}}
      <div class="step-header" id="header-2" style="display:none;">
        <p class="step-header-num">Passo 3 de 5</p>
        <h2 class="step-header-title">Contacto & Localização</h2>
      </div>
      <div class="step-panel" id="panel-2">
        <div class="field-group">
          <div class="field-grid-2">
            <div>
              <label class="form-label">Telefone (WhatsApp) <span style="color:var(--danger);">*</span></label>
              <input type="text" name="phone" id="phone"
                     value="{{ old('phone') }}"
                     class="form-input" placeholder="+244 9XX XXX XXX">
              <p class="field-error" id="err-phone" style="display:none;"></p>
            </div>
            <div>
              <label class="form-label">E-mail <span style="color:var(--danger);">*</span></label>
              <input type="email" name="email" id="email"
                     value="{{ old('email') }}" class="form-input">
              <p class="field-error" id="err-email" style="display:none;"></p>
            </div>
          </div>

          <div>
            <label class="form-label">Província / País <span style="color:var(--danger);">*</span></label>
            <input type="text" name="province" id="province"
                   value="{{ old('province') }}"
                   class="form-input" placeholder="Ex: Luanda · Angola">
            <p class="field-error" id="err-province" style="display:none;"></p>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════════════
           PASSO 4 — Curso & Modo de Participação
      ══════════════════════════════════════════ --}}
      <div class="step-header" id="header-3" style="display:none;">
        <p class="step-header-num">Passo 4 de 5</p>
        <h2 class="step-header-title">Curso & Modo de Participação</h2>
      </div>
      <div class="step-panel" id="panel-3">
        <div class="field-group">

          {{-- Modo de participação --}}
          <div>
            <label class="form-label">Modo de participação <span style="color:var(--danger);">*</span></label>
            <div style="display:flex;gap:.5rem;margin-top:.25rem;">
              @foreach(['presencial'=>'Presencial','online'=>'Online'] as $v=>$l)
                <label class="radio-option">
                  <input type="radio" name="participation_mode" value="{{ $v }}"
                         {{ old('participation_mode')===$v?'checked':'' }}>
                  <span style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $l }}</span>
                </label>
              @endforeach
            </div>
            <p class="field-error" id="err-participation_mode" style="display:none;"></p>
          </div>

          {{-- Cursos --}}
          <div>
            <label class="form-label">Curso / Workshop <span style="color:var(--danger);">*</span></label>
            <p style="font-size:.75rem;color:var(--text-3);margin:.15rem 0 .75rem;">
              Seleccione um curso. A inscrição é individual por curso.
            </p>
            <p class="field-error" id="err-curso_id" style="display:none;"></p>

            @if($cursos->isEmpty())
              <div style="padding:1.5rem;background:var(--surface);border-radius:var(--r-md);
                          border:1px solid var(--card-border);text-align:center;">
                <p style="font-size:.82rem;color:var(--text-3);margin:0;">Nenhum curso disponível de momento.</p>
              </div>
            @else
              <div class="course-cards">
                @foreach($cursos as $curso)
                  @php
                    $inscritos = $curso->inscricoes_count;
                    $cheio     = $curso->vagas && $inscritos >= $curso->vagas;
                  @endphp
                  <label class="course-card {{ $cheio?'full':'' }}">
                    <input type="radio" name="curso_id" value="{{ $curso->id }}"
                           {{ old('curso_id')==(string)$curso->id?'checked':'' }}
                           {{ $cheio?'disabled':'' }}>
                    <div style="flex:1;min-width:0;">
                      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;flex-wrap:wrap;">
                        <p style="font-size:.85rem;font-weight:700;color:var(--text-1);margin:0 0 .25rem;">
                          {{ $curso->nome }}
                        </p>
                        <div style="display:flex;gap:.35rem;flex-wrap:wrap;flex-shrink:0;">
                          <span class="course-badge" style="background:#eff6ff;color:var(--blue-vivid);">
                            <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $curso->sala }}
                          </span>
                          @if($cheio)
                            <span class="course-badge" style="background:var(--danger-bg);color:var(--danger);">Esgotado</span>
                          @elseif($curso->vagas)
                            <span class="course-badge" style="background:#ecfdf5;color:var(--success);">{{ $curso->vagas-$inscritos }} vagas</span>
                          @endif
                        </div>
                      </div>
                      <div style="display:flex;align-items:center;gap:.625rem;flex-wrap:wrap;margin-bottom:.35rem;">
                        <span style="font-size:.72rem;color:var(--text-3);display:flex;align-items:center;gap:3px;">
                          <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                          </svg>
                          {{ $curso->dia->isoFormat('ddd, DD/MM/YYYY') }}
                        </span>
                        <span style="font-size:.72rem;color:var(--text-3);display:flex;align-items:center;gap:3px;">
                          <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                          </svg>
                          {{ substr($curso->hora_inicio,0,5) }} – {{ substr($curso->hora_fim,0,5) }}
                        </span>
                      </div>
                      @if($curso->descricao)
                        <p style="font-size:.73rem;color:var(--text-3);margin:0;line-height:1.5;">
                          {{ Str::limit($curso->descricao,120) }}
                        </p>
                      @endif
                      @if($curso->speakers->isNotEmpty())
                        <div style="display:flex;align-items:center;gap:.375rem;margin-top:.5rem;flex-wrap:wrap;">
                          <span style="font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--text-4);">Palestrante(s):</span>
                          @foreach($curso->speakers as $sp)
                            <span style="font-size:.7rem;font-weight:600;color:var(--text-2);">{{ $sp->nome }}{{ !$loop->last?' ·':'' }}</span>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  </label>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════════════
           PASSO 5 — Comprovativo & Revisão
      ══════════════════════════════════════════ --}}
      <div class="step-header" id="header-4" style="display:none;">
        <p class="step-header-num">Passo 5 de 5</p>
        <h2 class="step-header-title">Comprovativo & Revisão</h2>
      </div>
      <div class="step-panel" id="panel-4">

{{-- Upload --}}
<div style="margin-bottom:.5rem;">
  <label class="form-label" for="comprovativo-input"
         style="font-size:1rem; color:var(--danger); font-weight:700;">
    Seleccione o comprovativo de pagamento <span style="color:var(--danger);">*</span>
  </label>

  <p style="font-size:.9rem; color:var(--danger); margin:.2rem 0 0;">
    Anexe o comprovativo (PDF/JPG/PNG) até 5 MB.
  </p>
</div>

        {{-- Upload --}}
        <div class="upload-zone" id="drop-zone"
             onclick="document.getElementById('comprovativo-input').click()">
          <div id="upload-idle">
            <div style="width:44px;height:44px;border-radius:var(--r-md);background:var(--surface);
                        display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;
                        border:1px solid var(--divider);">
              <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--text-3)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
              </svg>
            </div>
            <p style="font-size:.83rem;font-weight:600;color:var(--text-2);margin:0 0 .25rem;">
              Arraste o ficheiro ou clique para seleccionar
            </p>
            <p style="font-size:.72rem;color:var(--text-4);margin:0;">PDF, JPG, JPEG, PNG — máx. 5 MB</p>
          </div>
          <div id="upload-selected" style="display:none;">
            <div style="width:44px;height:44px;border-radius:var(--r-md);background:var(--success-bg);
                        display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;
                        border:1px solid #a7f3d0;">
              <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--success)" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <p id="upload-name" style="font-size:.83rem;font-weight:600;color:var(--success);margin:0 0 .2rem;"></p>
            <p id="upload-size" style="font-size:.72rem;color:var(--text-3);margin:0;"></p>
          </div>
          <input type="file" id="comprovativo-input" name="comprovativo"
                 accept=".pdf,.jpg,.jpeg,.png" style="display:none;"
                 onchange="handleFile(this)">
        </div>
        <p class="field-error" id="err-comprovativo" style="display:none;margin-top:.5rem;"></p>

        {{-- Resumo --}}
        <div style="margin-top:1.75rem;">
          <p style="font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
                    color:var(--text-3);margin-bottom:.875rem;">Resumo da inscrição</p>
          <div class="summary-grid" id="summary-grid">
            {{-- preenchido via JS --}}
          </div>
        </div>

      </div>

      {{-- ── Navegação ── --}}
      <div class="step-nav">
        <button type="button" class="btn-back" id="btn-back" style="visibility:hidden;" onclick="goBack()">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
          </svg>
          Anterior
        </button>

        <span style="font-size:.72rem;color:var(--text-4);" id="nav-hint">
          Campos obrigatórios marcados com <span style="color:var(--danger);">*</span>
        </span>

        <button type="button" class="btn-next" id="btn-next" onclick="goNext()">
          Próximo
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </button>

        <button type="submit" class="btn-next" id="btn-submit"
                style="display:none;background:var(--success);">

          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
          Submeter inscrição
        </button>
      </div>

    </form>
  </div>{{-- /form-card --}}
</div>{{-- /form-wrap --}}

<script>
// ── Estado ─────────────────────────────────────────────────────
let currentStep = 0;
const totalSteps = 5;
const completedSteps = new Set(); // steps que passaram validação

// Labels legíveis para o resumo
const fieldLabels = {
  full_name:          'Nome completo',
  gender:             'Género',
  date_of_birth:      'Data de nascimento',
  nationality:        'Nacionalidade',
  document_number:    'Nº BI / Passaporte',
  profession:         'Profissão',
  institution:        'Instituição',
  category:           'Categoria',
  phone:              'Telefone',
  email:              'E-mail',
  province:           'Província / País',
  participation_mode: 'Modo de participação',
  curso_id:           'Curso',
};

// ── Regras de validação por passo ──────────────────────────────
const stepRules = {
  0: [
    { id: 'full_name',       msg: 'Nome completo é obrigatório.' },
    { id: 'gender',          msg: 'Seleccione o género.' },
    { id: 'date_of_birth',   msg: 'Data de nascimento é obrigatória.' },
    { id: 'document_number', msg: 'Nº de documento é obrigatório.' },
  ],
  1: [
    { id: 'profession',  msg: 'Profissão é obrigatória.' },
    { id: 'institution', msg: 'Instituição é obrigatória.' },
    { id: 'category',    msg: 'Seleccione uma categoria.' },
  ],
  2: [
    { id: 'phone',    msg: 'Telefone é obrigatório.' },
    { id: 'email',    msg: 'E-mail é obrigatório.', extra: 'email' },
    { id: 'province', msg: 'Província / País é obrigatório.' },
  ],
  3: [
    { id: 'participation_mode', msg: 'Seleccione o modo de participação.', radio: true },
    { id: 'curso_id',           msg: 'Seleccione um curso.', radio: true },
  ],
  4: [
    { id: 'comprovativo', msg: 'Seleccione o comprovativo de pagamento.', file: true },
  ],
};

// ── Validação de um passo ───────────────────────────────────────
function validateStep(step) {
  const rules = stepRules[step] || [];
  let ok = true;

  rules.forEach(rule => {
    let val = '';
    if (rule.radio) {
      const checked = document.querySelector(`input[name="${rule.id}"]:checked`);
      val = checked ? checked.value : '';
    } else if (rule.file) {
      const inp = document.getElementById('comprovativo-input');
      val = inp && inp.files.length ? inp.files[0].name : '';
    } else {
      const el = document.getElementById(rule.id);
      val = el ? el.value.trim() : '';
    }

    const errEl  = document.getElementById('err-' + rule.id);
    const inpEl  = rule.radio || rule.file ? null : document.getElementById(rule.id);

    let fieldOk = val.length > 0;

    // Validação extra de email
    if (fieldOk && rule.extra === 'email') {
      fieldOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
      if (!fieldOk && errEl) errEl.textContent = 'E-mail inválido.';
    }

    if (!fieldOk) {
      if (errEl) { errEl.textContent = errEl.textContent || rule.msg; errEl.style.display = 'flex'; }
      if (inpEl) inpEl.classList.add('input-err');
      ok = false;
    } else {
      if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }
      if (inpEl) inpEl.classList.remove('input-err');
    }
  });

  return ok;
}

// ── Limpar erros de um passo ────────────────────────────────────
function clearErrors(step) {
  const rules = stepRules[step] || [];
  rules.forEach(rule => {
    const errEl = document.getElementById('err-' + rule.id);
    const inpEl = document.getElementById(rule.id);
    if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }
    if (inpEl) inpEl.classList.remove('input-err');
  });
}

// ── Actualizar stepper visual ───────────────────────────────────
function updateStepper() {
  for (let i = 0; i < totalSteps; i++) {
    const item = document.getElementById('step-item-' + i);
    item.classList.remove('active', 'completed', 'locked');
    if (i === currentStep) {
      item.classList.add('active');
    } else if (completedSteps.has(i)) {
      item.classList.add('completed');
    } else {
      item.classList.add('locked');
    }
  }
  // Progresso
  document.getElementById('progress-fill').style.width =
    ((currentStep + 1) / totalSteps * 100) + '%';
}

// ── Mostrar passo ───────────────────────────────────────────────
function showStep(step) {
  for (let i = 0; i < totalSteps; i++) {
    document.getElementById('panel-' + i).classList.toggle('active', i === step);
    const h = document.getElementById('header-' + i);
    if (h) h.style.display = i === step ? '' : 'none';
  }

  document.getElementById('btn-back').style.visibility = step > 0 ? 'visible' : 'hidden';
  document.getElementById('btn-next').style.display    = step < totalSteps - 1 ? '' : 'none';
  document.getElementById('btn-submit').style.display  = step === totalSteps - 1 ? '' : 'none';

  if (step === totalSteps - 1) buildSummary();
  updateStepper();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Avançar ─────────────────────────────────────────────────────
function goNext() {
  if (!validateStep(currentStep)) return;
  completedSteps.add(currentStep);
  currentStep++;
  clearErrors(currentStep);
  showStep(currentStep);
}

// ── Recuar ──────────────────────────────────────────────────────
function goBack() {
  if (currentStep > 0) {
    currentStep--;
    showStep(currentStep);
  }
}

// ── Clicar no stepper (só passos já completos) ──────────────────
document.querySelectorAll('.step-item').forEach(item => {
  item.addEventListener('click', function() {
    const target = parseInt(this.dataset.step);
    if (target === currentStep) return;
    if (completedSteps.has(target) || target < currentStep) {
      // Validar passo actual antes de sair
      if (target > currentStep && !validateStep(currentStep)) return;
      if (target > currentStep) completedSteps.add(currentStep);
      currentStep = target;
      showStep(currentStep);
    }
  });
});

// ── Resumo ──────────────────────────────────────────────────────
function buildSummary() {
  const grid = document.getElementById('summary-grid');
  grid.innerHTML = '';

  // Grupos de campos por secção
  const sections = [
    { title: 'Dados Pessoais', fields: ['full_name','gender','date_of_birth','nationality','document_number'] },
    { title: 'Dados Profissionais', fields: ['profession','institution','category'] },
    { title: 'Contacto & Localização', fields: ['phone','email','province'] },
    { title: 'Participação', fields: ['participation_mode','curso_id'] },
  ];

  sections.forEach((sec, si) => {
    // Título da secção
    const title = document.createElement('div');
    title.style.cssText = 'grid-column:1/-1;font-size:.65rem;font-weight:800;letter-spacing:.1em;' +
      'text-transform:uppercase;color:var(--blue-vivid);margin-top:' + (si>0?'1rem':'0');
    title.textContent = sec.title;
    grid.appendChild(title);

    sec.fields.forEach(field => {
      let val = '';
      const el = document.getElementById(field);
      if (el) {
        val = el.tagName === 'SELECT'
          ? (el.options[el.selectedIndex]?.text || '')
          : el.value;
      } else {
        // Radio
        const checked = document.querySelector(`input[name="${field}"]:checked`);
        if (checked) {
          if (field === 'curso_id') {
            // Pegar nome do curso
            const label = checked.closest('label');
            val = label?.querySelector('p')?.textContent?.trim() || checked.value;
          } else {
            val = checked.closest('label')?.querySelector('span')?.textContent?.trim() || checked.value;
          }
        }
      }
      if (!val) return;

      const lbl = document.createElement('div');
      lbl.className = 'summary-label';
      lbl.textContent = fieldLabels[field] || field;

      const valEl = document.createElement('div');
      valEl.className = 'summary-value';
      valEl.textContent = val;

      grid.appendChild(lbl);
      grid.appendChild(valEl);
    });
  });

  // Comprovativo
  const inp = document.getElementById('comprovativo-input');
  if (inp && inp.files.length) {
    const div = document.createElement('div');
    div.style.cssText = 'grid-column:1/-1;font-size:.65rem;font-weight:800;letter-spacing:.1em;' +
      'text-transform:uppercase;color:var(--blue-vivid);margin-top:1rem;';
    div.textContent = 'Comprovativo';
    grid.appendChild(div);

    const lbl = document.createElement('div');
    lbl.className = 'summary-label';
    lbl.textContent = 'Ficheiro';
    const valEl = document.createElement('div');
    valEl.className = 'summary-value';
    valEl.textContent = inp.files[0].name + ' (' + (inp.files[0].size/1048576).toFixed(2) + ' MB)';
    grid.appendChild(lbl);
    grid.appendChild(valEl);
  }
}

// ── Submit ──────────────────────────────────────────────────────
const inscricaoForm = document.getElementById('form-inscricao');

function lockSubmitButton() {
  const btn = document.getElementById('btn-submit');
  btn.disabled = true;
  btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="animation:spin .8s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> A submeter...';
}

inscricaoForm.addEventListener('submit', function (e) {
  if (!validateStep(4)) {
    e.preventDefault();
    return;
  }

  lockSubmitButton();
});

// ── Upload ──────────────────────────────────────────────────────
function handleFile(input) {
  if (!input.files.length) return;
  const f = input.files[0];
  document.getElementById('upload-idle').style.display = 'none';
  document.getElementById('upload-selected').style.display = 'block';
  document.getElementById('upload-name').textContent = f.name;
  document.getElementById('upload-size').textContent = (f.size/1048576).toFixed(2) + ' MB';
  document.getElementById('drop-zone').classList.add('has-file');
  // Limpar erro de ficheiro
  const err = document.getElementById('err-comprovativo');
  if (err) err.style.display = 'none';
}
const zone = document.getElementById('drop-zone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
  e.preventDefault();
  zone.classList.remove('dragover');
  const inp = document.getElementById('comprovativo-input');
  inp.files = e.dataTransfer.files;
  handleFile(inp);
});

// ── Spin keyframe ────────────────────────────────────────────────
const style = document.createElement('style');
style.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
document.head.appendChild(style);

// Init
showStep(0);
</script>
@endsection
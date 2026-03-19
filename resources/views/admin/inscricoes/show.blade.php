@extends('layouts.admin')
@section('title',$inscricao->numero)
@section('page-title','Detalhe da Inscrição')
@section('content')
<style>
  .detail-label{font-size:.68rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--text-3);margin-bottom:.25rem;}
  .detail-val{font-size:.83rem;font-weight:500;color:var(--text-1);}
  .panel-card{background:var(--card);border:1px solid var(--card-border);border-radius:var(--r-lg);box-shadow:var(--shadow-sm);}
  .action-section{border-radius:var(--r-md);padding:1.25rem;border:1px solid;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}
  .a4{opacity:0;animation:fadeUp .4s ease .22s forwards;}
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;max-width:1000px;">

  {{-- Breadcrumb + title --}}
  <div class="a1 action-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div style="display:flex;align-items:center;gap:.75rem;">
      <a href="{{ route('admin.inscricoes.index') }}"
         style="display:inline-flex;align-items:center;gap:.375rem;font-size:.75rem;font-weight:600;
                color:var(--text-3);text-decoration:none;transition:color .15s;"
         class="hover:text-blue">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
        </svg>
        Inscrições
      </a>
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--text-4)" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
      </svg>
      <span style="font-family:var(--font-mono);font-size:.75rem;font-weight:600;color:var(--blue-vivid);">{{ $inscricao->numero }}</span>
    </div>
    @php
      $sm=['pendente'=>['Pendente','#b45309','#fffbeb','#fde68a'],
           'em_analise'=>['Em Análise','#6d28d9','#f5f3ff','#ddd6fe'],
           'aprovada'=>['Aprovada','#059669','#ecfdf5','#a7f3d0'],
           'rejeitada'=>['Rejeitada','#be123c','#fff1f2','#fecdd3']];
      [$sl,$sc,$sb,$sbd]=$sm[$inscricao->status]??['—','#64748b','#f8faff','#e2e8f0'];
    @endphp
    <span class="status-badge" style="color:{{ $sc }};background:{{ $sb }};border-color:{{ $sbd }};font-size:.78rem;padding:5px 14px;">
      <span class="status-dot" style="background:{{ $sc }};"></span>
      {{ $sl }}
    </span>
  </div>

  {{-- Main grid --}}
  <div style="display:grid;grid-template-columns:1fr 280px;gap:1.25rem;" class="responsive-grid">

    {{-- Left column --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

      {{-- Participant data / Edit form --}}
      <div class="panel-card a2">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--divider);
                    display:flex;align-items:center;justify-content:space-between;">
          <div>
            <p class="section-label" style="margin-bottom:.15rem;">Ficha do Participante</p>
            <h3 class="heading" style="font-size:.95rem;margin:0;">{{ $inscricao->full_name }}</h3>
          </div>
          <span style="font-size:.68rem;color:var(--text-4);font-weight:500;">
            Inscrito em {{ $inscricao->created_at->format('d/m/Y H:i') }}
          </span>
        </div>
        <div style="padding:1.5rem;">
          <form method="POST" action="{{ route('admin.inscricoes.atualizar-dados',$inscricao) }}">
            @csrf @method('PATCH')
            <div style="display:grid;grid-template-columns:1fr;gap:1rem;">
              <div>
                <label class="form-label">Nome completo</label>
                {{-- Coluna correcta: full_name --}}
                <input type="text" name="full_name" value="{{ old('full_name', $inscricao->full_name) }}" class="form-input" required>
              </div>
              <div class="field-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
                <div>
                  <label class="form-label">Email</label>
                  <input type="email" name="email" value="{{ old('email', $inscricao->email) }}" class="form-input" required>
                </div>
                <div>
                  <label class="form-label">Telefone</label>
                  {{-- Coluna correcta: phone --}}
                  <input type="text" name="phone" value="{{ old('phone', $inscricao->phone) }}" class="form-input" required>
                </div>
              </div>
              <div class="field-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
                <div>
                  <label class="form-label">Instituição</label>
                  {{-- Coluna correcta: institution --}}
                  <input type="text" name="institution" value="{{ old('institution', $inscricao->institution) }}" class="form-input" required>
                </div>
                <div>
                  <label class="form-label">Profissão</label>
                  {{-- Coluna correcta: profession (era: cargo) --}}
                  <input type="text" name="profession" value="{{ old('profession', $inscricao->profession) }}" class="form-input" required>
                </div>
              </div>
              <div class="field-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
                <div>
                  <label class="form-label">Categoria</label>
                  {{-- Coluna correcta: category — valores alinhados com enum da BD --}}
                  <select name="category" class="form-input" required>
                    @foreach([
                      'profissional' => 'Profissional',
                      'estudante'    => 'Estudante',
                      'orador'       => 'Orador',
                      'convidado'    => 'Convidado',
                      'imprensa'     => 'Imprensa',
                    ] as $v => $l)
                      <option value="{{ $v }}" @selected(old('category', $inscricao->category) === $v)>{{ $l }}</option>
                    @endforeach
                  </select>
                </div>
                <div>
                  <label class="form-label">Modalidade</label>
                  {{-- Coluna correcta: participation_mode --}}
                  <select name="participation_mode" class="form-input" required>
                    @foreach(['presencial'=>'Presencial','online'=>'Online'] as $v=>$l)
                      <option value="{{ $v }}" @selected(old('participation_mode', $inscricao->participation_mode) === $v)>{{ $l }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--divider);display:flex;gap:.5rem;">
              <button type="submit" class="btn-primary" style="font-size:.75rem;">Guardar alterações</button>
            </div>
          </form>
        </div>
      </div>

      {{-- Comprovativo --}}
      @if($inscricao->comprovativo)
        <div class="panel-card a3">
          <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--divider);">
            <p class="section-label" style="margin-bottom:.15rem;">Documento</p>
            <h3 class="heading" style="font-size:.95rem;margin:0;">Comprovativo de Pagamento</h3>
          </div>
          <div style="padding:1.25rem 1.5rem;">
            <div style="display:flex;align-items:center;gap:1rem;padding:1rem;
                        background:var(--surface);border-radius:var(--r-md);
                        border:1px solid var(--card-border);margin-bottom:1rem;">
              <div style="width:40px;height:40px;border-radius:var(--r-sm);
                          background:var(--info-bg);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--blue-brand)" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
                </svg>
              </div>
              <div style="flex:1;min-width:0;">
                <p style="font-size:.8rem;font-weight:600;color:var(--text-1);margin:0 0 .15rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                  {{ $inscricao->comprovativo->nome_original }}
                </p>
                <p style="font-size:.7rem;color:var(--text-3);margin:0;">
                  {{ $inscricao->comprovativo->tamanho_formatado }}
                  &nbsp;·&nbsp;
                  {{ strtoupper(pathinfo($inscricao->comprovativo->nome_original,PATHINFO_EXTENSION)) }}
                </p>
              </div>
              @if($urlComprovativo)
                <a href="{{ $urlComprovativo }}" target="_blank" class="btn-primary"
                   style="font-size:.72rem;padding:.4rem .75rem;flex-shrink:0;">Ver ficheiro</a>
              @endif
            </div>
            @if($urlComprovativo && str_contains($inscricao->comprovativo->mime_type,'image'))
              <img src="{{ $urlComprovativo }}" alt="Comprovativo"
                   style="width:100%;max-height:280px;object-fit:contain;border-radius:var(--r-sm);
                          border:1px solid var(--card-border);">
            @endif
          </div>
        </div>
      @endif

      {{-- Evaluation history --}}
      @if($inscricao->avaliado_em)
        <div class="panel-card a3" style="padding:1.25rem 1.5rem;">
          <p class="section-label" style="margin-bottom:.5rem;">Avaliação</p>
          <div class="field-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;margin-bottom:.875rem;">
            <div>
              <p class="detail-label">Avaliado por</p>
              <p class="detail-val">{{ $inscricao->avaliador?->name ?? '—' }}</p>
            </div>
            <div>
              <p class="detail-label">Em</p>
              <p class="detail-val">{{ $inscricao->avaliado_em->format('d/m/Y H:i') }}</p>
            </div>
          </div>
          @if($inscricao->motivo_rejeicao)
            <div style="padding:.875rem 1rem;background:var(--danger-bg);border-radius:var(--r-sm);
                        border:1px solid #fecdd3;">
              <p style="font-size:.68rem;font-weight:700;color:var(--danger);text-transform:uppercase;
                        letter-spacing:.08em;margin:0 0 .375rem;">Motivo da rejeição</p>
              <p style="font-size:.8rem;color:#9f1239;margin:0;line-height:1.5;">{{ $inscricao->motivo_rejeicao }}</p>
            </div>
          @endif
        </div>
      @endif

      {{-- Change logs --}}
      <div class="panel-card a4">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--divider);">
          <p class="section-label" style="margin-bottom:.15rem;">Auditoria</p>
          <h3 class="heading" style="font-size:.95rem;margin:0;">Log de Alterações</h3>
        </div>
        <div style="padding:1.25rem 1.5rem;">
          @if($inscricao->alteracoes->isEmpty())
            <p style="font-size:.78rem;color:var(--text-3);margin:0;">Sem alterações registadas.</p>
          @else
            <div style="display:flex;flex-direction:column;gap:.625rem;">
              @foreach($inscricao->alteracoes as $log)
                <div style="padding:.75rem 1rem;background:var(--surface);border-radius:var(--r-sm);
                            border:1px solid var(--card-border);">
                  <div style="display:flex;justify-content:space-between;margin-bottom:.375rem;">
                    <span style="font-size:.73rem;font-weight:600;color:var(--text-2);">
                      {{ $log->editor?->name ?? 'Sistema' }}
                    </span>
                    <span style="font-size:.68rem;color:var(--text-3);">{{ $log->editado_em?->format('d/m/Y H:i') }}</span>
                  </div>
                  <p style="font-size:.73rem;color:var(--text-2);margin:0 0 .25rem;">
                    Campo: <strong>{{ str_replace('_',' ',ucfirst($log->campo)) }}</strong>
                  </p>
                  <div style="font-size:.7rem;color:var(--text-3);line-height:1.5;">
                    <span style="text-decoration:line-through;">{{ $log->valor_anterior ?: '—' }}</span>
                    &nbsp;
                    <svg style="display:inline;vertical-align:middle;" width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                    &nbsp;
                    <span style="font-weight:600;color:var(--text-1);">{{ $log->valor_novo ?: '—' }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Right column — actions --}}
    <div style="display:flex;flex-direction:column;gap:.875rem;">

      {{-- Transition to em_analise --}}
      @if($inscricao->status==='pendente')
        <div class="a2 action-section" style="background:#f5f3ff;border-color:#ddd6fe;">
          <p style="font-size:.73rem;font-weight:700;color:var(--purple);margin:0 0 .375rem;">Iniciar Análise</p>
          <p style="font-size:.72rem;color:#7c3aed;margin:0 0 .875rem;line-height:1.5;">
            Sinaliza que a comissão está a analisar o comprovativo.
          </p>
          <form method="POST" action="{{ route('admin.inscricoes.em-analise',$inscricao) }}">
            @csrf @method('PATCH')
            <button type="submit" style="width:100%;padding:.5rem;border-radius:var(--r-sm);
                    background:var(--purple);color:white;font-size:.75rem;font-weight:600;
                    border:none;cursor:pointer;transition:background .18s;"
                    onmouseover="this.style.background='#5b21b6'"
                    onmouseout="this.style.background='var(--purple)'">
              Marcar em Análise
            </button>
          </form>
        </div>
      @endif

      {{-- Approve --}}
      @if(in_array($inscricao->status,['pendente','em_analise']))
        <div class="a2 action-section" style="background:var(--success-bg);border-color:#a7f3d0;">
          <p style="font-size:.73rem;font-weight:700;color:var(--success);margin:0 0 .375rem;">Aprovar Inscrição</p>
          <p style="font-size:.72rem;color:#047857;margin:0 0 .875rem;line-height:1.5;">
            O participante será notificado por email imediatamente.
          </p>
          <form method="POST" action="{{ route('admin.inscricoes.aprovar',$inscricao) }}"
                onsubmit="return confirm('Confirmar aprovação de {{ $inscricao->numero }}?')">
            @csrf @method('PATCH')
            <button type="submit" style="width:100%;padding:.5rem;border-radius:var(--r-sm);
                    background:var(--success);color:white;font-size:.75rem;font-weight:600;
                    border:none;cursor:pointer;transition:background .18s;"
                    onmouseover="this.style.background='#047857'"
                    onmouseout="this.style.background='var(--success)'">
              Aprovar
            </button>
          </form>
        </div>

        {{-- Reject --}}
        <div class="a2 action-section" style="background:var(--danger-bg);border-color:#fecdd3;">
          <p style="font-size:.73rem;font-weight:700;color:var(--danger);margin:0 0 .375rem;">Rejeitar Inscrição</p>
          <form method="POST" action="{{ route('admin.inscricoes.rejeitar',$inscricao) }}">
            @csrf @method('PATCH')
            <textarea name="motivo_rejeicao" rows="3" required
                      placeholder="Motivo obrigatório..."
                      class="form-input" style="resize:none;margin-bottom:.625rem;
                      border-color:#fecdd3;font-size:.75rem;"></textarea>
            <button type="submit" onclick="return confirm('Confirmar rejeição?')"
                    style="width:100%;padding:.5rem;border-radius:var(--r-sm);
                    background:var(--danger);color:white;font-size:.75rem;font-weight:600;
                    border:none;cursor:pointer;transition:background .18s;"
                    onmouseover="this.style.background='#9f1239'"
                    onmouseout="this.style.background='var(--danger)'">
              Rejeitar
            </button>
          </form>
        </div>
      @endif

      {{-- Generate certificate --}}
      @if($inscricao->status==='aprovada' && !$inscricao->certificado)
        <div class="a3 action-section" style="background:#eff6ff;border-color:#bfdbfe;">
          <p style="font-size:.73rem;font-weight:700;color:var(--blue-brand);margin:0 0 .375rem;">Certificado</p>
          <p style="font-size:.72rem;color:#1d4ed8;margin:0 0 .875rem;line-height:1.5;">
            Gerar e enviar PDF por email ao participante.
          </p>
          <form method="POST" action="{{ route('admin.certificados.gerar',$inscricao) }}">
            @csrf
            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;font-size:.75rem;">
              Gerar Certificado
            </button>
          </form>
        </div>
      @endif

      @if($inscricao->certificado)
        <div class="a3 action-section" style="background:var(--surface);border-color:var(--card-border);">
          <p style="font-size:.73rem;font-weight:700;color:var(--text-2);margin:0 0 .2rem;">Certificado Gerado</p>
          <p style="font-size:.7rem;color:var(--text-3);margin:0 0 .875rem;">
            {{ $inscricao->certificado->gerado_em?->format('d/m/Y H:i') }}
          </p>
          <a href="{{ route('admin.certificados.download',$inscricao->certificado) }}"
             class="btn-secondary" style="width:100%;justify-content:center;font-size:.75rem;">
            Descarregar PDF
          </a>
        </div>
      @endif

      {{-- Check-in --}}
      @if($inscricao->status==='aprovada')
        <div class="a3 action-section" style="background:var(--surface);border-color:var(--card-border);">
          <p style="font-size:.73rem;font-weight:700;color:var(--text-2);margin:0 0 .5rem;">Presença no Evento</p>
          @if($inscricao->presente)
            <div style="display:flex;align-items:center;gap:.5rem;">
              <span style="width:8px;height:8px;border-radius:50%;background:var(--success);"></span>
              <span style="font-size:.75rem;font-weight:600;color:var(--success);">Presente</span>
              <span style="font-size:.7rem;color:var(--text-3);">{{ $inscricao->checkin_em?->format('d/m H:i') }}</span>
            </div>
          @else
            <form method="POST" action="{{ route('admin.inscricoes.checkin',$inscricao) }}"
                  onsubmit="return confirm('Registar presença?')">
              @csrf @method('PATCH')
              <button type="submit" class="btn-secondary" style="width:100%;justify-content:center;font-size:.75rem;">
                Registar Presença
              </button>
            </form>
          @endif
        </div>
      @endif

    </div>
  </div>
</div>

<style>
  @media(max-width:900px){
    .responsive-grid{grid-template-columns:1fr !important;}
  }
  @media(max-width:640px){
    .responsive-grid{grid-template-columns:1fr !important;}
    .field-grid-2{grid-template-columns:1fr !important;}
    .action-header{flex-direction:column !important;align-items:flex-start !important;}
    .action-header-btns{flex-wrap:wrap;width:100%;}
    .action-header-btns a,.action-header-btns button{flex:1;justify-content:center;}
    .comprovativo-preview{flex-direction:column !important;}
  }
  .hover\:text-blue:hover{color:var(--blue-vivid)!important;}
</style>
@endsection
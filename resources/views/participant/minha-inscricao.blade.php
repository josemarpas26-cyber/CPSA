@extends('layouts.app')
@section('title','Minha Inscrição')
@section('content')
<style>
  .participant-wrap{max-width:680px;margin:0 auto;padding:2.5rem 1.5rem;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(12px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}
  .a4{opacity:0;animation:fadeUp .4s ease .22s forwards;}
  .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;}
  .info-item{padding:.625rem .75rem;background:var(--surface);border-radius:var(--r-sm);
             border:1px solid var(--card-border);}
  .info-item-label{font-size:.63rem;font-weight:700;text-transform:uppercase;
                   letter-spacing:.08em;color:var(--text-3);margin:0 0 .2rem;}
  .info-item-val{font-size:.8rem;font-weight:500;color:var(--text-1);margin:0;
                 overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
</style>

<div class="participant-wrap">
  <div class="a1" style="margin-bottom:1.75rem;">
    <p class="section-label" style="margin-bottom:.25rem;">Área pessoal</p>
    <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.6rem;
               color:var(--text-1);margin:0 0 .25rem;">Minha Inscrição</h1>
    <p style="font-size:.8rem;color:var(--text-3);margin:0;">
      Acompanhe o estado da sua participação no CPSM 2026
    </p>
  </div>

  @if(!$inscricao)
    <div class="a1" style="background:var(--card);border:1px solid var(--card-border);
                            border-radius:var(--r-xl);box-shadow:var(--shadow-sm);
                            padding:3rem;text-align:center;">
      <p style="font-size:.8rem;color:var(--text-3);margin:0 0 1.5rem;">
        Não existe nenhuma inscrição associada à sua conta.
      </p>
      <a href="{{ route('inscricao.create') }}" class="btn-primary">Fazer inscrição</a>
    </div>

  @else

    {{-- Número + Status --}}
    <div class="a1" style="background:var(--card);border:1px solid var(--card-border);
                            border-radius:var(--r-lg);box-shadow:var(--shadow-sm);
                            padding:1.5rem;margin-bottom:1rem;
                            display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
      <div>
        <p style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                  color:var(--text-3);margin:0 0 .3rem;">Número de inscrição</p>
        <p style="font-family:var(--font-mono);font-size:1.3rem;font-weight:600;
                  color:var(--blue-vivid);margin:0;">
          {{ $inscricao->numero }}
        </p>
        <p style="font-size:.7rem;color:var(--text-4);margin:.25rem 0 0;">
          Submetida em {{ $inscricao->created_at->format('d/m/Y H:i') }}
        </p>
      </div>
      @php
        $sm=[
          'pendente'   =>['Pendente',  '#b45309','#fffbeb','#fde68a'],
          'em_analise' =>['Em Análise','#6d28d9','#f5f3ff','#ddd6fe'],
          'aprovada'   =>['Aprovada',  '#059669','#ecfdf5','#a7f3d0'],
          'rejeitada'  =>['Rejeitada', '#be123c','#fff1f2','#fecdd3'],
        ];
        [$sl,$sc,$sb,$sbd]=$sm[$inscricao->status]??['—','#64748b','#f8faff','#e2e8f0'];
      @endphp
      <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;
                   border-radius:99px;font-size:.78rem;font-weight:700;
                   color:{{ $sc }};background:{{ $sb }};border:1px solid {{ $sbd }};">
        <span style="width:6px;height:6px;border-radius:50%;background:{{ $sc }};"></span>
        {{ $sl }}
      </span>
    </div>

    {{-- Timeline --}}
    <div class="a2" style="background:var(--card);border:1px solid var(--card-border);
                            border-radius:var(--r-lg);box-shadow:var(--shadow-sm);
                            padding:1.5rem;margin-bottom:1rem;">
      <p class="section-label" style="margin-bottom:1rem;">Progresso</p>
      @php
        $steps = ['pendente','em_analise','aprovada'];
        if($inscricao->status === 'rejeitada') $steps = ['pendente','em_analise','rejeitada'];
        $current = array_search($inscricao->status, $steps);
        $stepLabels = [
          'pendente'   => ['Recebida',    'A inscrição foi submetida e aguarda análise.'],
          'em_analise' => ['Em Análise',  'A comissão está a analisar o comprovativo.'],
          'aprovada'   => ['Aprovada',    'Bem-vindo(a) ao CPSM 2026!'],
          'rejeitada'  => ['Não Aprovada','A inscrição não foi aprovada.'],
        ];
      @endphp
      <div style="display:flex;flex-direction:column;gap:1.25rem;">
        @foreach($steps as $idx => $step)
          @php
            $done  = $idx <= $current;
            $isNow = $idx === $current;
            [$sl2,$desc] = $stepLabels[$step];
            $nodeCol = $isNow && $step==='aprovada'  ? 'var(--success)'
                     : ($isNow && $step==='rejeitada' ? 'var(--danger)'
                     : ($isNow                        ? 'var(--blue-vivid)'
                     : ($done                         ? 'var(--success)' : 'var(--text-4)')));
          @endphp
          <div style="display:flex;gap:.875rem;align-items:flex-start;">
            <div style="width:28px;height:28px;border-radius:50%;flex-shrink:0;
                        background:{{ $done&&!$isNow?'var(--success-bg)':($isNow?$nodeCol:'var(--surface)') }};
                        border:2px solid {{ $done?$nodeCol:'var(--divider)' }};
                        display:flex;align-items:center;justify-content:center;">
              @if($done && !$isNow)
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                     stroke="var(--success)" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
              @elseif($isNow)
                <span style="width:8px;height:8px;border-radius:50%;background:white;"></span>
              @else
                <span style="font-size:.6rem;font-weight:700;color:var(--text-4);">{{ $idx+1 }}</span>
              @endif
            </div>
            <div style="flex:1;padding-top:3px;">
              <p style="font-size:.82rem;font-weight:{{ $isNow?'700':'600' }};
                        color:{{ $isNow?'var(--text-1)':($done?'var(--text-2)':'var(--text-3)') }};
                        margin:0 0 .1rem;">{{ $sl2 }}</p>
              @if($isNow)
                <p style="font-size:.75rem;color:var(--text-3);margin:0;">{{ $desc }}</p>
                @if($step==='rejeitada' && $inscricao->motivo_rejeicao)
                  <div style="margin-top:.625rem;padding:.75rem 1rem;background:var(--danger-bg);
                               border-radius:var(--r-sm);border:1px solid #fecdd3;">
                    <p style="font-size:.7rem;font-weight:700;color:var(--danger);margin:0 0 .25rem;
                               text-transform:uppercase;letter-spacing:.06em;">Motivo</p>
                    <p style="font-size:.78rem;color:#9f1239;margin:0;line-height:1.5;">
                      {{ $inscricao->motivo_rejeicao }}
                    </p>
                  </div>
                @endif
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Curso inscrito --}}
    @if($inscricao->inscricaoCurso?->curso)
      @php $curso = $inscricao->inscricaoCurso->curso; @endphp
      <div class="a3" style="background:var(--card);border:1px solid var(--card-border);
                              border-radius:var(--r-lg);box-shadow:var(--shadow-sm);
                              padding:1.5rem;margin-bottom:1rem;">
        <p class="section-label" style="margin-bottom:.75rem;">Curso Inscrito</p>
        <div style="padding:1rem;background:rgba(37,99,235,.04);border:1px solid rgba(37,99,235,.12);
                    border-radius:var(--r-md);">
          <p style="font-size:.88rem;font-weight:700;color:var(--text-1);margin:0 0 .5rem;">
            {{ $curso->nome }}
          </p>
          <div style="display:flex;flex-wrap:wrap;gap:.625rem;">
            <span style="display:inline-flex;align-items:center;gap:4px;
                         font-size:.72rem;color:var(--text-2);">
              <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              </svg>
              {{ $curso->sala }}
            </span>
            <span style="display:inline-flex;align-items:center;gap:4px;
                         font-size:.72rem;color:var(--text-2);">
              <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              {{ $curso->dia->format('d/m/Y') }}
            </span>
            <span style="display:inline-flex;align-items:center;gap:4px;
                         font-size:.72rem;color:var(--text-2);">
              <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" d="M12 6v6l4 2"/>
              </svg>
              {{ substr($curso->hora_inicio,0,5) }} – {{ substr($curso->hora_fim,0,5) }}
            </span>
          </div>
          @if($curso->speakers->isNotEmpty())
            <p style="font-size:.72rem;color:var(--text-3);margin:.5rem 0 0;">
              <strong>Palestrante(s):</strong>
              {{ $curso->speakers->pluck('nome')->join(' · ') }}
            </p>
          @endif
        </div>
      </div>
    @endif

    {{-- Dados submetidos --}}
    <div class="a3" style="background:var(--card);border:1px solid var(--card-border);
                            border-radius:var(--r-lg);box-shadow:var(--shadow-sm);
                            padding:1.5rem;margin-bottom:1rem;">
      <p class="section-label" style="margin-bottom:.875rem;">Dados Submetidos</p>
      <div class="info-grid">
        @foreach([
          'Profissão'    => $inscricao->profession,
          'Instituição'  => $inscricao->institution,
          'Categoria'    => $inscricao->category_label,
          'Modalidade'   => $inscricao->participation_mode_label,
          'Província'    => $inscricao->province,
          'Contacto'     => $inscricao->phone,
          'E-mail'       => $inscricao->email,
          'Nº Documento' => $inscricao->document_number,
        ] as $lbl => $val)
          <div class="info-item">
            <p class="info-item-label">{{ $lbl }}</p>
            <p class="info-item-val">{{ $val }}</p>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Certificado --}}
    @if($inscricao->status === 'aprovada')
      <div class="a4" style="margin-bottom:1rem;">
        @if($inscricaoComCertificado)
          <div style="background:linear-gradient(135deg,var(--navy),var(--blue));
                      border-radius:var(--r-lg);padding:1.5rem;
                      display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div>
              <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                        color:rgba(255,255,255,.45);margin:0 0 .375rem;">Certificado disponível</p>
              <p style="font-family:var(--font-display);font-style:italic;font-size:1.1rem;
                        color:white;margin:0 0 .2rem;">Certificado de Participação</p>
              <p style="font-size:.72rem;color:rgba(255,255,255,.45);margin:0;">
                Gerado em {{ $inscricaoComCertificado->certificado->gerado_em?->format('d/m/Y') }}
              </p>
            </div>
            <a href="{{ route('participant.certificado.download') }}"
               style="display:inline-flex;align-items:center;gap:.5rem;
                      background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                      color:white;font-size:.78rem;font-weight:600;
                      padding:.55rem 1.1rem;border-radius:var(--r-sm);
                      text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='rgba(255,255,255,.2)'"
               onmouseout="this.style.background='rgba(255,255,255,.12)'">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
              </svg>
              Descarregar PDF
            </a>
          </div>
        @else
          <div style="background:var(--surface);border:1px solid var(--card-border);
                      border-radius:var(--r-lg);padding:1.25rem;
                      display:flex;align-items:center;gap:.875rem;">
            <div style="width:38px;height:38px;border-radius:var(--r-sm);
                        background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                   stroke="var(--blue-brand)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div>
              <p style="font-size:.8rem;font-weight:600;color:var(--text-1);margin:0 0 .15rem;">
                Certificado em preparação
              </p>
              <p style="font-size:.73rem;color:var(--text-3);margin:0;">
                Será enviado por email assim que estiver disponível.
              </p>
            </div>
          </div>
        @endif
      </div>
    @endif

    {{-- Inscrição rejeitada --}}
    @if($inscricao->status === 'rejeitada')
      <div class="a4" style="background:var(--danger-bg);border:1px solid #fecdd3;
                              border-radius:var(--r-lg);padding:1.25rem;text-align:center;">
        <p style="font-size:.82rem;color:#9f1239;margin:0 0 1rem;line-height:1.5;">
          Pode submeter uma nova inscrição com o comprovativo correcto.
        </p>
        <a href="{{ route('inscricao.create') }}"
           style="display:inline-flex;align-items:center;gap:.5rem;
                  background:var(--danger);color:white;font-size:.78rem;font-weight:600;
                  padding:.55rem 1.25rem;border-radius:var(--r-sm);text-decoration:none;">
          Nova Inscrição
        </a>
      </div>
    @endif

  @endif
</div>
@endsection
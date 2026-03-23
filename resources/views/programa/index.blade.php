@extends('layouts.app')
@section('title','Programa — CPSM 2026')
@section('meta-description','Programa científico do I Congresso de Psiquiatria e Saúde Mental de Angola — 13 a 15 de Agosto de 2026.')

@section('content')
<style>
  /* ── Programa público ────────────────────── */
  .prog-hero{
    background:linear-gradient(135deg, var(--navy) 0%, #1a3570 55%, #0c2255 100%);
    padding:5rem 0 0;position:relative;overflow:hidden;
  }
  .prog-hero::after{
    content:'';position:absolute;bottom:0;left:0;right:0;height:60px;
    background:var(--surface);clip-path:ellipse(55% 100% at 50% 100%);
  }
  .prog-hero .container{position:relative;z-index:1;text-align:center;padding-bottom:4rem;padding-left:1rem;padding-right:1rem;}
  .prog-hero-label{
    display:inline-block;font-size:.65rem;font-weight:700;letter-spacing:.16em;
    text-transform:uppercase;color:rgba(180,210,255,.7);margin-bottom:1rem;
  }
  .prog-hero h1{
    font-family:var(--font-heading,var(--font-display));font-size:clamp(2rem,5vw,3.25rem);
    color:#fff;margin:0 0 1.25rem;line-height:1.1;
  }
  .prog-hero p{
    font-size:1rem;color:rgba(210,225,255,.7);max-width:520px;margin:0 auto 2.5rem;
  }

  /* Chips de data no hero */
  .prog-date-chips{
    display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;
  }
  .prog-date-chip{
    display:flex;align-items:center;gap:.5rem;
    padding:.5rem 1.25rem;border-radius:99px;
    background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.15);
    backdrop-filter:blur(8px);
    font-size:.78rem;font-weight:600;color:rgba(220,232,255,.9);
    transition:all .18s;cursor:pointer;
  }
  .prog-date-chip:hover,
  .prog-date-chip.active{
    background:rgba(255,255,255,.18);border-color:rgba(255,255,255,.35);
    color:white;
  }
  .prog-date-chip .chip-dot{
    width:7px;height:7px;border-radius:50%;flex-shrink:0;
  }

  /* ── Tabs de dias ────────────────────────── */
  .prog-tabs{
    display:flex;border-bottom:2px solid var(--divider);
    margin:3rem 0 0;gap:.125rem;overflow-x:auto;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:none;
  }
  .prog-tabs::-webkit-scrollbar{display:none;}
  .prog-tab{
    padding:.875rem 1.5rem;font-size:.82rem;font-weight:700;
    color:var(--text-3);cursor:pointer;border:none;background:none;
    border-bottom:3px solid transparent;margin-bottom:-2px;
    transition:all .18s;font-family:var(--font-body);white-space:nowrap;
    flex-shrink:0;
  }
  .prog-tab:hover{color:var(--text-1);}
  .prog-tab.active{
    color:var(--blue-vivid);
    border-bottom-color:var(--blue-vivid);
  }

  /* ── Legenda de tipos ────────────────────── */
  .prog-legend{
    display:flex;flex-wrap:wrap;gap:.5rem;
    padding:1.5rem 0 .75rem;
  }
  .prog-legend-item{
    display:flex;align-items:center;gap:.35rem;
    font-size:.68rem;font-weight:600;color:var(--text-2);
  }
  .prog-legend-dot{
    width:8px;height:8px;border-radius:50%;flex-shrink:0;
  }

  /* ── Timeline ────────────────────────────── */
  .prog-day-panel{display:none;}
  .prog-day-panel.active{display:block;}

  .prog-timeline{
    position:relative;padding-left:2.5rem;
    padding-top:1.5rem;padding-bottom:3rem;
  }
  .prog-timeline::before{
    content:'';position:absolute;left:11px;top:0;bottom:0;
    width:2px;background:linear-gradient(to bottom, var(--blue-vivid) 0%, var(--divider) 100%);
    border-radius:2px;
  }

  .prog-item{
    position:relative;margin-bottom:1.25rem;
    opacity:0;transform:translateX(-12px);
    transition:opacity .4s,transform .4s;
  }
  .prog-item.visible{opacity:1;transform:translateX(0);}

  .prog-item::before{
    content:'';position:absolute;left:-2.025rem;top:1.1rem;
    width:10px;height:10px;border-radius:50%;
    background:var(--blue-vivid);
    border:2.5px solid var(--surface);
    box-shadow:0 0 0 2px var(--blue-vivid);
    z-index:1;
  }

  .prog-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.25rem 1.5rem;
    box-shadow:var(--shadow-sm);
    transition:transform .2s,box-shadow .2s;
  }
  .prog-card:hover{
    transform:translateX(4px);
    box-shadow:var(--shadow-md);
  }
  .prog-card-header{
    display:flex;align-items:flex-start;justify-content:space-between;
    gap:1rem;margin-bottom:.75rem;flex-wrap:wrap;
  }
  .prog-horario{
    font-family:var(--font-mono);font-size:.78rem;font-weight:700;
    color:var(--blue-vivid);white-space:nowrap;
    background:rgba(37,99,235,.07);padding:.2rem .6rem;border-radius:6px;
  }
  .prog-tipo-badge{
    display:inline-flex;align-items:center;padding:.2rem .65rem;
    border-radius:99px;font-size:.62rem;font-weight:700;letter-spacing:.04em;
    white-space:nowrap;
  }
  .prog-card-nome{
    font-size:.95rem;font-weight:700;color:var(--text-1);
    margin:0 0 .375rem;line-height:1.35;
  }
  .prog-card-desc{
    font-size:.8rem;color:var(--text-3);margin:0 0 .75rem;line-height:1.55;
  }
  .prog-card-meta{
    display:flex;flex-wrap:wrap;gap:.5rem;align-items:center;
  }
  .prog-sala{
    display:flex;align-items:center;gap:.3rem;
    font-size:.72rem;color:var(--text-3);font-weight:500;
  }
  .prog-speaker-chip{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.68rem;font-weight:600;padding:.18rem .55rem;border-radius:99px;
    background:rgba(37,99,235,.06);color:var(--blue-vivid);
  }
  .prog-speaker-chip img{
    width:16px;height:16px;border-radius:50%;object-fit:cover;
  }

  /* ── Vazio ───────────────────────────────── */
  .prog-empty{
    padding:4rem;text-align:center;color:var(--text-3);
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);margin:2rem 0;
  }

  /* ══════════════════════════════════════════
     CURSOS & WORKSHOPS SECTION
  ══════════════════════════════════════════ */
  .cursos-section{
    background:white;
    border-top:2px solid var(--divider);
    padding:4rem 0;
  }
  .cursos-section .container{
    max-width:1100px;margin:0 auto;padding:0 1rem;
  }
  .cursos-header{
    display:flex;align-items:flex-end;justify-content:space-between;
    flex-wrap:wrap;gap:1rem;margin-bottom:2rem;
  }
  .cursos-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:1.25rem;
  }

  .curso-card{
    background:var(--card);
    border:1px solid var(--card-border);
    border-radius:var(--r-lg);
    overflow:hidden;
    box-shadow:var(--shadow-sm);
    transition:transform .22s,box-shadow .22s;
    display:flex;flex-direction:column;
  }
  .curso-card:hover{
    transform:translateY(-3px);
    box-shadow:var(--shadow-md);
  }

  /* Stripe de cor no topo de cada card */
  .curso-card-stripe{
    height:3px;
    background:linear-gradient(90deg, var(--blue-vivid), #6d28d9);
  }

  .curso-card-body{
    padding:1.25rem;flex:1;
    display:flex;flex-direction:column;gap:.625rem;
  }

  .curso-title{
    font-size:.92rem;font-weight:700;color:var(--text-1);
    margin:0;line-height:1.3;
  }

  .curso-meta-row{
    display:flex;flex-wrap:wrap;gap:.625rem;align-items:center;
  }
  .curso-meta-chip{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.7rem;color:var(--text-2);font-weight:500;
    background:var(--surface);padding:.25rem .6rem;
    border-radius:6px;border:1px solid var(--card-border);
    white-space:nowrap;
  }
  .curso-meta-chip svg{flex-shrink:0;color:var(--text-3);}

  .curso-desc{
    font-size:.78rem;color:var(--text-3);
    line-height:1.6;margin:0;flex:1;
  }

  .curso-speakers-row{
    display:flex;flex-wrap:wrap;gap:.375rem;
    padding-top:.5rem;
    border-top:1px solid var(--divider);
  }
  .curso-speaker-tag{
    display:inline-flex;align-items:center;gap:.35rem;
    font-size:.67rem;font-weight:600;color:var(--blue-vivid);
    background:rgba(37,99,235,.07);
    padding:.2rem .6rem;border-radius:99px;
  }
  .curso-speaker-tag::before{
    content:'';width:5px;height:5px;border-radius:50%;
    background:var(--blue-vivid);flex-shrink:0;
  }

  .curso-card-footer{
    padding:.875rem 1.25rem;
    background:var(--surface);
    border-top:1px solid var(--divider);
    display:flex;align-items:center;justify-content:space-between;
    gap:.5rem;flex-wrap:wrap;
  }

  .vagas-pill{
    display:inline-flex;align-items:center;gap:.35rem;
    font-size:.68rem;font-weight:700;
    padding:.25rem .7rem;border-radius:99px;
    border:1px solid;
  }
  .vagas-pill.ok       { color:#059669;background:#ecfdf5;border-color:#a7f3d0; }
  .vagas-pill.low      { color:#b45309;background:#fffbeb;border-color:#fde68a; }
  .vagas-pill.esgotado { color:#be123c;background:#fff1f2;border-color:#fecdd3; }
  .vagas-pill.ilimitado{ color:#1d4ed8;background:#eff6ff;border-color:#bfdbfe; }

  .vagas-pill-dot{
    width:5px;height:5px;border-radius:50%;
    background:currentColor;flex-shrink:0;
  }

  .curso-inscricao-btn{
    display:inline-flex;align-items:center;gap:.35rem;
    font-size:.75rem;font-weight:700;
    color:var(--blue-vivid);text-decoration:none;
    transition:gap .15s;
  }
  .curso-inscricao-btn:hover{ gap:.55rem; }
  .curso-inscricao-btn.disabled{
    color:var(--text-4);pointer-events:none;
  }

  /* Filtro de dia para cursos */
  .cursos-filter{
    display:flex;gap:.375rem;flex-wrap:wrap;
  }
  .curso-filter-btn{
    display:inline-flex;align-items:center;gap:.4rem;
    padding:.4rem .875rem;border-radius:99px;
    font-size:.75rem;font-weight:600;cursor:pointer;
    border:1.5px solid var(--card-border);background:var(--card);
    color:var(--text-2);transition:all .18s;
  }
  .curso-filter-btn:hover{border-color:var(--blue-vivid);color:var(--blue-vivid);}
  .curso-filter-btn.active{
    background:var(--blue-vivid);border-color:var(--blue-vivid);color:white;
  }
  .curso-filter-btn .filter-dot{
    width:6px;height:6px;border-radius:50%;background:currentColor;
  }

  /* Curso escondido por filtro */
  .curso-card[data-hidden="true"]{ display:none; }

  /* ── Vazio cursos ─────────────────────────── */
  .cursos-empty{
    grid-column:1/-1;
    padding:3.5rem;text-align:center;
    background:var(--card);border:1px dashed var(--card-border);
    border-radius:var(--r-lg);color:var(--text-3);
  }

  /* ── Aviso inscrição ─────────────────────── */
  .inscricao-banner{
    background:linear-gradient(135deg,rgba(37,99,235,.06),rgba(13,148,136,.04));
    border:1px solid rgba(37,99,235,.12);border-radius:var(--r-lg);
    padding:1.75rem;display:flex;align-items:center;gap:1.5rem;
    flex-wrap:wrap;margin:4rem 0;
  }

  /* ── Scroll reveal ───────────────────────── */
  .reveal{opacity:0;transform:translateY(20px);transition:opacity .5s,transform .5s;}
  .reveal.visible{opacity:1;transform:translateY(0);}

  @media(max-width:768px){
    .prog-timeline{padding-left:1.75rem;}
    .prog-card-header{flex-direction:column;gap:.5rem;}
    .cursos-grid{grid-template-columns:1fr;}
    .cursos-header{flex-direction:column;align-items:flex-start;}
    .prog-hero{padding:3.5rem 0 0;}
    .inscricao-banner{flex-direction:column;text-align:center;}
  }
  @media(max-width:480px){
    .prog-tab{padding:.75rem .875rem;font-size:.75rem;}
  }
</style>

{{-- Hero --}}
<section class="prog-hero">
  <div class="container">
    <span class="prog-hero-label">CPSM 2026 · Luanda, Angola</span>
    <h1>Programa Científico</h1>
    <p>Três dias de conferências, workshops, mesas redondas e muito mais sobre Psiquiatria e Saúde Mental.</p>
    <div class="prog-date-chips">
      <div class="prog-date-chip active" onclick="switchDay('2026-08-13',this)">
        <span class="chip-dot" style="background:#60a5fa;"></span>
        13 de Agosto — Dia 1
      </div>
      <div class="prog-date-chip" onclick="switchDay('2026-08-14',this)">
        <span class="chip-dot" style="background:#34d399;"></span>
        14 de Agosto — Dia 2
      </div>
      <div class="prog-date-chip" onclick="switchDay('2026-08-15',this)">
        <span class="chip-dot" style="background:#c084fc;"></span>
        15 de Agosto — Dia 3
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════
     ACTIVIDADES DO PROGRAMA (Timeline)
═══════════════════════════════════════════ --}}
<div class="container" style="max-width:1100px;margin:0 auto;padding:0 1rem;">

  {{-- Legenda de tipos --}}
  @php
    $legendaCorores = [
      'workshop'       => ['#1d4ed8','Workshop'],
      'palestra'       => ['#0f766e','Palestra'],
      'mesa-redonda'   => ['#6d28d9','Mesa Redonda'],
      'simposio'       => ['#b45309','Simpósio'],
      'exposicao'      => ['#be123c','Exposição'],
      'casos-clinicos' => ['#0369a1','Casos Clínicos'],
      'abertura'       => ['#059669','Abertura'],
      'encerramento'   => ['#475569','Encerramento'],
    ];
    $tiposUsados = collect($actividades)->flatten()->pluck('tipo')->unique()->values();
  @endphp
  @if($tiposUsados->isNotEmpty())
    <div class="prog-legend">
      @foreach($tiposUsados as $tipo)
        @if(isset($legendaCorores[$tipo]))
          <div class="prog-legend-item">
            <span class="prog-legend-dot" style="background:{{ $legendaCorores[$tipo][0] }};"></span>
            {{ $legendaCorores[$tipo][1] }}
          </div>
        @endif
      @endforeach
    </div>
  @endif

  {{-- Tabs de dias --}}
  <div class="prog-tabs">
    @foreach($dias as $d => $lbl)
      <button class="prog-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchDay('{{ $d }}',null,'tab')">
        {{ $lbl }}
      </button>
    @endforeach
  </div>

  {{-- Painéis por dia --}}
  @foreach($dias as $d => $lbl)
    <div class="prog-day-panel {{ $loop->first ? 'active' : '' }}"
         id="panel-{{ $d }}">
      @if($actividades[$d]->isEmpty())
        <div class="prog-empty">
          <p style="font-size:.9rem;font-weight:600;margin:0 0 .25rem;">Programa ainda não publicado.</p>
          <p style="font-size:.78rem;margin:0;">As actividades deste dia serão anunciadas brevemente.</p>
        </div>
      @else
        <div class="prog-timeline" id="timeline-{{ $d }}">
          @foreach($actividades[$d] as $act)
            <div class="prog-item" style="transition-delay:{{ $loop->index * 60 }}ms;">
              <div class="prog-card">
                <div class="prog-card-header">
                  <span class="prog-horario">{{ $act->horario_label }}</span>
                  <span class="prog-tipo-badge"
                        style="color:{{ $act->tipo_color }};background:{{ $act->tipo_bg }};">
                    {{ $act->tipo_label }}
                  </span>
                </div>
                <p class="prog-card-nome">{{ $act->nome }}</p>
                @if($act->descricao)
                  <p class="prog-card-desc">{{ $act->descricao }}</p>
                @endif
                <div class="prog-card-meta">
                  @if($act->sala)
                    <span class="prog-sala">
                      <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                      </svg>
                      {{ $act->sala }}
                    </span>
                  @endif
                  @foreach($act->speakers as $sp)
                    <span class="prog-speaker-chip">
                      @if($sp->foto ?? false)
                        <img src="{{ asset('storage/'.$sp->foto) }}" alt="{{ $sp->nome }}">
                      @endif
                      {{ \Str::words($sp->nome, 3, '…') }}
                    </span>
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  @endforeach

</div>{{-- /container actividades --}}


{{-- ═══════════════════════════════════════════
     CURSOS & WORKSHOPS
═══════════════════════════════════════════ --}}
<section class="cursos-section">
  <div class="container">

    <div class="cursos-header reveal">
      <div>
        <p style="font-size:.63rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
                  color:var(--text-3);margin:0 0 .3rem;">Formação Especializada</p>
        <h2 style="font-family:var(--font-display);font-style:italic;font-size:clamp(1.5rem,3vw,2rem);
                   color:var(--text-1);margin:0 0 .5rem;line-height:1.15;">
          Cursos & Workshops
        </h2>
        <p style="font-size:.83rem;color:var(--text-3);margin:0;max-width:480px;line-height:1.6;">
          Formação prática em pequenos grupos com os melhores especialistas.
          As vagas são limitadas — inscreva-se com antecedência.
        </p>
      </div>

      {{-- Filtros por dia --}}
      @php
        use App\Models\Curso;
        $cursosPublicos = Curso::ativo()
            ->with(['speakers','inscricoes'])
            ->ordenado()
            ->get();

        $diasCursos = $cursosPublicos->pluck('dia')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->unique()
            ->sort()
            ->values();

        $diasLabels = [
          '2026-08-13' => 'Dia 1 · 13 Ago',
          '2026-08-14' => 'Dia 2 · 14 Ago',
          '2026-08-15' => 'Dia 3 · 15 Ago',
        ];
        $dotCores = [
          '2026-08-13' => '#60a5fa',
          '2026-08-14' => '#34d399',
          '2026-08-15' => '#c084fc',
        ];
      @endphp

      @if($diasCursos->count() > 1)
        <div class="cursos-filter" id="cursosFilter">
          <button class="curso-filter-btn active" data-dia="all" onclick="filtrarCursos('all',this)">
            Todos
          </button>
          @foreach($diasCursos as $dc)
            <button class="curso-filter-btn" data-dia="{{ $dc }}"
                    onclick="filtrarCursos('{{ $dc }}',this)">
              <span class="filter-dot" style="background:{{ $dotCores[$dc] ?? 'var(--blue-vivid)' }};"></span>
              {{ $diasLabels[$dc] ?? $dc }}
            </button>
          @endforeach
        </div>
      @endif
    </div>

    @if($cursosPublicos->isEmpty())
      <div class="cursos-empty reveal">
        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--text-4)" stroke-width="1.2"
             style="margin:0 auto 1rem;display:block;">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489"/>
        </svg>
        <p style="font-size:.9rem;font-weight:600;margin:0 0 .25rem;color:var(--text-2);">Cursos em breve</p>
        <p style="font-size:.78rem;margin:0;">O programa de cursos será divulgado brevemente.</p>
      </div>
    @else
      <div class="cursos-grid reveal" id="cursosGrid">
        @foreach($cursosPublicos as $curso)
          @php
            $inscritos  = $curso->inscritos_count;
            $cheio      = $curso->vagas && $inscritos >= $curso->vagas;
            $vagasDisp  = $curso->vagas ? max(0, $curso->vagas - $inscritos) : null;
            $vagasLow   = $vagasDisp !== null && $vagasDisp <= 5 && !$cheio;
            $diaStr     = $curso->dia->format('Y-m-d');
          @endphp
          <div class="curso-card" data-dia="{{ $diaStr }}">
            <div class="curso-card-stripe"></div>
            <div class="curso-card-body">

              {{-- Título --}}
              <h3 class="curso-title">{{ $curso->nome }}</h3>

              {{-- Meta: dia, horário, sala --}}
              <div class="curso-meta-row">
                <span class="curso-meta-chip">
                  <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  {{ $curso->dia->isoFormat('ddd, DD MMM') }}
                </span>
                <span class="curso-meta-chip">
                  <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" d="M12 6v6l4 2"/>
                  </svg>
                  {{ substr($curso->hora_inicio,0,5) }}–{{ substr($curso->hora_fim,0,5) }}
                </span>
                <span class="curso-meta-chip">
                  <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                  </svg>
                  {{ $curso->sala }}
                </span>
              </div>

              {{-- Descrição --}}
              @if($curso->descricao)
                <p class="curso-desc">{{ Str::limit($curso->descricao, 130) }}</p>
              @endif

              {{-- Palestrantes --}}
              @if($curso->speakers->isNotEmpty())
                <div class="curso-speakers-row">
                  @foreach($curso->speakers as $sp)
                    <span class="curso-speaker-tag">{{ $sp->nome }}</span>
                  @endforeach
                </div>
              @endif

            </div>

            <div class="curso-card-footer">
              {{-- Badge de vagas --}}
              @if($cheio)
                <span class="vagas-pill esgotado">
                  <span class="vagas-pill-dot"></span>Esgotado
                </span>
              @elseif($vagasLow)
                <span class="vagas-pill low">
                  <span class="vagas-pill-dot"></span>Últimas {{ $vagasDisp }} vagas
                </span>
              @elseif($vagasDisp !== null)
                <span class="vagas-pill ok">
                  <span class="vagas-pill-dot"></span>{{ $vagasDisp }} vagas disponíveis
                </span>
              @else
                <span class="vagas-pill ilimitado">
                  <span class="vagas-pill-dot"></span>Vagas livres
                </span>
              @endif

              {{-- Botão inscrição --}}
              @if($cheio)
                <span class="curso-inscricao-btn disabled">Esgotado</span>
              @else
                <a href="{{ route('inscricao.create') }}" class="curso-inscricao-btn">
                  Inscrever-me
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                  </svg>
                </a>
              @endif
            </div>
          </div>
        @endforeach
      </div>{{-- /cursos-grid --}}
    @endif

    {{-- Banner inscrição --}}
    <div class="inscricao-banner reveal">
      <svg width="38" height="38" fill="none" viewBox="0 0 24 24"
           stroke="var(--blue-vivid)" stroke-width="1.5" style="flex-shrink:0;">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0Zm-9-3.75h.008v.008H12V8.25Z"/>
      </svg>
      <div style="flex:1;min-width:200px;">
        <p style="font-size:.88rem;font-weight:700;color:var(--text-1);margin:0 0 .25rem;">
          A participação nos cursos requer inscrição prévia
        </p>
        <p style="font-size:.78rem;color:var(--text-3);margin:0;line-height:1.5;">
          As vagas são limitadas. Ao inscrever-se, escolhe o curso da sua preferência
          e garante o seu lugar.
        </p>
      </div>
      <a href="{{ route('inscricao.create') }}" class="btn-primary" style="flex-shrink:0;">
        Fazer inscrição
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </a>
    </div>

  </div>{{-- /container cursos --}}
</section>


<script>
  /* ── Tabs de dias (actividades) ──────────── */
  let activeDia = '2026-08-13';

  function switchDay(dia, chipEl, source) {
    if (dia === activeDia) return;
    activeDia = dia;

    document.querySelectorAll('.prog-day-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + dia).classList.add('active');

    document.querySelectorAll('.prog-tab').forEach(t => t.classList.remove('active'));
    const tabs = document.querySelectorAll('.prog-tab');
    const dias = ['2026-08-13','2026-08-14','2026-08-15'];
    const idx  = dias.indexOf(dia);
    if (tabs[idx]) tabs[idx].classList.add('active');

    document.querySelectorAll('.prog-date-chip').forEach(c => c.classList.remove('active'));
    if (chipEl) chipEl.classList.add('active');
    else if (idx >= 0) {
      const chips = document.querySelectorAll('.prog-date-chip');
      if (chips[idx]) chips[idx].classList.add('active');
    }

    revealItems(dia);
  }

  function revealItems(dia) {
    const items = document.querySelectorAll('#panel-' + dia + ' .prog-item');
    items.forEach((item, i) => {
      item.classList.remove('visible');
      setTimeout(() => item.classList.add('visible'), i * 60 + 30);
    });
  }

  revealItems('2026-08-13');

  /* ── Filtro de cursos por dia ─────────────── */
  function filtrarCursos(dia, btn) {
    /* Actualizar botões */
    document.querySelectorAll('.curso-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    /* Mostrar/esconder cards */
    document.querySelectorAll('#cursosGrid .curso-card').forEach(card => {
      if (dia === 'all' || card.dataset.dia === dia) {
        card.removeAttribute('data-hidden');
        card.style.display = '';
      } else {
        card.setAttribute('data-hidden', 'true');
        card.style.display = 'none';
      }
    });
  }

  /* ── Scroll reveal ────────────────────────── */
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
    revealEls.forEach(el => obs.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('visible'));
  }
</script>
@endsection
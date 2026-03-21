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
    background:var(--bg);clip-path:ellipse(55% 100% at 50% 100%);
  }
  .prog-hero .container{position:relative;z-index:1;text-align:center;padding-bottom:4rem;}
  .prog-hero-label{
    display:inline-block;font-size:.65rem;font-weight:700;letter-spacing:.16em;
    text-transform:uppercase;color:rgba(180,210,255,.7);margin-bottom:1rem;
  }
  .prog-hero h1{
    font-family:var(--font-heading);font-size:clamp(2.2rem,5vw,3.25rem);
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
    margin:3rem 0 0;gap:.125rem;
  }
  .prog-tab{
    padding:.875rem 1.5rem;font-size:.82rem;font-weight:700;
    color:var(--text-3);cursor:pointer;border:none;background:none;
    border-bottom:3px solid transparent;margin-bottom:-2px;
    transition:all .18s;font-family:var(--font-body);white-space:nowrap;
  }
  .prog-tab:hover{color:var(--text-1);}
  .prog-tab.active{
    color:var(--blue-vivid);
    border-bottom-color:var(--blue-vivid);
  }

  /* ── Legenda de tipos ────────────────────── */
  .prog-legend{
    display:flex;flex-wrap:wrap;gap:.5rem;
    padding:1.5rem 0;
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
    border:2.5px solid var(--bg);
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

  @media(max-width:640px){
    .prog-tabs{gap:0;overflow-x:auto;}
    .prog-tab{padding:.75rem 1rem;font-size:.75rem;}
    .prog-timeline{padding-left:1.75rem;}
    .prog-card-header{flex-direction:column;gap:.5rem;}
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

<div class="container" style="padding-top:2.5rem;">

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
    // Só mostrar na legenda os tipos que realmente existem no programa
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

  {{-- Aviso inscrição --}}
  <div style="background:linear-gradient(135deg,rgba(37,99,235,.06),rgba(13,148,136,.04));
              border:1px solid rgba(37,99,235,.12);border-radius:var(--r-lg);
              padding:2rem;display:flex;align-items:center;gap:1.5rem;
              flex-wrap:wrap;margin-bottom:4rem;">
    <svg width="36" height="36" fill="none" viewBox="0 0 24 24"
         stroke="var(--blue-vivid)" stroke-width="1.5" style="flex-shrink:0;">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
    </svg>
    <div style="flex:1;min-width:220px;">
      <p style="font-size:.88rem;font-weight:700;color:var(--text-1);margin:0 0 .25rem;">
        A participação requer inscrição prévia
      </p>
      <p style="font-size:.78rem;color:var(--text-3);margin:0;">
        Algumas actividades como workshops têm vagas limitadas.
        Inscreva-se para garantir o seu lugar.
      </p>
    </div>
    <a href="{{ route('inscricao.create') }}" class="btn-primary">
      Inscrever-me agora
    </a>
  </div>
</div>

<script>
  // Estado activo: dia e botão
  let activeDia = '2026-08-13';

  function switchDay(dia, chipEl, source) {
    if (dia === activeDia) return;
    activeDia = dia;

    // Painéis
    document.querySelectorAll('.prog-day-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + dia).classList.add('active');

    // Tabs
    document.querySelectorAll('.prog-tab').forEach(t => t.classList.remove('active'));
    const tabs = document.querySelectorAll('.prog-tab');
    const dias = ['2026-08-13','2026-08-14','2026-08-15'];
    const idx  = dias.indexOf(dia);
    if (tabs[idx]) tabs[idx].classList.add('active');

    // Chips (hero)
    document.querySelectorAll('.prog-date-chip').forEach(c => c.classList.remove('active'));
    if (chipEl) chipEl.classList.add('active');
    else {
      const chips = document.querySelectorAll('.prog-date-chip');
      if (chips[idx]) chips[idx].classList.add('active');
    }

    // Animar os itens do painel activado
    revealItems(dia);
  }

  function revealItems(dia) {
    const items = document.querySelectorAll('#panel-' + dia + ' .prog-item');
    items.forEach((item, i) => {
      item.classList.remove('visible');
      setTimeout(() => item.classList.add('visible'), i * 60 + 30);
    });
  }

  // Revelar painel inicial
  revealItems('2026-08-13');
</script>
@endsection
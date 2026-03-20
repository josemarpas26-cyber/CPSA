@extends('layouts.app')
@section('title','Início')
@section('content')
<style>
  /* ══════════════════════════════════════════════════
     HERO
  ══════════════════════════════════════════════════ */
  .hero{
    background:var(--navy);
    position:relative;overflow:hidden;
    padding:6rem 2rem 5rem;
    text-align:center;
  }
  .hero::before{
    content:'';position:absolute;inset:0;
    background:
      radial-gradient(ellipse 70% 60% at 30% 50%,rgba(37,99,235,.18) 0%,transparent 60%),
      radial-gradient(ellipse 50% 40% at 80% 20%,rgba(109,40,217,.12) 0%,transparent 60%),
      radial-gradient(ellipse 60% 50% at 60% 90%,rgba(15,118,110,.08) 0%,transparent 60%);
  }
  .hero-grid{
    position:absolute;inset:0;
    background-image:
      linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
      linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:40px 40px;
  }
  .hero-content{position:relative;z-index:1;max-width:720px;margin:0 auto;}
  .hero-tag{
    display:inline-flex;align-items:center;gap:.5rem;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12);
    border-radius:99px;padding:.35rem 1rem;
    font-size:.72rem;font-weight:600;
    color:rgba(255,255,255,.7);
    letter-spacing:.06em;text-transform:uppercase;
    margin-bottom:1.75rem;
  }
  .hero-tag-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--teal-light);
    animation:pulse-dot 2s ease-in-out infinite;
  }
  @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.5);}}
  .hero-title{
    font-family:var(--font-display);font-style:italic;
    font-size:clamp(2rem,5vw,3.25rem);
    color:white;line-height:1.1;margin:0 0 1rem;
  }
  .hero-sub{font-size:.95rem;color:rgba(255,255,255,.55);line-height:1.75;margin:0 0 2rem;}
  .hero-actions{display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-bottom:3.5rem;}
  .hero-btn-main{
    display:inline-flex;align-items:center;gap:.5rem;
    background:var(--blue-vivid);color:white;
    font-size:.85rem;font-weight:600;
    padding:.75rem 1.85rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;
    box-shadow:0 2px 12px rgba(37,99,235,.45);
  }
  .hero-btn-main:hover{background:#1d4ed8;transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.5);}
  .hero-btn-sec{
    display:inline-flex;align-items:center;gap:.5rem;
    border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.75);
    font-size:.85rem;font-weight:600;
    padding:.75rem 1.5rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;
  }
  .hero-btn-sec:hover{border-color:rgba(255,255,255,.4);color:white;background:rgba(255,255,255,.06);}

  /* ══════════════════════════════════════════════════
     COUNTDOWN
  ══════════════════════════════════════════════════ */
  .countdown-title{
    font-size:.72rem;font-weight:600;letter-spacing:.08em;
    text-transform:uppercase;color:rgba(255,255,255,.35);
    margin:0 0 1rem;
  }
  .countdown-wrap{
    display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;
  }
  .countdown-box{
    background:rgba(255,255,255,.07);
    border:1px solid rgba(255,255,255,.1);
    border-radius:12px;
    padding:.875rem 1.25rem;
    min-width:76px;text-align:center;
    backdrop-filter:blur(8px);
    transition:transform .2s;
  }
  .countdown-box:hover{transform:translateY(-2px);}
  .countdown-num{
    font-family:var(--font-mono);
    font-size:2rem;font-weight:700;
    color:white;line-height:1;display:block;
  }
  .countdown-lbl{
    font-size:.63rem;font-weight:600;letter-spacing:.1em;
    text-transform:uppercase;color:rgba(255,255,255,.4);
    margin-top:.3rem;display:block;
  }
  .countdown-sep{
    color:rgba(255,255,255,.25);font-size:1.75rem;
    align-self:center;line-height:1;
  }

  /* ══════════════════════════════════════════════════
     SECTIONS BASE
  ══════════════════════════════════════════════════ */
  .section{max-width:1100px;margin:0 auto;padding:4rem 2rem;}
  .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
  .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;}

  /* ══════════════════════════════════════════════════
     METRIC CARDS
  ══════════════════════════════════════════════════ */
  .metric-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.5rem;
    text-align:center;box-shadow:var(--shadow-sm);
    transition:transform .2s,box-shadow .2s;
  }
  .metric-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);}
  .metric-num{font-family:var(--font-mono);font-size:2rem;font-weight:600;color:var(--navy);margin-bottom:.25rem;}
  .metric-label{font-size:.72rem;color:var(--text-3);font-weight:500;}

  /* ══════════════════════════════════════════════════
     INFO CARDS
  ══════════════════════════════════════════════════ */
  .info-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;box-shadow:var(--shadow-sm);
  }

  /* ══════════════════════════════════════════════════
     CATEGORIES
  ══════════════════════════════════════════════════ */
  .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:.75rem;}
  .cat-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-md);padding:1rem;
    transition:border-color .18s,box-shadow .18s,transform .18s;
    cursor:default;
  }
  .cat-card:hover{border-color:rgba(37,99,235,.25);box-shadow:var(--shadow-sm);transform:translateY(-2px);}

  /* ══════════════════════════════════════════════════
     STEPS
  ══════════════════════════════════════════════════ */
  .step-line{display:flex;flex-direction:column;gap:1.5rem;}
  .step-item{display:flex;gap:1rem;align-items:flex-start;}
  .step-num{
    width:32px;height:32px;border-radius:50%;
    background:var(--navy);color:white;
    display:flex;align-items:center;justify-content:center;
    font-size:.75rem;font-weight:700;flex-shrink:0;margin-top:2px;
  }

  /* ══════════════════════════════════════════════════
     CTA BLOCK
  ══════════════════════════════════════════════════ */
  .cta-block{
    background:var(--navy);border-radius:var(--r-2xl);
    padding:3rem;text-align:center;
    position:relative;overflow:hidden;
  }
  .cta-block::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse 60% 60% at 50% 0%,rgba(37,99,235,.2),transparent 60%);
  }

  /* ══════════════════════════════════════════════════
     SPEAKERS
  ══════════════════════════════════════════════════ */
  .speakers-section{
    background:white;
    border-top:1px solid var(--divider);
    border-bottom:1px solid var(--divider);
    padding:4rem 2rem;
  }
  .speakers-inner{max-width:1100px;margin:0 auto;}
  .speaker-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.5rem;text-align:center;
    box-shadow:var(--shadow-sm);
    transition:transform .25s cubic-bezier(.34,1.56,.64,1),box-shadow .25s;
  }
  .speaker-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);}
  .speaker-avatar{
    width:72px;height:72px;border-radius:50%;
    background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
    display:flex;align-items:center;justify-content:center;
    margin:0 auto .875rem;
    font-family:var(--font-display);font-style:italic;
    font-size:1.5rem;color:white;font-weight:700;overflow:hidden;
  }
  .speaker-avatar img{width:72px;height:72px;border-radius:50%;object-fit:cover;}
  .speaker-name{font-size:.88rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;}
  .speaker-role{font-size:.72rem;color:var(--text-3);font-weight:500;margin:0 0 .5rem;}
  .speaker-badge{
    display:inline-block;font-size:.63rem;font-weight:700;
    letter-spacing:.06em;text-transform:uppercase;
    padding:.2rem .6rem;border-radius:99px;
    background:rgba(37,99,235,.08);color:var(--blue-vivid);
  }
  .speakers-cta{text-align:center;margin-top:2rem;}
  .speakers-cta a{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.8rem;font-weight:600;
    color:var(--blue-vivid);text-decoration:none;
    transition:gap .2s;
  }
  .speakers-cta a:hover{gap:.7rem;}

  /* ══════════════════════════════════════════════════
     GALLERY / SLIDER
  ══════════════════════════════════════════════════ */
  .gallery-section{
    padding:4rem 2rem;
    background:var(--surface);
    border-bottom:1px solid var(--divider);
  }
  .gallery-inner{max-width:1100px;margin:0 auto;}
  .slider-wrap{
    position:relative;overflow:hidden;
    border-radius:var(--r-xl);
    box-shadow:var(--shadow-lg);
  }
  .slider-track{
    display:flex;
    transition:transform .5s cubic-bezier(.4,0,.2,1);
  }
  .slide{min-width:100%;height:420px;position:relative;flex-shrink:0;}
  .slide img{width:100%;height:100%;object-fit:cover;display:block;}
  .slide-overlay{
    position:absolute;inset:0;
    background:linear-gradient(0deg,rgba(11,31,74,.7) 0%,transparent 50%);
    display:flex;align-items:flex-end;padding:2rem;
  }
  .slide-caption p{
    font-size:.72rem;font-weight:600;letter-spacing:.08em;
    text-transform:uppercase;color:rgba(255,255,255,.55);margin:0 0 .25rem;
  }
  .slide-caption h3{
    font-family:var(--font-display);font-style:italic;
    font-size:1.4rem;margin:0;color:white;
  }
  .slider-btn{
    position:absolute;top:50%;transform:translateY(-50%);
    width:40px;height:40px;border-radius:50%;
    background:rgba(255,255,255,.15);backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,.2);
    color:white;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:background .2s;z-index:2;
  }
  .slider-btn:hover{background:rgba(255,255,255,.28);}
  .slider-btn-prev{left:1rem;}
  .slider-btn-next{right:1rem;}
  .slider-dots{display:flex;gap:.5rem;justify-content:center;margin-top:1rem;}
  .slider-dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--card-border);cursor:pointer;
    transition:background .2s,transform .2s;border:none;padding:0;
  }
  .slider-dot.active{background:var(--blue-vivid);transform:scale(1.3);}

  /* ══════════════════════════════════════════════════
     MAP
  ══════════════════════════════════════════════════ */
  .map-section{padding:4rem 2rem;background:var(--surface);}
  .map-inner{max-width:1100px;margin:0 auto;}
  .map-grid{display:grid;grid-template-columns:1fr 1.6fr;gap:1.5rem;align-items:start;}
  .map-info{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;box-shadow:var(--shadow-sm);
  }
  .map-info-item{display:flex;gap:.875rem;align-items:flex-start;}
  .map-info-icon{
    width:36px;height:36px;border-radius:var(--r-sm);background:var(--surface);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
  }
  .map-info-divider{height:1px;background:var(--divider);margin:1rem 0;}
  .map-embed{border-radius:var(--r-lg);overflow:hidden;box-shadow:var(--shadow-md);height:380px;}
  .map-embed iframe{width:100%;height:100%;border:none;display:block;}

  /* ══════════════════════════════════════════════════
     NEWSLETTER
  ══════════════════════════════════════════════════ */
  .newsletter-section{
    background:white;border-top:1px solid var(--divider);padding:4rem 2rem;
  }
  .newsletter-inner{max-width:560px;margin:0 auto;text-align:center;}
  .newsletter-icon{
    width:48px;height:48px;border-radius:var(--r-md);
    background:linear-gradient(135deg,rgba(37,99,235,.1),rgba(109,40,217,.1));
    display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;
  }
  .newsletter-form{display:flex;gap:.5rem;margin-top:1.5rem;}
  .newsletter-input{
    flex:1;background:var(--surface);
    border:1px solid var(--card-border);border-radius:var(--r-sm);
    padding:.65rem 1rem;font-size:.83rem;
    font-family:var(--font-body);color:var(--text-1);
    outline:none;transition:border-color .18s,box-shadow .18s;
  }
  .newsletter-input:focus{border-color:var(--blue-vivid);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
  .newsletter-input::placeholder{color:var(--text-4);}
  .newsletter-btn{
    display:inline-flex;align-items:center;gap:.4rem;
    background:var(--blue-vivid);color:white;
    font-size:.82rem;font-weight:600;
    padding:.65rem 1.25rem;border-radius:var(--r-sm);
    border:none;cursor:pointer;transition:all .2s;white-space:nowrap;
    box-shadow:0 1px 4px rgba(37,99,235,.35);
  }
  .newsletter-btn:hover{background:#1d4ed8;transform:translateY(-1px);}
  .newsletter-note{font-size:.7rem;color:var(--text-4);margin-top:.75rem;}

  /* ══════════════════════════════════════════════════
     SCROLL REVEAL
  ══════════════════════════════════════════════════ */
  @keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .5s ease forwards;}
  .reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease;}
  .reveal.visible{opacity:1;transform:translateY(0);}
  .reveal-delay-1{transition-delay:.1s;}
  .reveal-delay-2{transition-delay:.2s;}
  .reveal-delay-3{transition-delay:.3s;}

  /* ══════════════════════════════════════════════════
     RESPONSIVE
  ══════════════════════════════════════════════════ */
  @media(max-width:768px){
    .grid-4{grid-template-columns:repeat(2,1fr);}
    .grid-2{grid-template-columns:1fr;}
    .grid-3{grid-template-columns:1fr;}
    .map-grid{grid-template-columns:1fr;}
    .newsletter-form{flex-direction:column;}
    .slide{height:260px;}
  }
  @keyframes spin{to{transform:rotate(360deg);}}
  .spin{animation:spin .8s linear infinite;display:inline-block;}
</style>

{{-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ --}}
<div class="hero">
  <div class="hero-grid"></div>
  <div class="hero-content animate-in">
    <div class="hero-tag">
      <span class="hero-tag-dot"></span>
      Luanda · Angola · 2026
    </div>
    <h1 class="hero-title">
      Iº Congresso de Psiquiatria<br>e Saúde Mental em Angola
    </h1>
    <p class="hero-sub">
      Um encontro internacional de excelência em psiquiatria, saúde mental e bem-estar.<br>
      Junte-se a profissionais, investigadores e especialistas de todo o mundo para discutir inovações, desafios e soluções em saúde mental.
    </p>
    <div class="hero-actions">
      <a href="{{ route('inscricao.create') }}" class="hero-btn-main">
        Inscrever-me agora
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </a>
        <a href="#como-funciona" class="hero-btn-sec">Como funciona</a>
    </div>

    {{-- ── COUNTDOWN ── --}}
    <p class="countdown-title">O evento começa em</p>
    <div class="countdown-wrap">
      <div class="countdown-box">
        <span class="countdown-num" id="cd-days">--</span>
        <span class="countdown-lbl">Dias</span>
      </div>
      <span class="countdown-sep">:</span>
      <div class="countdown-box">
        <span class="countdown-num" id="cd-hours">--</span>
        <span class="countdown-lbl">Horas</span>
      </div>
      <span class="countdown-sep">:</span>
      <div class="countdown-box">
        <span class="countdown-num" id="cd-mins">--</span>
        <span class="countdown-lbl">Min</span>
      </div>
      <span class="countdown-sep">:</span>
      <div class="countdown-box">
        <span class="countdown-num" id="cd-secs">--</span>
        <span class="countdown-lbl">Seg</span>
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     METRICS
═══════════════════════════════════════════════ --}}
<div class="section" style="padding-top:3rem;padding-bottom:2rem;">
  <div class="grid-4 reveal">
    @foreach([
      ['20+','Oradores nacionais',
       'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
      ['3','Dias de congresso',
       'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
      ['15+','Sessões científicas',
       'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
      ['500+','Participantes esperados',
       'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
    ] as [$n,$l,$svg])
      <div class="metric-card">
        <div style="width:40px;height:40px;border-radius:var(--r-sm);
                    background:rgba(37,99,235,.07);
                    display:flex;align-items:center;justify-content:center;
                    margin:0 auto .875rem;">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
               stroke="var(--blue-vivid)" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svg }}"/>
          </svg>
        </div>
        <div class="metric-num">{{ $n }}</div>
        <div class="metric-label">{{ $l }}</div>
      </div>
    @endforeach
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     ABOUT + INFO
═══════════════════════════════════════════════ --}}
<div class="section bg-fundo-escuro" style="padding-top:1rem;">
  <div class="grid-2 reveal">
    <div class="info-card">
      <p class="section-label" style="margin-bottom:.5rem;">Sobre o Evento</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0 0 1rem;">O que é o CPSA 2026?</h2>
      <p style="font-size:.85rem;color:var(--text-2);line-height:1.75;margin:0 0 .875rem;">
        O <strong>Iº Congresso de Psiquiatria e Saúde Mental em Angola</strong> é um evento científico
        de referência que reúne profissionais de saúde, investigadores, académicos e estudantes
        para debater os avanços e desafios na área da saúde mental em Angola e em África.
      </p>
      <p style="font-size:.85rem;color:var(--text-2);line-height:1.75;margin:0;">
        O evento contará com conferências plenárias, mesas redondas, apresentação de casos
        clínicos e workshops práticos de referência internacional.
      </p>
    </div>
    <div class="info-card">
      <p class="section-label" style="margin-bottom:.5rem;">Informações</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0 0 1.25rem;">Detalhes do Evento</h2>
      <div style="display:flex;flex-direction:column;gap:.875rem;">
        @foreach([
          ['Local','Luanda, República de Angola',
           'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
          ['Data','Agosto de 2026 — Em breve',
           'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['Idioma','Português',
           'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
          ['Formato','Presencial e Online',
           'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-2'],
        ] as [$lbl,$val,$svgPath])
          <div style="display:flex;align-items:center;gap:.875rem;">
            <div style="width:36px;height:36px;border-radius:var(--r-sm);background:var(--surface);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                   stroke="var(--blue-brand)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPath }}"/>
              </svg>
            </div>
            <div>
              <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;
                        letter-spacing:.08em;color:var(--text-3);margin:0 0 .15rem;">{{ $lbl }}</p>
              <p style="font-size:.82rem;font-weight:600;color:var(--text-1);margin:0;">{{ $val }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     SPEAKERS
═══════════════════════════════════════════════ --}}
<div class="speakers-section">
  <div class="speakers-inner">
    <div class="reveal" style="margin-bottom:2rem;">
      <p class="section-label" style="margin-bottom:.375rem;">Palestrantes</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0;">Conheça os nossos especialistas</h2>
    </div>
    <div class="grid-4 reveal reveal-delay-1">
      @php
        $speakersToShow = isset($speakers) ? $speakers->take(4) : collect([]);
      @endphp
      @forelse($speakersToShow as $speaker)
        <div class="speaker-card">
          <div class="speaker-avatar">
            @if(!empty($speaker->foto))
              <img src="{{ Storage::url($speaker->foto) }}" alt="{{ $speaker->nome }}">
            @else
              {{ strtoupper(substr($speaker->nome,0,1)) }}
            @endif
          </div>
          <p class="speaker-name">{{ $speaker->nome }}</p>
          <p class="speaker-role">{{ $speaker->especialidade }}</p>
          <span class="speaker-badge">{{ $speaker->pais ?? 'Angola' }}</span>
        </div>
      @empty
        @foreach([
          ['Prof. Dr. João Silva','Psiquiatria Clínica','Angola','J'],
          ['Dra. Maria Santos','Saúde Mental Comunitária','Portugal','M'],
          ['Dr. Carlos Mendes','Neuropsiquiatria','Brasil','C'],
          ['Profa. Ana Costa','Psicologia Clínica','Angola','A'],
        ] as [$nome,$esp,$pais,$inicial])
          <div class="speaker-card">
            <div class="speaker-avatar">{{ $inicial }}</div>
            <p class="speaker-name">{{ $nome }}</p>
            <p class="speaker-role">{{ $esp }}</p>
            <span class="speaker-badge">{{ $pais }}</span>
          </div>
        @endforeach
      @endforelse
    </div>
    <div class="speakers-cta reveal reveal-delay-2">
      <a href="{{ route('speakers.index') }}">
        Ver todos os palestrantes
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </a>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     GALLERY / SLIDER
═══════════════════════════════════════════════ --}}
<div class="gallery-section">
  <div class="gallery-inner">
    <div class="reveal" style="margin-bottom:2rem;">
      <p class="section-label" style="margin-bottom:.375rem;">Galeria</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0;">Momentos do evento</h2>
    </div>
    <div class="slider-wrap reveal reveal-delay-1">
      <div class="slider-track" id="sliderTrack">
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1200&q=80"
               alt="Conferências plenárias" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Edição anterior</p>
              <h3>Conferências Plenárias</h3>
            </div>
          </div>
        </div>
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=1200&q=80"
               alt="Workshops práticos" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Formação contínua</p>
              <h3>Workshops Práticos</h3>
            </div>
          </div>
        </div>
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=1200&q=80"
               alt="Mesas redondas" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Debate científico</p>
              <h3>Mesas Redondas</h3>
            </div>
          </div>
        </div>
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=1200&q=80"
               alt="Networking" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Conexões profissionais</p>
              <h3>Networking & Parcerias</h3>
            </div>
          </div>
        </div>
      </div>
      <button class="slider-btn slider-btn-prev" id="sliderPrev" aria-label="Anterior">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>
      <button class="slider-btn slider-btn-next" id="sliderNext" aria-label="Próximo">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
    </div>
    <div class="slider-dots" id="sliderDots"></div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     CATEGORIES
═══════════════════════════════════════════════ --}}
<div class="section" style="padding-top:3rem;padding-bottom:0;">
  <div class="reveal">
    <p class="section-label" style="margin-bottom:.375rem;">Participação</p>
    <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
               color:var(--text-1);margin:0 0 1.5rem;">Categorias de Inscrição</h2>
    <div class="cat-grid">
      @foreach([
        ['Médico(a)',     'Especialistas e clínicos gerais',       '#1d4ed8','#eff6ff'],
        ['Enfermeiro(a)', 'Profissionais de enfermagem',           '#0f766e','#f0fdfa'],
        ['Psicólogo(a)',  'Psicólogos clínicos e investigadores',  '#6d28d9','#f5f3ff'],
        ['Estudante',     'Ciências da saúde',                     '#b45309','#fffbeb'],
        ['Outro',         'Outros profissionais de saúde',         '#475569','#f8faff'],
      ] as [$lbl,$desc,$col,$bg])
        <div class="cat-card">
          <div style="width:10px;height:3px;border-radius:2px;
                      background:{{ $col }};margin-bottom:.75rem;"></div>
          <p style="font-size:.82rem;font-weight:700;color:var(--text-1);margin:0 0 .25rem;">
            {{ $lbl }}
          </p>
          <p style="font-size:.7rem;color:var(--text-3);margin:0;line-height:1.5;">
            {{ $desc }}
          </p>
        </div>
      @endforeach
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     HOW IT WORKS + CTA
═══════════════════════════════════════════════ --}}
<div class="section">
  <div class="grid-2 reveal">
    <div>
      <p class="section-label" style="margin-bottom:.375rem;">Processo</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0 0 1.5rem;">Como funciona a inscrição</h2>
      <div class="step-line">
        @foreach([
          ['Preencher formulário','Complete os dados pessoais e profissionais.'],
          ['Upload do comprovativo','Anexe o comprovativo de pagamento (PDF ou imagem).'],
          ['Análise pela comissão','A comissão organizadora valida a sua inscrição.'],
          ['Certificado','Após aprovação, receba o certificado por email.'],
        ] as $i=>[$t,$d])
          <div class="step-item">
            <div class="step-num">{{ $i+1 }}</div>
            <div>
              <p style="font-size:.83rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;">
                {{ $t }}
              </p>
              <p style="font-size:.78rem;color:var(--text-3);margin:0;line-height:1.5;">
                {{ $d }}
              </p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="cta-block">
      <div style="position:relative;z-index:1;">
        <p style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
                  color:rgba(255,255,255,.4);margin:0 0 .75rem;">Vagas limitadas</p>
        <h3 style="font-family:var(--font-display);font-style:italic;font-size:1.7rem;
                   color:white;margin:0 0 .875rem;line-height:1.2;">
          Garanta a sua<br>participação
        </h3>
        <p style="font-size:.82rem;color:rgba(255,255,255,.5);margin:0 0 2rem;line-height:1.6;">
          Inscreva-se agora e faça parte deste marco histórico para a saúde mental em Angola.
        </p>
        <a href="{{ route('inscricao.create') }}" class="hero-btn-main">
          Fazer inscrição
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     MAP
═══════════════════════════════════════════════ --}}
<div class="map-section">
  <div class="map-inner">
    <div class="reveal" style="margin-bottom:2rem;">
      <p class="section-label" style="margin-bottom:.375rem;">Localização</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0;">Como chegar ao evento</h2>
    </div>
    <div class="map-grid reveal reveal-delay-1">
      <div class="map-info">
        <p class="section-label" style="margin-bottom:1rem;">Detalhes do Local</p>
        <div class="map-info-item">
          <div class="map-info-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                 stroke="var(--blue-brand)" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <div>
            <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;
                      letter-spacing:.07em;color:var(--text-3);margin:0 0 .2rem;">Endereço</p>
            <p style="font-size:.82rem;font-weight:600;color:var(--text-1);
                      margin:0;line-height:1.5;">
              Luanda, República de Angola<br>
              <span style="font-weight:400;color:var(--text-2);">Local a confirmar</span>
            </p>
          </div>
        </div>
        <div class="map-info-divider"></div>
        <div class="map-info-item">
          <div class="map-info-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                 stroke="var(--blue-brand)" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;
                      letter-spacing:.07em;color:var(--text-3);margin:0 0 .2rem;">Data</p>
            <p style="font-size:.82rem;font-weight:600;color:var(--text-1);margin:0;">
              Agosto de 2026
            </p>
          </div>
        </div>
        <div class="map-info-divider"></div>
        <div class="map-info-item">
          <div class="map-info-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                 stroke="var(--blue-brand)" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-2"/>
            </svg>
          </div>
          <div>
            <p style="font-size:.7rem;font-weight:700;text-transform:uppercase;
                      letter-spacing:.07em;color:var(--text-3);margin:0 0 .2rem;">Formato</p>
            <p style="font-size:.82rem;font-weight:600;color:var(--text-1);margin:0;">
              Presencial e Online
            </p>
          </div>
        </div>
        <div style="margin-top:1.5rem;">
          <a href="https://maps.google.com/?q=Luanda,Angola" target="_blank" rel="noopener"
             style="display:inline-flex;align-items:center;gap:.4rem;font-size:.78rem;
                    font-weight:600;color:var(--blue-vivid);text-decoration:none;">
            Ver no Google Maps
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
          </a>
        </div>
      </div>
      <div class="map-embed">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.55997446184!2d13.223397724450628!3d-8.827341690338166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f3aeb535e5c7%3A0xb93943805dd1c735!2sHospital%20Psiqui%C3%A1trico%20de%20Luanda%2C%20Luanda!5e0!3m2!1spt-PT!2sao!4v1773784587531!5m2!1spt-PT!2sao"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Localização do evento - Hospital Psiquiátrico de Luanda">
        </iframe>
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     NEWSLETTER
═══════════════════════════════════════════════ --}}
<div class="newsletter-section">
  <div class="newsletter-inner reveal">
    <div class="newsletter-icon">
      <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
           stroke="var(--blue-vivid)" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
      </svg>
    </div>
    <p class="section-label" style="margin-bottom:.5rem;">Newsletter</p>
    <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.5rem;
               color:var(--text-1);margin:0 0 .5rem;">Fique sempre informado</h2>
    <p style="font-size:.83rem;color:var(--text-2);line-height:1.6;margin:0;">
      Receba novidades sobre o programa, palestrantes e informações importantes
      directamente no seu email.
    </p>
    <form class="newsletter-form" id="newsletterForm"
          action="{{ route('newsletter.subscribe') }}" method="POST">
      @csrf
      <input type="email" name="email"
             placeholder="O seu endereço de email"
             class="newsletter-input" required>
      <button type="submit" class="newsletter-btn" id="newsletterBtn">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
        Subscrever
      </button>
    </form>
    <p class="newsletter-note">Sem spam. Pode cancelar a subscrição a qualquer momento.</p>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ── 1. COUNTDOWN ─────────────────────────────── */
  const eventDate = new Date('2026-08-01T08:00:00');
  function pad(n){ return String(n).padStart(2,'0'); }
  function updateCountdown() {
    const diff = eventDate - new Date();
    if (diff <= 0) {
      ['cd-days','cd-hours','cd-mins','cd-secs'].forEach(id=>{
        document.getElementById(id).textContent = '00';
      });
      return;
    }
    document.getElementById('cd-days').textContent  = pad(Math.floor(diff/86400000));
    document.getElementById('cd-hours').textContent = pad(Math.floor((diff%86400000)/3600000));
    document.getElementById('cd-mins').textContent  = pad(Math.floor((diff%3600000)/60000));
    document.getElementById('cd-secs').textContent  = pad(Math.floor((diff%60000)/1000));
  }
  updateCountdown();
  setInterval(updateCountdown, 1000);

  /* ── 2. SLIDER ────────────────────────────────── */
  const track    = document.getElementById('sliderTrack');
  const dotsWrap = document.getElementById('sliderDots');
  const slides   = track ? Array.from(track.querySelectorAll('.slide')) : [];
  let current = 0, autoSlide;

  if (slides.length && dotsWrap) {
    slides.forEach(function(_,i){
      const btn = document.createElement('button');
      btn.className = 'slider-dot' + (i===0?' active':'');
      btn.setAttribute('aria-label','Slide '+(i+1));
      btn.addEventListener('click', function(){ clearInterval(autoSlide); goTo(i); startAuto(); });
      dotsWrap.appendChild(btn);
    });

    function goTo(idx) {
      current = (idx + slides.length) % slides.length;
      track.style.transform = 'translateX(-' + (current*100) + '%)';
      dotsWrap.querySelectorAll('.slider-dot').forEach(function(d,i){
        d.classList.toggle('active', i===current);
      });
    }
    function startAuto(){ autoSlide = setInterval(function(){ goTo(current+1); }, 5000); }

    document.getElementById('sliderPrev').addEventListener('click',function(){
      clearInterval(autoSlide); goTo(current-1); startAuto();
    });
    document.getElementById('sliderNext').addEventListener('click',function(){
      clearInterval(autoSlide); goTo(current+1); startAuto();
    });
    startAuto();
  }

  /* ── 3. SCROLL REVEAL ─────────────────────────── */
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const obs = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if (e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    revealEls.forEach(function(el){ obs.observe(el); });
  } else {
    revealEls.forEach(function(el){ el.classList.add('visible'); });
  }

  /* ── 4. NEWSLETTER AJAX ───────────────────────── */
  const form = document.getElementById('newsletterForm');
  const btn  = document.getElementById('newsletterBtn');
  if (form && btn) {
    form.addEventListener('submit', async function(e){
      e.preventDefault();
      const email = form.querySelector('input[type=email]').value;
      btn.disabled = true;
      btn.innerHTML = '<span class="spin">↻</span> A subscrever...';
      try {
        const res = await fetch(form.action, {
          method:'POST',
          headers:{
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Content-Type':'application/json',
            'Accept':'application/json'
          },
          body: JSON.stringify({ email })
        });
        if (res.ok) {
          form.closest('.newsletter-inner').innerHTML =
            '<p style="font-size:.9rem;font-weight:600;color:var(--success);">✓ Subscrito com sucesso! Obrigado.</p>';
        } else { throw new Error(); }
      } catch {
        btn.disabled = false;
        btn.innerHTML = '→ Subscrever';
        form.querySelector('input').style.borderColor = 'var(--danger)';
      }
    });
  }

});
</script>
@endsection
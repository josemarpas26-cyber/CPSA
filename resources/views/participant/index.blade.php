{{-- 
  FICHEIRO: resources/views/participant/index.blade.php
  
  ALTERAÇÕES:
  1. Carrossel completamente reescrito para mobile
  2. Secção de Cursos adicionada (entre Speakers e Galeria)
  3. Responsividade geral melhorada
  4. Meta tag viewport melhorado
--}}
@extends('layouts.app')
@section('title','Início')
@section('content')
<style>
  /* ══════════════════════════════════════════════════
     GLOBAL RESPONSIVE FIXES
  ══════════════════════════════════════════════════ */
  .container { max-width: 1100px; margin: 0 auto; padding: 0 1rem; }

  /* Prevent horizontal scroll on all devices */
  html, body { overflow-x: hidden; max-width: 100vw; }

  /* ══════════════════════════════════════════════════
     HERO
  ══════════════════════════════════════════════════ */
  .hero{
    background:var(--navy);
    position:relative;overflow:hidden;
    padding:4rem 1rem 3.5rem;
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
  .hero-content{position:relative;z-index:1;max-width:720px;margin:0 auto;padding:0 .5rem;}
  .hero-tag{
    display:inline-flex;align-items:center;gap:.5rem;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12);
    border-radius:99px;padding:.35rem 1rem;
    font-size:.72rem;font-weight:600;
    color:rgba(255,255,255,.7);
    letter-spacing:.06em;text-transform:uppercase;
    margin-bottom:1.25rem;
  }
  .hero-tag-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--teal-light);
    animation:pulse-dot 2s ease-in-out infinite;
  }
  @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.5);}}
  .hero-title{
    font-family:var(--font-display);font-style:italic;
    font-size:clamp(1.6rem,5vw,3.25rem);
    color:white;line-height:1.1;margin:0 0 1rem;
  }
  .hero-sub{font-size:clamp(.8rem,.95rem,1rem);color:rgba(255,255,255,.55);line-height:1.75;margin:0 0 1.75rem;}
  .hero-actions{display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-bottom:2.5rem;}
  .hero-btn-main{
    display:inline-flex;align-items:center;gap:.5rem;
    background:var(--blue-vivid);color:white;
    font-size:.85rem;font-weight:600;
    padding:.75rem 1.5rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;
    box-shadow:0 2px 12px rgba(37,99,235,.45);
    white-space:nowrap;
  }
  .hero-btn-main:hover{background:#1d4ed8;transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.5);}
  .hero-btn-sec{
    display:inline-flex;align-items:center;gap:.5rem;
    border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.75);
    font-size:.85rem;font-weight:600;
    padding:.75rem 1.25rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;white-space:nowrap;
  }
  .hero-btn-sec:hover{border-color:rgba(255,255,255,.4);color:white;background:rgba(255,255,255,.06);}

  /* ══════════════════════════════════════════════════
     COUNTDOWN
  ══════════════════════════════════════════════════ */
  .countdown-title{
    font-size:.72rem;font-weight:600;letter-spacing:.08em;
    text-transform:uppercase;color:rgba(255,255,255,.35);
    margin:0 0 .875rem;
  }
  .countdown-wrap{
    display:flex;gap:.625rem;justify-content:center;flex-wrap:wrap;
  }
  .countdown-box{
    background:rgba(255,255,255,.07);
    border:1px solid rgba(255,255,255,.1);
    border-radius:10px;
    padding:.625rem .875rem;
    min-width:64px;text-align:center;
    backdrop-filter:blur(8px);
  }
  .countdown-num{
    font-family:var(--font-mono);
    font-size:clamp(1.4rem,4vw,2rem);font-weight:700;
    color:white;line-height:1;display:block;
  }
  .countdown-lbl{
    font-size:.58rem;font-weight:600;letter-spacing:.1em;
    text-transform:uppercase;color:rgba(255,255,255,.4);
    margin-top:.25rem;display:block;
  }
  .countdown-sep{
    color:rgba(255,255,255,.25);font-size:1.5rem;
    align-self:center;line-height:1;
  }

  /* ══════════════════════════════════════════════════
     SECTIONS BASE
  ══════════════════════════════════════════════════ */
  .section{max-width:1100px;margin:0 auto;padding:3rem 1rem;}
  .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
  .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;}

  /* ══════════════════════════════════════════════════
     METRIC CARDS
  ══════════════════════════════════════════════════ */
  .metric-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.25rem;
    text-align:center;box-shadow:var(--shadow-sm);
    transition:transform .2s,box-shadow .2s;
  }
  .metric-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);}
  .metric-num{font-family:var(--font-mono);font-size:1.75rem;font-weight:600;color:var(--navy);margin-bottom:.25rem;}
  .metric-label{font-size:.72rem;color:var(--text-3);font-weight:500;}

  /* ══════════════════════════════════════════════════
     INFO CARDS
  ══════════════════════════════════════════════════ */
  .info-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.75rem;box-shadow:var(--shadow-sm);
  }

  /* ══════════════════════════════════════════════════
     CATEGORIES
  ══════════════════════════════════════════════════ */
  .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.75rem;}
  .cat-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-md);padding:.875rem;
    transition:border-color .18s,box-shadow .18s,transform .18s;
  }
  .cat-card:hover{border-color:rgba(37,99,235,.25);box-shadow:var(--shadow-sm);transform:translateY(-2px);}

  /* ══════════════════════════════════════════════════
     STEPS
  ══════════════════════════════════════════════════ */
  .step-line{display:flex;flex-direction:column;gap:1.25rem;}
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
    padding:2.5rem 2rem;text-align:center;
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
    padding:3rem 1rem;
  }
  .speakers-inner{max-width:1100px;margin:0 auto;}
  .speaker-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.25rem;text-align:center;
    box-shadow:var(--shadow-sm);
    transition:transform .25s cubic-bezier(.34,1.56,.64,1),box-shadow .25s;
  }
  .speaker-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);}
  .speaker-avatar{
    width:64px;height:64px;border-radius:50%;
    background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
    display:flex;align-items:center;justify-content:center;
    margin:0 auto .75rem;
    font-family:var(--font-display);font-style:italic;
    font-size:1.25rem;color:white;font-weight:700;overflow:hidden;
  }
  .speaker-avatar img{width:64px;height:64px;border-radius:50%;object-fit:cover;}
  .speaker-name{font-size:.85rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;}
  .speaker-role{font-size:.7rem;color:var(--text-3);font-weight:500;margin:0 0 .5rem;}
  .speaker-badge{
    display:inline-block;font-size:.6rem;font-weight:700;
    letter-spacing:.06em;text-transform:uppercase;
    padding:.2rem .55rem;border-radius:99px;
    background:rgba(37,99,235,.08);color:var(--blue-vivid);
  }
  .speakers-cta{text-align:center;margin-top:1.75rem;}
  .speakers-cta a{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.8rem;font-weight:600;
    color:var(--blue-vivid);text-decoration:none;
    transition:gap .2s;
  }
  .speakers-cta a:hover{gap:.7rem;}

  /* ══════════════════════════════════════════════════
     CURSOS SECTION
  ══════════════════════════════════════════════════ */
  .cursos-section{
    padding:3.5rem 1rem;
    background:var(--surface);
    border-bottom:1px solid var(--divider);
  }
  .cursos-inner{max-width:1100px;margin:0 auto;}
  .cursos-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:1.125rem;
    margin-top:1.75rem;
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
  .curso-card-header{
    padding:1.125rem 1.25rem .75rem;
    border-bottom:1px solid var(--divider);
    background:linear-gradient(135deg,rgba(37,99,235,.03),rgba(109,40,217,.02));
  }
  .curso-card-body{padding:.875rem 1.25rem;flex:1;}
  .curso-card-footer{
    padding:.75rem 1.25rem;
    background:var(--surface);
    border-top:1px solid var(--divider);
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:.5rem;
  }
  .curso-name{
    font-size:.9rem;font-weight:700;color:var(--text-1);
    margin:0 0 .4rem;line-height:1.3;
  }
  .curso-meta{
    display:flex;flex-wrap:wrap;gap:.5rem;align-items:center;
    margin-bottom:.5rem;
  }
  .curso-meta-item{
    display:flex;align-items:center;gap:.3rem;
    font-size:.7rem;color:var(--text-3);font-weight:500;
  }
  .curso-desc{
    font-size:.78rem;color:var(--text-3);line-height:1.55;margin:0;
  }
  .vagas-badge{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.65rem;font-weight:700;padding:.2rem .6rem;border-radius:99px;
  }
  .vagas-ok{background:#ecfdf5;color:var(--success);}
  .vagas-esgotado{background:var(--danger-bg);color:var(--danger);}
  .vagas-sem{background:#eff6ff;color:var(--blue-vivid);}
  .curso-speakers{
    display:flex;flex-wrap:wrap;gap:.35rem;
    margin-top:.625rem;
  }
  .curso-speaker-chip{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.65rem;font-weight:600;
    color:var(--text-2);
  }
  .curso-speaker-chip::before{
    content:'';width:5px;height:5px;border-radius:50%;
    background:var(--blue-vivid);flex-shrink:0;
  }
  .cursos-cta{text-align:center;margin-top:1.75rem;}

  /* ══════════════════════════════════════════════════
     GALLERY / SLIDER — FULLY RESPONSIVE REWRITE
  ══════════════════════════════════════════════════ */
  .gallery-section{
    padding:3.5rem 1rem;
    background:var(--surface);
    border-bottom:1px solid var(--divider);
  }
  .gallery-inner{max-width:1100px;margin:0 auto;}


  /* ══════════════════════════════════════════════════
   GALLERY / SLIDER — CORRIGIDO
══════════════════════════════════════════════════ */

/* Container — tamanho fixo via aspect-ratio */
.slider-outer{
  position:relative;
  border-radius:var(--r-xl);
  overflow:hidden;
  box-shadow:var(--shadow-lg);
  touch-action:pan-y;
  -webkit-user-select:none;
  user-select:none;
  aspect-ratio:16/7;          /* ← ratio fixo no container */
  background:var(--navy);     /* cor de fundo enquanto carrega */
}

/* Track preenche 100% do container */
.slider-track{
  display:flex;
  height:100%;               /* ← herda a altura do container */
  transition:transform .45s cubic-bezier(.4,0,.2,1);
  will-change:transform;
}

/* Cada slide ocupa 100% do container, sem encolher */
.slide{
  flex:0 0 100%;
  width:100%;
  height:100%;               /* ← todos iguais */
  position:relative;
  overflow:hidden;
}

/* Imagem preenche o slide inteiro sem distorcer */
.slide img{
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:100%;
  object-fit:cover;          /* ← corta se preciso, nunca distorce */
  object-position:center;
  display:block;
}

/* Overlay e caption */
.slide-overlay{
  position:absolute;inset:0;
  background:linear-gradient(0deg,rgba(11,31,74,.75) 0%,rgba(11,31,74,.1) 50%,transparent 100%);
  display:flex;align-items:flex-end;padding:1.5rem;
  z-index:1;                 /* acima da imagem */
}
.slide-caption p{
  font-size:.68rem;font-weight:600;letter-spacing:.08em;
  text-transform:uppercase;color:rgba(255,255,255,.55);margin:0 0 .2rem;
}
.slide-caption h3{
  font-family:var(--font-display);font-style:italic;
  font-size:clamp(1rem,3vw,1.4rem);margin:0;color:white;line-height:1.2;
}

/* Botões prev/next */
.slider-btn{
  position:absolute;top:50%;transform:translateY(-50%);
  width:44px;height:44px;border-radius:50%;
  background:rgba(255,255,255,.18);backdrop-filter:blur(8px);
  border:1.5px solid rgba(255,255,255,.25);
  color:white;cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  transition:background .2s,transform .15s;z-index:5;
  -webkit-tap-highlight-color:transparent;
  touch-action:manipulation;
}
.slider-btn:hover,.slider-btn:focus{
  background:rgba(255,255,255,.3);outline:none;
}
.slider-btn:active{transform:translateY(-50%) scale(.92);}
.slider-btn-prev{left:.75rem;}
.slider-btn-next{right:.75rem;}

/* Dots */
.slider-dots{display:flex;gap:.5rem;justify-content:center;margin-top:.875rem;flex-wrap:wrap;}
.slider-dot{
  width:7px;height:7px;border-radius:50%;
  background:var(--card-border);cursor:pointer;
  transition:background .2s,transform .2s;border:none;padding:0;
  -webkit-tap-highlight-color:transparent;
}
.slider-dot.active{background:var(--blue-vivid);transform:scale(1.3);}

/* ── Mobile ────────────────────────────────────── */
@media(max-width:640px){
  .slider-outer{
    aspect-ratio:4/3;          /* mais alto em mobile */
    border-radius:var(--r-lg);
  }
  .slider-btn{width:36px;height:36px;}
  .slider-btn-prev{left:.5rem;}
  .slider-btn-next{right:.5rem;}
  .slide-overlay{padding:1rem;}
}

@media(max-width:480px){
  .slider-outer{
    aspect-ratio:3/2;          /* ainda mais quadrado em ecrãs pequenos */
  }
}

  /* ══════════════════════════════════════════════════
     MAP
  ══════════════════════════════════════════════════ */
  .map-section{padding:3.5rem 1rem;background:var(--surface);}
  .map-inner{max-width:1100px;margin:0 auto;}
  .map-grid{display:grid;grid-template-columns:1fr 1.6fr;gap:1.5rem;align-items:start;}
  .map-info{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.75rem;box-shadow:var(--shadow-sm);
  }
  .map-info-item{display:flex;gap:.875rem;align-items:flex-start;}
  .map-info-icon{
    width:36px;height:36px;border-radius:var(--r-sm);background:var(--surface);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
  }
  .map-info-divider{height:1px;background:var(--divider);margin:.875rem 0;}
  .map-embed{border-radius:var(--r-lg);overflow:hidden;box-shadow:var(--shadow-md);}
  .map-embed iframe{width:100%;height:340px;border:none;display:block;}

  /* ══════════════════════════════════════════════════
     NEWSLETTER
  ══════════════════════════════════════════════════ */
  .newsletter-section{
    background:white;border-top:1px solid var(--divider);padding:3.5rem 1rem;
  }
  .newsletter-inner{max-width:560px;margin:0 auto;text-align:center;}
  .newsletter-icon{
    width:48px;height:48px;border-radius:var(--r-md);
    background:linear-gradient(135deg,rgba(37,99,235,.1),rgba(109,40,217,.1));
    display:flex;align-items:center;justify-content:center;margin:0 auto 1.125rem;
  }
  .newsletter-form{display:flex;gap:.5rem;margin-top:1.375rem;}
  .newsletter-input{
    flex:1;background:var(--surface);
    border:1px solid var(--card-border);border-radius:var(--r-sm);
    padding:.625rem .875rem;font-size:.83rem;
    font-family:var(--font-body);color:var(--text-1);
    outline:none;transition:border-color .18s,box-shadow .18s;
    min-width:0; /* flex shrink fix */
  }
  .newsletter-input:focus{border-color:var(--blue-vivid);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
  .newsletter-input::placeholder{color:var(--text-4);}
  .newsletter-btn{
    display:inline-flex;align-items:center;gap:.4rem;
    background:var(--blue-vivid);color:white;
    font-size:.82rem;font-weight:600;
    padding:.625rem 1.125rem;border-radius:var(--r-sm);
    border:none;cursor:pointer;transition:all .2s;white-space:nowrap;
    box-shadow:0 1px 4px rgba(37,99,235,.35);
    flex-shrink:0;
  }
  .newsletter-btn:hover{background:#1d4ed8;transform:translateY(-1px);}
  .newsletter-note{font-size:.68rem;color:var(--text-4);margin-top:.625rem;}

  /* ══════════════════════════════════════════════════
     SCROLL REVEAL
  ══════════════════════════════════════════════════ */
  @keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .5s ease forwards;}
  .reveal{opacity:0;transform:translateY(20px);transition:opacity .55s ease,transform .55s ease;}
  .reveal.visible{opacity:1;transform:translateY(0);}
  .reveal-delay-1{transition-delay:.1s;}
  .reveal-delay-2{transition-delay:.2s;}
  .reveal-delay-3{transition-delay:.3s;}

  /* ══════════════════════════════════════════════════
     RESPONSIVE BREAKPOINTS
  ══════════════════════════════════════════════════ */
  @media(max-width:900px){
    .grid-4{grid-template-columns:repeat(2,1fr);}
    .grid-2{grid-template-columns:1fr;}
    .map-grid{grid-template-columns:1fr;}
  }
  @media(max-width:640px){
    .grid-3{grid-template-columns:1fr;}
    .newsletter-form{flex-direction:column;}
    .hero-actions{flex-direction:column;align-items:center;}
    .hero-btn-main,.hero-btn-sec{width:100%;max-width:280px;justify-content:center;}
    .cursos-grid{grid-template-columns:1fr;}
  }
  @media(max-width:480px){
    .grid-4{grid-template-columns:1fr 1fr;}
    .countdown-wrap{gap:.4rem;}
    .countdown-box{min-width:54px;padding:.5rem .625rem;}
  }

  @keyframes spin{to{transform:rotate(360deg);}}
  .spin{animation:spin .8s linear infinite;display:inline-block;}

  /* ══════════════════════════════════════════════════
     PORQUÊ PARTICIPAR
  ══════════════════════════════════════════════════ */
  .pq-section{padding:4rem 1rem;background:var(--surface);}
  .pq-header{text-align:center;margin-bottom:2.5rem;}
  .pq-header h2{font-family:var(--font-heading,var(--font-display));font-size:clamp(1.6rem,3.5vw,2.4rem);color:var(--text-1);margin:0 0 .75rem;line-height:1.15;}
  .pq-header p{font-size:.9rem;color:var(--text-3);max-width:500px;margin:0 auto;line-height:1.6;}
  .pq-tabs{display:flex;justify-content:center;gap:.375rem;flex-wrap:wrap;margin-bottom:2rem;}
  .pq-tab{display:flex;align-items:center;gap:.5rem;padding:.5rem 1.25rem;border-radius:99px;font-size:.8rem;font-weight:700;cursor:pointer;border:1.5px solid var(--card-border);background:var(--card);color:var(--text-2);transition:all .2s;font-family:var(--font-body);}
  .pq-tab:hover{border-color:var(--blue-vivid);color:var(--blue-vivid);}
  .pq-tab.active{background:var(--blue-vivid);border-color:var(--blue-vivid);color:#fff;}
  .pq-panel{display:none;}
  .pq-panel.active{display:block;}
  .pq-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;}
  .pq-card{background:var(--card);border:1px solid var(--card-border);border-radius:var(--r-lg);padding:1.25rem;box-shadow:var(--shadow-sm);transition:transform .2s,box-shadow .2s;}
  .pq-card:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(11,31,74,.1);}
  .pq-icon{width:40px;height:40px;border-radius:var(--r-md);display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;flex-shrink:0;}
  .pq-card h3{font-size:.875rem;font-weight:700;color:var(--text-1);margin:0 0 .35rem;}
  .pq-card p{font-size:.76rem;color:var(--text-3);margin:0;line-height:1.55;}

  /* ══════════════════════════════════════════════════
     OBJECTIVOS
  ══════════════════════════════════════════════════ */
  .obj-section{padding:4rem 1rem;background:var(--navy);position:relative;overflow:hidden;}
  .obj-section::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");}
  .obj-inner{position:relative;z-index:1;max-width:1100px;margin:0 auto;}
  .obj-header{text-align:center;margin-bottom:2.5rem;}
  .obj-header h2{font-family:var(--font-heading,var(--font-display));font-size:clamp(1.6rem,3.5vw,2.4rem);color:#fff;margin:0 0 .75rem;line-height:1.15;}
  .obj-header p{font-size:.9rem;color:rgba(210,225,255,.7);max-width:500px;margin:0 auto;}
  .obj-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem;}
  .obj-card{display:flex;gap:1rem;align-items:flex-start;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);border-radius:var(--r-lg);padding:1.25rem;transition:background .2s,transform .2s;}
  .obj-card:hover{background:rgba(255,255,255,.09);transform:translateY(-3px);}
  .obj-num{flex-shrink:0;width:32px;height:32px;border-radius:var(--r-sm);background:rgba(96,165,250,.2);border:1px solid rgba(96,165,250,.3);display:flex;align-items:center;justify-content:center;font-family:var(--font-mono);font-size:.75rem;font-weight:700;color:#93c5fd;}
  .obj-card h3{font-size:.875rem;font-weight:700;color:#f0f6ff;margin:0 0 .3rem;}
  .obj-card p{font-size:.74rem;color:rgba(210,225,255,.65);margin:0;line-height:1.55;}
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
      Um encontro internacional de excelência em psiquiatria, saúde mental e bem-estar.<br class="hidden-xs">
      Junte-se a profissionais, investigadores e especialistas para discutir inovações e soluções em saúde mental.
    </p>
    <div class="hero-actions">
      <a href="{{ route('inscricao.create') }}" class="hero-btn-main">
        Inscrever-me agora
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </a>
      <a href="#processo" class="hero-btn-sec">Como funciona</a>
    </div>

    {{-- COUNTDOWN --}}
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
<div class="section" style="padding-top:2.5rem;padding-bottom:2rem;">
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
        <div style="width:38px;height:38px;border-radius:var(--r-sm);
                    background:rgba(37,99,235,.07);
                    display:flex;align-items:center;justify-content:center;
                    margin:0 auto .75rem;">
          <svg width="17" height="17" fill="none" viewBox="0 0 24 24"
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
<div class="section" style="padding-top:1rem;">
  <div class="grid-2 reveal">
    <div class="info-card">
      <p class="section-label" style="margin-bottom:.5rem;">Sobre o Evento</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
                 color:var(--text-1);margin:0 0 1rem;">O que é o CPSM 2026?</h2>
      <p style="font-size:.84rem;color:var(--text-2);line-height:1.75;margin:0 0 .875rem;">
        O <strong>Iº Congresso de Psiquiatria e Saúde Mental em Angola</strong> é um evento científico
        que reúne profissionais de saúde, investigadores e estudantes para debater os avanços e desafios na área da saúde mental em Angola e em África.
      </p>
      <p style="font-size:.84rem;color:var(--text-2);line-height:1.75;margin:0;">
        O evento contará com conferências plenárias, mesas redondas, casos clínicos e workshops práticos de referência internacional.
      </p>
    </div>
    <div class="info-card">
      <p class="section-label" style="margin-bottom:.5rem;">Informações</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
                 color:var(--text-1);margin:0 0 1.25rem;">Detalhes do Evento</h2>
      <div style="display:flex;flex-direction:column;gap:.75rem;">
        @foreach([
          ['Local','Luanda, República de Angola',
           'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
          ['Período de Inscrições','01 de Março a 30 de Julho de 2026',
           'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['Data','Agosto de 2026 — Em breve',
           'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['Idioma','Português',
           'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
          ['Formato','Presencial e Online',
           'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-2'],
        ] as [$lbl,$val,$svgPath])
          <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:34px;height:34px;border-radius:var(--r-sm);background:var(--surface);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                   stroke="var(--blue-brand)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPath }}"/>
              </svg>
            </div>
            <div>
              <p style="font-size:.65rem;font-weight:700;text-transform:uppercase;
                        letter-spacing:.08em;color:var(--text-3);margin:0 0 .1rem;">{{ $lbl }}</p>
              <p style="font-size:.8rem;font-weight:600;color:var(--text-1);margin:0;">{{ $val }}</p>
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
    <div class="reveal" style="margin-bottom:1.75rem;">
      <p class="section-label" style="margin-bottom:.375rem;">Palestrantes</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
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
          ['Prof. Dr. João Silva','Psiquiatria Clínica','J'],
          ['Dra. Maria Santos','Saúde Mental','M'],
          ['Dr. Carlos Mendes','Neuropsiquiatria','C'],
          ['Profa. Ana Costa','Psicologia Clínica','A'],
        ] as [$nome,$esp,$inicial])
          <div class="speaker-card">
            <div class="speaker-avatar">{{ $inicial }}</div>
            <p class="speaker-name">{{ $nome }}</p>
            <p class="speaker-role">{{ $esp }}</p>
            <span class="speaker-badge">Angola</span>
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
     CURSOS E WORKSHOPS
═══════════════════════════════════════════════ --}}
<div class="cursos-section">
  <div class="cursos-inner">
    <div class="reveal">
      <p class="section-label" style="margin-bottom:.375rem;">Formação</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
                 color:var(--text-1);margin:0 0 .5rem;">Cursos & Workshops</h2>
      <p style="font-size:.83rem;color:var(--text-3);max-width:500px;margin:0;">
        Formação especializada com os melhores profissionais de saúde mental de Angola.
        As vagas são limitadas — inscreva-se com antecedência.
      </p>
    </div>

    @php
      $cursosPublicos = isset($cursos)
        ? $cursos->filter(fn($c) => $c->ativo)->take(6)
        : collect([]);
    @endphp

    @if($cursosPublicos->isNotEmpty())
      <div class="cursos-grid reveal reveal-delay-1">
        @foreach($cursosPublicos as $curso)
          @php
            $inscritos = $curso->inscritos_count ?? 0;
            $cheio     = $curso->vagas && $inscritos >= $curso->vagas;
            $vagasDisp = $curso->vagas ? max(0, $curso->vagas - $inscritos) : null;
          @endphp
          <div class="curso-card">
            <div class="curso-card-header">
              <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;flex-wrap:wrap;">
                <h3 class="curso-name">{{ $curso->nome }}</h3>
                @if($cheio)
                  <span class="vagas-badge vagas-esgotado">Esgotado</span>
                @elseif($vagasDisp !== null)
                  <span class="vagas-badge vagas-ok">
                    <svg width="9" height="9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $vagasDisp }} vagas
                  </span>
                @else
                  <span class="vagas-badge vagas-sem">Vagas livres</span>
                @endif
              </div>
              <div class="curso-meta">
                <span class="curso-meta-item">
                  <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  {{ $curso->dia->isoFormat('ddd, DD/MM') }}
                </span>
                <span class="curso-meta-item">
                  <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                  </svg>
                  {{ substr($curso->hora_inicio,0,5) }}–{{ substr($curso->hora_fim,0,5) }}
                </span>
                <span class="curso-meta-item">
                  <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  </svg>
                  {{ $curso->sala }}
                </span>
              </div>
            </div>
            @if($curso->descricao || $curso->speakers->isNotEmpty())
              <div class="curso-card-body">
                @if($curso->descricao)
                  <p class="curso-desc">{{ Str::limit($curso->descricao, 120) }}</p>
                @endif
                @if($curso->speakers->isNotEmpty())
                  <div class="curso-speakers">
                    @foreach($curso->speakers as $sp)
                      <span class="curso-speaker-chip">{{ $sp->nome }}</span>
                    @endforeach
                  </div>
                @endif
              </div>
            @endif
            <div class="curso-card-footer">
              <span style="font-size:.7rem;color:var(--text-3);">
                @if($curso->vagas)
                  {{ $inscritos }}/{{ $curso->vagas }} inscritos
                @else
                  Sem limite de vagas
                @endif
              </span>
              @if(!$cheio)
                <a href="{{ route('inscricao.create') }}"
                   style="display:inline-flex;align-items:center;gap:.3rem;
                          font-size:.75rem;font-weight:700;color:var(--blue-vivid);
                          text-decoration:none;transition:gap .15s;">
                  Inscrever-me
                  <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                  </svg>
                </a>
              @else
                <span style="font-size:.73rem;font-weight:600;color:var(--danger);">Esgotado</span>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @else
      {{-- Placeholder enquanto não há cursos --}}
      <div class="reveal reveal-delay-1" style="background:var(--card);border:1px dashed var(--card-border);
           border-radius:var(--r-lg);padding:3rem 2rem;text-align:center;margin-top:1.75rem;">
        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--text-4)" stroke-width="1.2"
             style="margin:0 auto 1rem;display:block;">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489"/>
        </svg>
        <p style="font-size:.9rem;font-weight:600;color:var(--text-2);margin:0 0 .25rem;">
          Cursos em breve
        </p>
        <p style="font-size:.78rem;color:var(--text-3);margin:0;">
          O programa de cursos e workshops será divulgado em breve.
        </p>
      </div>
    @endif

    <div class="cursos-cta reveal reveal-delay-2">
      <a href="{{ route('programa.index') }}"
         style="display:inline-flex;align-items:center;gap:.5rem;
                font-size:.8rem;font-weight:600;color:var(--blue-vivid);text-decoration:none;">
        Ver programa completo
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </a>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════
     GALLERY / SLIDER — RESPONSIVO
═══════════════════════════════════════════════ --}}
<div class="gallery-section">
  <div class="gallery-inner">
    <div class="reveal" style="margin-bottom:1.75rem;">
      <p class="section-label" style="margin-bottom:.375rem;">Galeria</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
                 color:var(--text-1);margin:0;">Momentos do evento</h2>
    </div>
    <div class="slider-outer reveal reveal-delay-1" id="sliderOuter">
      <div class="slider-track" id="sliderTrack">
        <div class="slide">
          <img src="images/fundoEscuro.png"
               alt="Conferências plenárias" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Edição anterior</p>
              <h3>Conferências Plenárias</h3>
            </div>
          </div>
        </div>
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=1200&q=75"
               alt="Workshops práticos" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Formação contínua</p>
              <h3>Workshops Práticos</h3>
            </div>
          </div>
        </div>
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=1200&q=75"
               alt="Mesas redondas" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Debate científico</p>
              <h3>Mesas Redondas</h3>
            </div>
          </div>
        </div>
        <div class="slide">
          <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=1200&q=75"
               alt="Networking" loading="lazy">
          <div class="slide-overlay">
            <div class="slide-caption">
              <p>Conexões profissionais</p>
              <h3>Networking & Parcerias</h3>
            </div>
          </div>
        </div>
      </div>
      <button class="slider-btn slider-btn-prev" id="sliderPrev" aria-label="Slide anterior">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>
      <button class="slider-btn slider-btn-next" id="sliderNext" aria-label="Próximo slide">
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
    <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
               color:var(--text-1);margin:0 0 1.375rem;">Categorias de Inscrição</h2>
    <div class="cat-grid">
      @foreach([
        ['Profissional de Saúde','Médicos, enfermeiros, psicólogos','#1d4ed8'],
        ['Estudante',           'Ciências da saúde',               '#b45309'],
        ['Orador',              'Apresentadores e conferencistas',  '#0f766e'],
        ['Convidado',           'Personalidades convidadas',        '#6d28d9'],
        ['Imprensa',            'Jornalistas e media',              '#475569'],
      ] as [$lbl,$desc,$col])
        <div class="cat-card">
          <div style="width:10px;height:3px;border-radius:2px;
                      background:{{ $col }};margin-bottom:.625rem;"></div>
          <p style="font-size:.8rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;">{{ $lbl }}</p>
          <p style="font-size:.68rem;color:var(--text-3);margin:0;line-height:1.45;">{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>

{{-- ═══ PORQUÊ PARTICIPAR ═══ --}}
<section class="pq-section">
  <div class="pq-header reveal">
    <p class="section-label" style="margin-bottom:.5rem;">O Congresso é para si</p>
    <h2>Porquê Participar?</h2>
    <p>O CPSM 2026 foi desenhado para diferentes perfis de profissionais. Seleccione o seu:</p>
  </div>
  <div class="pq-tabs">
    @foreach([
      ['profissional', 'Profissional de Saúde'],
      ['estudante',    'Estudante'],
      ['investigador', 'Investigador'],
    ] as [$id,$lbl])
      <button class="pq-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchPq('{{ $id }}',this)">
        {{ $lbl }}
      </button>
    @endforeach
  </div>

  <div class="pq-panel active" id="pq-profissional">
    <div class="pq-grid">
      @foreach([
        ['bg'=>'rgba(37,99,235,.09)','col'=>'var(--blue-vivid)','title'=>'Formação Contínua','desc'=>'Actualize os seus conhecimentos com os mais recentes avanços em psiquiatria clínica e saúde mental.'],
        ['bg'=>'rgba(5,150,105,.09)','col'=>'#059669','title'=>'Networking Profissional','desc'=>'Conecte-se com colegas de todo o país e da CPLP. Construa relações duradouras.'],
        ['bg'=>'rgba(109,40,217,.09)','col'=>'#6d28d9','title'=>'Certificação de Presença','desc'=>'Certificado reconhecido para fins de desenvolvimento profissional.'],
        ['bg'=>'rgba(180,83,9,.09)','col'=>'#b45309','title'=>'Casos Clínicos','desc'=>'Aprenda com casos reais discutidos por especialistas nacionais e internacionais.'],
      ] as $b)
        <div class="pq-card">
          <div class="pq-icon" style="background:{{ $b['bg'] }};color:{{ $b['col'] }};">
            <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h3>{{ $b['title'] }}</h3>
          <p>{{ $b['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </div>

  <div class="pq-panel" id="pq-estudante">
    <div class="pq-grid">
      @foreach([
        ['bg'=>'rgba(37,99,235,.09)','col'=>'var(--blue-vivid)','title'=>'Aprendizagem com Especialistas','desc'=>'Interaja directamente com psiquiatras de referência a nível nacional.'],
        ['bg'=>'rgba(5,150,105,.09)','col'=>'#059669','title'=>'Desconto Especial','desc'=>'Tarifa reduzida para estudantes. Apresente o comprovativo académico.'],
        ['bg'=>'rgba(109,40,217,.09)','col'=>'#6d28d9','title'=>'Oportunidades de Carreira','desc'=>'Conheça os caminhos de especialização em psiquiatria em Angola.'],
        ['bg'=>'rgba(180,83,9,.09)','col'=>'#b45309','title'=>'Publicação de Trabalhos','desc'=>'Submeta o seu trabalho na sessão de Temas Livres e obtenha feedback de especialistas.'],
      ] as $b)
        <div class="pq-card">
          <div class="pq-icon" style="background:{{ $b['bg'] }};color:{{ $b['col'] }};">
            <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489"/>
            </svg>
          </div>
          <h3>{{ $b['title'] }}</h3>
          <p>{{ $b['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </div>

  <div class="pq-panel" id="pq-investigador">
    <div class="pq-grid">
      @foreach([
        ['bg'=>'rgba(37,99,235,.09)','col'=>'var(--blue-vivid)','title'=>'Apresentação de Investigação','desc'=>'Submeta e apresente a sua investigação no fórum mais relevante da psiquiatria angolana.'],
        ['bg'=>'rgba(5,150,105,.09)','col'=>'#059669','title'=>'Colaboração Internacional','desc'=>'Estabeleça parcerias com centros de excelência da CPLP e da África Subsaariana.'],
        ['bg'=>'rgba(109,40,217,.09)','col'=>'#6d28d9','title'=>'Acesso a Publicações','desc'=>'Trabalhos seleccionados poderão ser publicados em revista indexada parceira.'],
        ['bg'=>'rgba(180,83,9,.09)','col'=>'#b45309','title'=>'Financiamento e Bolsas','desc'=>'Saiba mais sobre as bolsas de investigação em saúde mental disponíveis.'],
      ] as $b)
        <div class="pq-card">
          <div class="pq-icon" style="background:{{ $b['bg'] }};color:{{ $b['col'] }};">
            <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607Z"/>
            </svg>
          </div>
          <h3>{{ $b['title'] }}</h3>
          <p>{{ $b['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ OBJECTIVOS ═══ --}}
<section class="obj-section">
  <div class="obj-inner">
    <div class="obj-header reveal">
      <p class="section-label" style="color:rgba(180,210,255,.7);margin-bottom:.5rem;">Missão e Visão</p>
      <h2>Objectivos do Congresso</h2>
      <p>O CPSM 2026 foi concebido com uma agenda clara para transformar a saúde mental em Angola.</p>
    </div>
    <div class="obj-grid reveal reveal-delay-1">
      @foreach([
        ['Promover o Conhecimento Científico','Difundir os avanços mais recentes em psiquiatria e saúde mental, fomentando a prática baseada em evidências.'],
        ['Fortalecer a Rede Profissional','Criar e consolidar uma comunidade de profissionais de saúde mental em Angola.'],
        ['Elevar os Padrões de Cuidados','Contribuir para a melhoria da qualidade dos serviços prestados à população angolana.'],
        ['Formar a Nova Geração','Apoiar a formação especializada de jovens profissionais e investigadores.'],
        ['Debater Políticas de Saúde Mental','Promover o diálogo entre profissionais e decisores políticos.'],
        ['Integrar Angola na Comunidade Global','Posicionar Angola como polo activo na discussão da saúde mental em África.'],
      ] as $i => [$titulo,$desc])
        <div class="obj-card">
          <div class="obj-num">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</div>
          <div>
            <h3>{{ $titulo }}</h3>
            <p>{{ $desc }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════
     HOW IT WORKS + CTA
═══════════════════════════════════════════════ --}}
<div class="section" id="processo">
  <div class="grid-2 reveal">
    <div>
      <p class="section-label" style="margin-bottom:.375rem;">Processo</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
                 color:var(--text-1);margin:0 0 1.375rem;">Como funciona a inscrição</h2>
      <div class="step-line">
        @foreach([
          ['Preencher formulário','Complete os dados pessoais e profissionais em 5 passos simples.'],
          ['Upload do comprovativo','Anexe o comprovativo de pagamento (PDF ou imagem, máx. 5MB).'],
          ['Análise pela comissão','A comissão organizadora valida a sua inscrição em poucos dias.'],
          ['Certificado','Após aprovação, receba o certificado de participação por email.'],
        ] as $i=>[$t,$d])
          <div class="step-item">
            <div class="step-num">{{ $i+1 }}</div>
            <div>
              <p style="font-size:.82rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;">{{ $t }}</p>
              <p style="font-size:.76rem;color:var(--text-3);margin:0;line-height:1.5;">{{ $d }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="cta-block">
      <div style="position:relative;z-index:1;">
        <p style="font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
                  color:rgba(255,255,255,.4);margin:0 0 .75rem;">
          Inscrições: 01 Mar — 30 Jul 2026
        </p>
        <h3 style="font-family:var(--font-display);font-style:italic;font-size:clamp(1.3rem,3vw,1.7rem);
                   color:white;margin:0 0 .75rem;line-height:1.2;">
          Garanta a sua<br>participação
        </h3>
        <p style="font-size:.8rem;color:rgba(255,255,255,.5);margin:0 0 1.75rem;line-height:1.6;">
          Inscreva-se agora e faça parte deste marco histórico para a saúde mental em Angola.
        </p>
        <a href="{{ route('inscricao.create') }}" class="hero-btn-main" style="justify-content:center;">
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
    <div class="reveal" style="margin-bottom:1.75rem;">
      <p class="section-label" style="margin-bottom:.375rem;">Localização</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.35rem;
                 color:var(--text-1);margin:0;">Como chegar ao evento</h2>
    </div>
    <div class="map-grid reveal reveal-delay-1">
      <div class="map-info">
        <p class="section-label" style="margin-bottom:.875rem;">Detalhes do Local</p>
        @foreach([
          ['Endereço','Luanda, República de Angola<br><span style="font-weight:400;color:var(--text-2);">Local a confirmar</span>',
           'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
          ['Data','Agosto de 2026',
           'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['Formato','Presencial e Online',
           'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-2'],
        ] as [$lbl,$val,$svg])
          <div class="map-info-item" style="margin-bottom:.625rem;">
            <div class="map-info-icon">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                   stroke="var(--blue-brand)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svg }}"/>
              </svg>
            </div>
            <div>
              <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;
                        letter-spacing:.07em;color:var(--text-3);margin:0 0 .1rem;">{{ $lbl }}</p>
              <p style="font-size:.8rem;font-weight:600;color:var(--text-1);margin:0;line-height:1.4;">
                {!! $val !!}
              </p>
            </div>
          </div>
          <div class="map-info-divider"></div>
        @endforeach
        <a href="https://maps.google.com/?q=Luanda,Angola" target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:.4rem;font-size:.77rem;
                  font-weight:600;color:var(--blue-vivid);text-decoration:none;margin-top:.5rem;">
          Ver no Google Maps
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
        </a>
      </div>
      <div class="map-embed">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.55997446184!2d13.223397724450628!3d-8.827341690338166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f3aeb535e5c7%3A0xb93943805dd1c735!2sHospital%20Psiqui%C3%A1trico%20de%20Luanda%2C%20Luanda!5e0!3m2!1spt-PT!2sao!4v1773784587531!5m2!1spt-PT!2sao"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="Localização — Hospital Psiquiátrico de Luanda">
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
    <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
               color:var(--text-1);margin:0 0 .5rem;">Fique sempre informado</h2>
    <p style="font-size:.82rem;color:var(--text-2);line-height:1.6;margin:0;">
      Receba novidades sobre o programa, palestrantes e informações importantes directamente no seu email.
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
    <p class="newsletter-note">Sem spam. Pode cancelar a qualquer momento.</p>
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
      ['cd-days','cd-hours','cd-mins','cd-secs'].forEach(id => {
        const el = document.getElementById(id);
        if(el) el.textContent = '00';
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

  /* ── 2. SLIDER — touch + keyboard + auto ─────── */
  const outer   = document.getElementById('sliderOuter');
  const track   = document.getElementById('sliderTrack');
  const dotsWrap= document.getElementById('sliderDots');
  const slides  = track ? Array.from(track.querySelectorAll('.slide')) : [];
  let current = 0, autoSlide, isDragging = false;
  let touchStartX = 0, touchStartY = 0, touchDeltaX = 0;

  if (!slides.length || !dotsWrap) return;

  /* Create dots */
  slides.forEach(function(_,i){
    const btn = document.createElement('button');
    btn.className = 'slider-dot' + (i===0?' active':'');
    btn.setAttribute('aria-label', 'Slide '+(i+1));
    btn.addEventListener('click', function(){ clearInterval(autoSlide); goTo(i); startAuto(); });
    dotsWrap.appendChild(btn);
  });

  function goTo(idx) {
    current = ((idx % slides.length) + slides.length) % slides.length;
    track.style.transform = 'translateX(-' + (current * 100) + '%)';
    dotsWrap.querySelectorAll('.slider-dot').forEach(function(d,i){
      d.classList.toggle('active', i === current);
    });
    /* Actualiza aria */
    document.getElementById('sliderPrev') &&
      document.getElementById('sliderPrev').setAttribute('aria-label',
        'Slide anterior (' + (((current-1+slides.length)%slides.length)+1) + ' de ' + slides.length + ')');
  }

  function startAuto(){
    clearInterval(autoSlide);
    autoSlide = setInterval(function(){ goTo(current+1); }, 5000);
  }

  document.getElementById('sliderPrev').addEventListener('click',function(){
    clearInterval(autoSlide); goTo(current-1); startAuto();
  });
  document.getElementById('sliderNext').addEventListener('click',function(){
    clearInterval(autoSlide); goTo(current+1); startAuto();
  });

  /* Keyboard */
  outer.setAttribute('tabindex','0');
  outer.addEventListener('keydown', function(e){
    if(e.key === 'ArrowLeft')  { clearInterval(autoSlide); goTo(current-1); startAuto(); }
    if(e.key === 'ArrowRight') { clearInterval(autoSlide); goTo(current+1); startAuto(); }
  });

  /* Touch swipe — previne conflito com scroll vertical */
  outer.addEventListener('touchstart', function(e){
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
    touchDeltaX = 0;
    isDragging  = false;
  }, { passive: true });

  outer.addEventListener('touchmove', function(e){
    if (!touchStartX) return;
    touchDeltaX = e.touches[0].clientX - touchStartX;
    const deltaY = e.touches[0].clientY - touchStartY;
    /* Só é swipe horizontal se o movimento X for dominante */
    if (Math.abs(touchDeltaX) > Math.abs(deltaY) && Math.abs(touchDeltaX) > 8) {
      isDragging = true;
      e.preventDefault(); /* Previne scroll da página */
    }
  }, { passive: false });

  outer.addEventListener('touchend', function(){
    if (isDragging && Math.abs(touchDeltaX) > 50) {
      clearInterval(autoSlide);
      touchDeltaX > 0 ? goTo(current-1) : goTo(current+1);
      startAuto();
    }
    touchStartX = 0; isDragging = false;
  });

  /* Pause on hover/focus */
  outer.addEventListener('mouseenter', function(){ clearInterval(autoSlide); });
  outer.addEventListener('mouseleave', function(){ startAuto(); });
  outer.addEventListener('focusin',    function(){ clearInterval(autoSlide); });
  outer.addEventListener('focusout',   function(){ startAuto(); });

  startAuto();

  /* ── 3. SCROLL REVEAL ─────────────────────────── */
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const obs = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if (e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
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

/* ── Porquê Participar tabs ──────────────────────── */
function switchPq(id, btn) {
  document.querySelectorAll('.pq-panel').forEach(function(p){ p.classList.remove('active'); });
  document.querySelectorAll('.pq-tab').forEach(function(b){ b.classList.remove('active'); });
  document.getElementById('pq-' + id).classList.add('active');
  btn.classList.add('active');
}
</script>
@endsection
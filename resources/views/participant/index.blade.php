@extends('layouts.app')
@section('title','Início')
@section('content')
<style>
  .hero{
    background:var(--navy);
    position:relative;
    overflow:hidden;
    padding:5rem 2rem 4rem;
    text-align:center;
  }
  .hero::before{
    content:'';position:absolute;inset:0;
    background:
      radial-gradient(ellipse 70% 60% at 30% 50%, rgba(37,99,235,.18) 0%, transparent 60%),
      radial-gradient(ellipse 50% 40% at 80% 20%, rgba(109,40,217,.12) 0%, transparent 60%),
      radial-gradient(ellipse 60% 50% at 60% 90%, rgba(15,118,110,.08) 0%, transparent 60%);
  }
  .hero-grid{
    position:absolute;inset:0;
    background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
                     linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:40px 40px;
  }
  .hero-content{position:relative;z-index:1;max-width:680px;margin:0 auto;}
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
  .hero-tag-dot{width:6px;height:6px;border-radius:50%;background:var(--teal-light);}
  .hero-title{
    font-family:var(--font-display);font-style:italic;
    font-size:clamp(2rem,5vw,3rem);
    color:white;line-height:1.1;
    margin:0 0 1rem;
  }
  .hero-sub{font-size:.92rem;color:rgba(255,255,255,.55);line-height:1.7;margin:0 0 2.5rem;}
  .hero-actions{display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;}
  .hero-btn-main{
    display:inline-flex;align-items:center;gap:.5rem;
    background:var(--blue-vivid);color:white;
    font-size:.85rem;font-weight:600;
    padding:.7rem 1.75rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;
    box-shadow:0 2px 12px rgba(37,99,235,.45);
  }
  .hero-btn-main:hover{background:#1d4ed8;transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.45);}
  .hero-btn-sec{
    display:inline-flex;align-items:center;gap:.5rem;
    border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.75);
    font-size:.85rem;font-weight:600;
    padding:.7rem 1.5rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;
  }
  .hero-btn-sec:hover{border-color:rgba(255,255,255,.4);color:white;background:rgba(255,255,255,.06);}

  .section{max-width:1100px;margin:0 auto;padding:4rem 2rem;}
  .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;}
  .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;}

  .metric-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.5rem;
    text-align:center;
    box-shadow:var(--shadow-sm);
    transition:transform .2s,box-shadow .2s;
  }
  .metric-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);}
  .metric-num{font-family:var(--font-mono);font-size:2rem;font-weight:600;color:var(--navy);margin-bottom:.25rem;}
  .metric-label{font-size:.72rem;color:var(--text-3);font-weight:500;}

  .info-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;
    box-shadow:var(--shadow-sm);
  }

  .step-line{
    display:flex;flex-direction:column;gap:1.5rem;
    position:relative;
  }
  .step-item{display:flex;gap:1rem;align-items:flex-start;}
  .step-num{
    width:32px;height:32px;border-radius:50%;
    background:var(--navy);color:white;
    display:flex;align-items:center;justify-content:center;
    font-size:.75rem;font-weight:700;
    flex-shrink:0;margin-top:2px;
  }

  .cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:.75rem;}
  .cat-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-md);padding:1rem;
    transition:border-color .18s,box-shadow .18s;
    cursor:default;
  }
  .cat-card:hover{border-color:rgba(37,99,235,.25);box-shadow:var(--shadow-sm);}

  .cta-block{
    background:var(--navy);border-radius:var(--r-2xl);
    padding:3rem;text-align:center;
    position:relative;overflow:hidden;
  }
  .cta-block::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse 60% 60% at 50% 0%,rgba(37,99,235,.2),transparent 60%);
  }

  @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .5s ease forwards;}

  @media(max-width:768px){
    .grid-4{grid-template-columns:repeat(2,1fr);}
    .grid-2{grid-template-columns:1fr;}
    .grid-3{grid-template-columns:1fr;}
  }
</style>

{{-- Hero --}}
<div class="hero">
  <div class="hero-grid"></div>
  <div class="hero-content animate-in">
    <div class="hero-tag">
      <span class="hero-tag-dot"></span>
      Luanda · Angola · 2025
    </div>
    <h1 class="hero-title">
      1º Congresso de Psiquiatria<br>e Saúde Mental em Angola
    </h1>
    <p class="hero-sub">
      O maior evento científico de psiquiatria e saúde mental do país.<br>
      Junte-se a especialistas, investigadores e profissionais de saúde.
    </p>
    <div class="hero-actions">
      <a href="{{ route('inscricao.create') }}" class="hero-btn-main">
        Inscrever-me agora
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </a>
      @auth
        <a href="{{ route('participant.minha-inscricao') }}" class="hero-btn-sec">Ver minha inscrição</a>
      @else
        <a href="{{ route('login') }}" class="hero-btn-sec">Já estou inscrito</a>
      @endauth
    </div>
  </div>
</div>

{{-- Metrics --}}
<div class="section" style="padding-top:3rem;padding-bottom:2rem;">
  <div class="grid-4 animate-in" style="animation-delay:.1s;">
    @foreach([['20+','Oradores nacionais'],['2','Dias de congresso'],['15+','Sessões científicas'],['500+','Participantes esperados']] as [$n,$l])
      <div class="metric-card">
        <div class="metric-num">{{ $n }}</div>
        <div class="metric-label">{{ $l }}</div>
      </div>
    @endforeach
  </div>
</div>

{{-- About + Info --}}
<div class="section" style="padding-top:1rem;">
  <div class="grid-2 animate-in" style="animation-delay:.15s;">
    <div class="info-card">
      <p class="section-label" style="margin-bottom:.5rem;">Sobre o Evento</p>
      <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
                 color:var(--text-1);margin:0 0 1rem;">O que é o CPSA 2025?</h2>
      <p style="font-size:.85rem;color:var(--text-2);line-height:1.75;margin:0 0 .875rem;">
        O <strong>1º Congresso de Psiquiatria e Saúde Mental em Angola</strong> é um evento científico
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
          ['Data','2025 — Em breve',
           'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['Idioma','Português',
           'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
          ['Formato','Presencial e Online',
           'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2h-2'],
        ] as [$lbl,$val,$svgPath])
          <div style="display:flex;align-items:center;gap:.875rem;">
            <div style="width:36px;height:36px;border-radius:var(--r-sm);background:var(--surface);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="var(--blue-brand)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPath }}"/>
              </svg>
            </div>
            <div>
              <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
                        color:var(--text-3);margin:0 0 .15rem;">{{ $lbl }}</p>
              <p style="font-size:.82rem;font-weight:600;color:var(--text-1);margin:0;">{{ $val }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- Categories --}}
<div class="section" style="padding-top:0;">
  <div class="animate-in" style="animation-delay:.2s;">
    <p class="section-label" style="margin-bottom:.375rem;">Participação</p>
    <h2 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;
               color:var(--text-1);margin:0 0 1.5rem;">Categorias de Inscrição</h2>
    <div class="cat-grid">
      @foreach([
        ['Médico(a)',    'Especialistas e clínicos gerais',   '#1d4ed8','#eff6ff'],
        ['Enfermeiro(a)','Profissionais de enfermagem',       '#0f766e','#f0fdfa'],
        ['Psicólogo(a)', 'Psicólogos clínicos e investigadores','#6d28d9','#f5f3ff'],
        ['Estudante',    'Ciências da saúde',                '#b45309','#fffbeb'],
        ['Outro',        'Outros profissionais de saúde',    '#475569','#f8faff'],
      ] as [$lbl,$desc,$col,$bg])
        <div class="cat-card">
          <div style="width:10px;height:3px;border-radius:2px;background:{{ $col }};margin-bottom:.75rem;"></div>
          <p style="font-size:.82rem;font-weight:700;color:var(--text-1);margin:0 0 .25rem;">{{ $lbl }}</p>
          <p style="font-size:.7rem;color:var(--text-3);margin:0;line-height:1.5;">{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>

{{-- How it works --}}
<div class="section" style="padding-top:0;">
  <div class="grid-2 animate-in" style="animation-delay:.25s;">
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
              <p style="font-size:.83rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;">{{ $t }}</p>
              <p style="font-size:.78rem;color:var(--text-3);margin:0;line-height:1.5;">{{ $d }}</p>
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
          Inscreva-se agora e faça parte deste marco histórico para
          a saúde mental em Angola.
        </p>
        <a href="{{ route('inscricao.create') }}" class="hero-btn-main">
          Fazer inscrição
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
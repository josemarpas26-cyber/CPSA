<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','CPSM 2026') — Iº Congresso de Psiquiatria e Saúde Mental em Angola</title>
  <meta name="description" content="@yield('description', 'Congresso de Psiquiatria e Saúde Mental em Angola — Luanda, 2026')">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/faviconC.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/faviconC.png') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('head')
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
      --navy:#0b1f4a; --navy-mid:#102668; --blue:#1a3a8f;
      --blue-brand:#1d4ed8; --blue-vivid:#2563eb;
      --teal:#0f766e; --teal-light:#14b8a6;
      --success:#059669; --warning:#b45309; --danger:#be123c;
      --surface:#f4f7ff; --card:#ffffff;
      --card-border:rgba(26,58,143,.09); --divider:rgba(26,58,143,.07);
      --text-1:#0b1f4a; --text-2:#3d5080; --text-3:#7a8fb5; --text-4:#b0bdd8;
      --shadow-sm:0 1px 4px rgba(11,31,74,.07),0 0 0 1px rgba(11,31,74,.04);
      --shadow-md:0 4px 20px rgba(11,31,74,.09),0 1px 4px rgba(11,31,74,.05);
      --shadow-lg:0 8px 40px rgba(11,31,74,.13),0 2px 8px rgba(11,31,74,.06);
      --r-sm:8px; --r-md:12px; --r-lg:16px; --r-xl:20px; --r-2xl:24px;
      --font-body:'DM Sans',sans-serif;
      --font-display:'Instrument Serif',serif;
      --font-mono:'JetBrains Mono',monospace;
    }

    *, *::before, *::after { box-sizing: border-box; }

    html, body {
      overflow-x: hidden;
      max-width: 100%;
    }

    body {
      font-family: var(--font-body);
      background: var(--surface);
      color: var(--text-1);
      -webkit-font-smoothing: antialiased;
      margin: 0;
    }

    /* ── Navbar ──────────────────────────────── */
    #navbar {
      position: sticky;
      top: 0;
      z-index: 1000;
      height: 60px;
      background: rgba(11,31,74,.97);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(255,255,255,.06);
      display: flex;
      align-items: center;
      padding: 0 1.25rem;
    }

    .navbar-inner {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      gap: .625rem;
      text-decoration: none;
      flex-shrink: 0;
    }

    .navbar-brand-text {
      font-family: var(--font-display);
      font-style: italic;
      font-size: .95rem;
      color: white;
      line-height: 1.1;
    }

    .navbar-brand-sub {
      font-size: .58rem;
      color: rgba(255,255,255,.35);
      font-family: var(--font-body);
      font-weight: 500;
      letter-spacing: .06em;
      text-transform: uppercase;
      font-style: normal;
    }

    .navbar-spacer { flex: 1; }

    .navbar-link {
      font-size: .8rem;
      font-weight: 500;
      color: rgba(255,255,255,.55);
      text-decoration: none;
      transition: color .18s;
      white-space: nowrap;
    }
    .navbar-link:hover  { color: rgba(255,255,255,.9); }
    .navbar-link.active { color: rgba(255,255,255,.95); }

    .navbar-btn {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      font-size: .78rem;
      font-weight: 600;
      padding: .45rem .875rem;
      border-radius: var(--r-sm);
      text-decoration: none;
      transition: all .2s;
      white-space: nowrap;
      flex-shrink: 0;
    }
    .navbar-btn-outline {
      border: 1px solid rgba(255,255,255,.15);
      color: rgba(255,255,255,.75);
      background: transparent;
    }
    .navbar-btn-outline:hover {
      border-color: rgba(255,255,255,.35);
      color: white;
      background: rgba(255,255,255,.06);
    }
    .navbar-btn-solid {
      background: var(--blue-vivid);
      color: white;
      border: 1px solid transparent;
      box-shadow: 0 1px 4px rgba(37,99,235,.4);
    }
    .navbar-btn-solid:hover {
      background: #1d4ed8;
      box-shadow: 0 4px 12px rgba(37,99,235,.4);
      transform: translateY(-1px);
    }

    /* Links desktop — escondidos em mobile */
    .navbar-nav-links {
      display: flex;
      align-items: center;
      gap: 1.25rem;
    }

    /* ── Menu mobile toggle ───────────────────── */
    #menu-btn {
      display: none; /* só aparece em mobile via media query */
      align-items: center;
      justify-content: center;
      background: transparent;
      border: 1px solid rgba(255,255,255,.2);
      border-radius: var(--r-sm);
      padding: .45rem;
      color: rgba(255,255,255,.8);
      cursor: pointer;
      transition: all .18s;
      flex-shrink: 0;
      /* área de toque maior */
      min-width: 38px;
      min-height: 38px;
      -webkit-tap-highlight-color: transparent;
    }
    #menu-btn:hover,
    #menu-btn:focus {
      border-color: rgba(255,255,255,.4);
      color: white;
      background: rgba(255,255,255,.08);
      outline: none;
    }
    #menu-btn:active {
      background: rgba(255,255,255,.15);
    }

    /* ── Mobile nav drawer ───────────────────── */
    #mobile-menu {
      /* escondido por defeito */
      position: fixed;
      top: 60px;
      left: 0;
      right: 0;
      z-index: 999;
      background: rgba(8,22,56,.98);
      border-bottom: 1px solid rgba(255,255,255,.08);
      padding: .875rem 1.25rem 1.25rem;
      /* Animação suave */
      transform: translateY(-8px);
      opacity: 0;
      pointer-events: none;
      transition: transform .22s ease, opacity .22s ease;
    }
    #mobile-menu.open {
      transform: translateY(0);
      opacity: 1;
      pointer-events: all;
    }

    .mobile-nav {
      display: flex;
      flex-direction: column;
      gap: .125rem;
    }

    .mobile-nav-link {
      display: block;
      padding: .75rem 1rem;
      border-radius: var(--r-sm);
      font-size: .875rem;
      font-weight: 500;
      color: rgba(255,255,255,.7);
      text-decoration: none;
      transition: background .15s, color .15s;
      -webkit-tap-highlight-color: transparent;
    }
    .mobile-nav-link:hover,
    .mobile-nav-link:focus {
      background: rgba(255,255,255,.08);
      color: white;
    }
    .mobile-nav-link.active {
      background: rgba(37,99,235,.28);
      color: rgba(255,255,255,.95);
    }

    .mobile-nav-divider {
      border: none;
      border-top: 1px solid rgba(255,255,255,.08);
      margin: .5rem 0;
    }

    /* Botão Inscrever-me no menu mobile */
    .mobile-nav-cta {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
      margin-top: .5rem;
      padding: .8rem 1rem;
      border-radius: var(--r-sm);
      background: var(--blue-vivid);
      color: white;
      font-size: .875rem;
      font-weight: 700;
      text-decoration: none;
      transition: background .15s;
      -webkit-tap-highlight-color: transparent;
    }
    .mobile-nav-cta:hover { background: #1d4ed8; }

    /* Overlay escuro por baixo do menu */
    #menu-overlay {
      display: none;
      position: fixed;
      inset: 0;
      top: 60px;
      background: rgba(0,0,0,.4);
      z-index: 998;
    }
    #menu-overlay.open { display: block; }

    /* ── Flash ───────────────────────────────── */
    .flash {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .75rem 1.25rem;
      font-size: .8rem;
      font-weight: 500;
      border-bottom: 1px solid transparent;
    }
    .flash-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .flash.success { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .flash.success .flash-dot { background: #16a34a; }
    .flash.error   { background: #fff1f2; color: #9f1239; border-color: #fecdd3; }
    .flash.error   .flash-dot { background: #e11d48; }
    .flash.info    { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .flash.info    .flash-dot { background: #2563eb; }
    .flash.warning { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .flash.warning .flash-dot { background: #d97706; }

    /* ── Main ────────────────────────────────── */
    #page-content { min-height: calc(100vh - 60px - 80px); }

    /* ── Footer ──────────────────────────────── */
    #footer {
      background: var(--navy);
      padding: 1.5rem 1.25rem;
      border-top: 1px solid rgba(255,255,255,.05);
    }
    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      gap: .75rem;
      text-align: center;
    }
    @media (min-width: 640px) {
      .footer-inner { flex-direction: row; text-align: left; }
    }
    .footer-text { font-size: .73rem; color: rgba(255,255,255,.3); }
    .footer-links {
      display: flex;
      align-items: center;
      gap: .75rem;
      font-size: .72rem;
      flex-wrap: wrap;
      justify-content: center;
    }
    .footer-links a { color: rgba(255,255,255,.3); text-decoration: none; transition: color .18s; }
    .footer-links a:hover { color: rgba(255,255,255,.6); }
    .footer-divider { color: rgba(255,255,255,.15); margin: 0 .25rem; }

    /* ── Animations ──────────────────────────── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .animate-in { opacity: 0; animation: fadeUp .5s ease forwards; }

    /* ── Shared components ───────────────────── */
    .card { background: var(--card); border: 1px solid var(--card-border); border-radius: var(--r-lg); box-shadow: var(--shadow-sm); }
    .form-label { display: block; font-size: .73rem; font-weight: 600; color: var(--text-2); margin-bottom: .375rem; }
    .form-input {
      width: 100%; background: white; border: 1px solid var(--card-border);
      border-radius: var(--r-sm); padding: .55rem .8rem; font-size: .83rem;
      font-family: var(--font-body); color: var(--text-1); outline: none;
      transition: border-color .18s, box-shadow .18s;
    }
    .form-input:focus { border-color: var(--blue-vivid); box-shadow: 0 0 0 3px rgba(37,99,235,.12); }
    .form-input::placeholder { color: var(--text-4); }
    .form-error { font-size: .72rem; color: var(--danger); margin-top: .3rem; }
    .section-label { font-size: .63rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--text-3); }
    .heading { font-family: var(--font-display); font-style: italic; color: var(--text-1); }
    .btn-primary {
      display: inline-flex; align-items: center; gap: .5rem;
      background: var(--blue-brand); color: white; font-size: .82rem;
      font-weight: 600; padding: .6rem 1.25rem; border-radius: var(--r-sm);
      border: none; cursor: pointer; text-decoration: none; transition: all .2s;
      box-shadow: 0 1px 3px rgba(29,78,216,.3);
    }
    .btn-primary:hover { background: var(--navy-mid); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(29,78,216,.3); }

    *::-webkit-scrollbar { width: 5px; height: 5px; }
    *::-webkit-scrollbar-track { background: transparent; }
    *::-webkit-scrollbar-thumb { background: rgba(26,58,143,.15); border-radius: 99px; }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 767px) {
      .navbar-nav-links { display: none !important; }
      .navbar-btn-desktop { display: none !important; }
      #menu-btn { display: inline-flex !important; }
      #navbar { padding: 0 1rem; }
    }

    @media (min-width: 768px) {
      #mobile-menu { display: none !important; }
      #menu-overlay { display: none !important; }
    }
  </style>
</head>
<body>

<nav id="navbar">
  <div class="navbar-inner">

    {{-- Brand --}}
    <a href="{{ route('home') }}" class="navbar-brand">
      <img src="/logo.png" style="width:56px;height:auto;" alt="CPSM 2026">
      <div>
        <div class="navbar-brand-text">CPSM 2026</div>
        <div class="navbar-brand-sub">Psiquiatria · Angola</div>
      </div>
    </a>

    <div class="navbar-spacer"></div>

    {{-- Navegação principal — desktop --}}
    <div class="navbar-nav-links">
      <a href="{{ route('home') }}"
         class="navbar-link {{ request()->routeIs('home') ? 'active' : '' }}">
        Início
      </a>
      <a href="{{ route('speakers.index') }}"
         class="navbar-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}">
        Palestrantes
      </a>
      <a href="{{ route('programa.index') }}"
         class="navbar-link {{ request()->routeIs('programa.*') ? 'active' : '' }}">
        Programa
      </a>
      <a href="{{ route('galeria.index') }}"
         class="navbar-link {{ request()->routeIs('galeria.*') ? 'active' : '' }}">
        Galeria
      </a>
    </div>

    {{-- Acções desktop --}}
    @auth
      <span class="navbar-link navbar-btn-desktop" style="color:rgba(255,255,255,.55);">
        {{ Auth::user()->name }}
      </span>
      <form method="POST" action="{{ route('logout') }}" style="display:contents;">
        @csrf
        <button type="submit"
                class="navbar-btn navbar-btn-outline navbar-btn-desktop"
                style="font-family:var(--font-body);cursor:pointer;">
          Sair
        </button>
      </form>
    @else
      <a href="{{ route('login') }}" class="navbar-btn navbar-btn-outline navbar-btn-desktop">Entrar</a>
      <a href="{{ route('inscricao.create') }}" class="navbar-btn navbar-btn-solid navbar-btn-desktop">Inscrever-me</a>
    @endauth

    {{-- Botão hamburger — só mobile --}}
    <button id="menu-btn"
            aria-label="Abrir menu"
            aria-expanded="false"
            aria-controls="mobile-menu">
      {{-- Ícone hamburger --}}
      <svg id="icon-menu" width="18" height="18" fill="none" viewBox="0 0 24 24"
           stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
      {{-- Ícone X --}}
      <svg id="icon-close" width="18" height="18" fill="none" viewBox="0 0 24 24"
           stroke="currentColor" stroke-width="2" style="display:none;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

  </div>
</nav>

{{-- Overlay (clique fora fecha o menu) --}}
<div id="menu-overlay" aria-hidden="true"></div>

{{-- Menu mobile --}}
<div id="mobile-menu" role="dialog" aria-label="Menu de navegação" aria-modal="true">
  <nav class="mobile-nav">

    <a href="{{ route('home') }}"
       class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
      Início
    </a>
    <a href="{{ route('speakers.index') }}"
       class="mobile-nav-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}">
      Palestrantes
    </a>
    <a href="{{ route('programa.index') }}"
       class="mobile-nav-link {{ request()->routeIs('programa.*') ? 'active' : '' }}">
      Programa
    </a>
    <a href="{{ route('galeria.index') }}"
       class="mobile-nav-link {{ request()->routeIs('galeria.*') ? 'active' : '' }}">
      Galeria
    </a>

    <hr class="mobile-nav-divider">

    @auth
      <span class="mobile-nav-link" style="cursor:default;color:rgba(255,255,255,.4);font-size:.8rem;">
        {{ Auth::user()->name }}
      </span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="mobile-nav-link"
                style="width:100%;text-align:left;background:none;border:none;
                       cursor:pointer;font-family:var(--font-body);font-size:.875rem;">
          Terminar sessão
        </button>
      </form>
    @else
      <a href="{{ route('login') }}" class="mobile-nav-link">
        Entrar no painel
      </a>
      <a href="{{ route('inscricao.create') }}" class="mobile-nav-cta">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
        </svg>
        Inscrever-me agora
      </a>
    @endauth

  </nav>
</div>

{{-- Flash messages --}}
@if(session('success'))
  <div class="flash success"><span class="flash-dot"></span>{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="flash error"><span class="flash-dot"></span>{{ session('error') }}</div>
@endif
@if(session('info'))
  <div class="flash info"><span class="flash-dot"></span>{{ session('info') }}</div>
@endif
@if(session('warning'))
  <div class="flash warning"><span class="flash-dot"></span>{{ session('warning') }}</div>
@endif

<div id="page-content">
  @yield('content')
</div>

<footer id="footer">
  <div class="footer-inner">
    <p class="footer-text">
      © {{ date('Y') }} Iº Congresso de Psiquiatria e Saúde Mental em Angola
      <span class="footer-divider">·</span>
      Luanda, República de Angola
    </p>
    <div class="footer-links">
      <a href="mailto:geral@cpsa2025.ao">geral@cpsa2025.ao</a>
      <span class="footer-divider">·</span>
      <a href="{{ route('login') }}">Painel</a>
    </div>
  </div>
</footer>

<script>
(function () {
  const btn     = document.getElementById('menu-btn');
  const menu    = document.getElementById('mobile-menu');
  const overlay = document.getElementById('menu-overlay');
  const iconMenu  = document.getElementById('icon-menu');
  const iconClose = document.getElementById('icon-close');

  if (!btn || !menu) return;

  function openMenu() {
    menu.classList.add('open');
    overlay.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
    btn.setAttribute('aria-label', 'Fechar menu');
    iconMenu.style.display  = 'none';
    iconClose.style.display = 'block';
    document.body.style.overflow = 'hidden'; /* evita scroll do fundo */
  }

  function closeMenu() {
    menu.classList.remove('open');
    overlay.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
    btn.setAttribute('aria-label', 'Abrir menu');
    iconMenu.style.display  = 'block';
    iconClose.style.display = 'none';
    document.body.style.overflow = '';
  }

  function toggleMenu() {
    menu.classList.contains('open') ? closeMenu() : openMenu();
  }

  /* Clique no botão */
  btn.addEventListener('click', function (e) {
    e.stopPropagation();
    toggleMenu();
  });

  /* Clique no overlay fecha o menu */
  overlay.addEventListener('click', closeMenu);

  /* Tecla Escape fecha o menu */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && menu.classList.contains('open')) closeMenu();
  });

  /* Fechar ao navegar (links internos) */
  menu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      /* Pequeno delay para não bloquear a navegação */
      setTimeout(closeMenu, 80);
    });
  });

  /* Fechar se o ecrã passar para desktop */
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768 && menu.classList.contains('open')) {
      closeMenu();
    }
  });
}());
</script>

@stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','CPSM 2026') — Iº Congresso de Psiquiatria e Saúde Mental em Angola</title>
  <meta name="description" content="@yield('description', 'Congresso de Psiquiatria e Saúde Mental em Angola — Luanda, 2026')">
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
    *,*::before,*::after{box-sizing:border-box;}
    body{font-family:var(--font-body);background:var(--surface);color:var(--text-1);
         -webkit-font-smoothing:antialiased;margin:0;}

    /* ── Navbar ──────────────────────────────── */
    #navbar {
      position:sticky; top:0; z-index:100;
      height:60px;
      background:rgba(11,31,74,.97);
      backdrop-filter:blur(16px);
      -webkit-backdrop-filter:blur(16px);
      border-bottom:1px solid rgba(255,255,255,.06);
      display:flex; align-items:center;
      padding:0 2rem;
    }
    .navbar-inner {
      width:100%; max-width:1200px; margin:0 auto;
      display:flex; align-items:center; gap:1.5rem;
    }
    .navbar-brand {
      display:flex; align-items:center; gap:.75rem;
      text-decoration:none;
    }
    .navbar-brand-mark svg { color:white; }
    .navbar-brand-text {
      font-family:var(--font-display);
      font-style:italic;
      font-size:.95rem;
      color:white;
      line-height:1.1;
    }
    .navbar-brand-sub {
      font-size:.6rem;
      color:rgba(255,255,255,.35);
      font-family:var(--font-body);
      font-weight:500;
      letter-spacing:.06em;
      text-transform:uppercase;
      font-style:normal;
    }
    .navbar-spacer { flex:1; }
    .navbar-link {
      font-size:.8rem; font-weight:500;
      color:rgba(255,255,255,.55);
      text-decoration:none;
      transition:color .18s;
    }
    .navbar-link:hover { color:rgba(255,255,255,.9); }
    .navbar-link.active { color:rgba(255,255,255,.95); }
    .navbar-btn {
      display:inline-flex; align-items:center; gap:.5rem;
      font-size:.78rem; font-weight:600;
      padding:.45rem 1rem;
      border-radius:var(--r-sm);
      text-decoration:none;
      transition:all .2s;
    }
    .navbar-btn-outline {
      border:1px solid rgba(255,255,255,.15);
      color:rgba(255,255,255,.75);
      background:transparent;
    }
    .navbar-btn-outline:hover {
      border-color:rgba(255,255,255,.35);
      color:white;
      background:rgba(255,255,255,.06);
    }
    .navbar-btn-solid {
      background:var(--blue-vivid);
      color:white;
      border:1px solid transparent;
      box-shadow:0 1px 4px rgba(37,99,235,.4);
    }
    .navbar-btn-solid:hover {
      background:#1d4ed8;
      box-shadow:0 4px 12px rgba(37,99,235,.4);
      transform:translateY(-1px);
    }

    /* ── Menu mobile toggle ───────────────────── */
    #menu-btn {
      display:none;
      align-items:center; justify-content:center;
      background:transparent;
      border:1px solid rgba(255,255,255,.15);
      border-radius:var(--r-sm);
      padding:.4rem;
      color:rgba(255,255,255,.7);
      cursor:pointer;
      transition:all .18s;
    }
    #menu-btn:hover {
      border-color:rgba(255,255,255,.35);
      color:white;
      background:rgba(255,255,255,.06);
    }
    #menu-btn svg { width:18px; height:18px; }

    /* ── Mobile nav drawer ───────────────────── */
    #mobile-menu {
      display:none;
      position:fixed;
      top:60px; left:0; right:0;
      background:rgba(11,31,74,.99);
      border-bottom:1px solid rgba(255,255,255,.07);
      padding:1rem 1.5rem 1.25rem;
      z-index:99;
    }
    #mobile-menu.open { display:block; }
    .mobile-nav {
      display:flex; flex-direction:column; gap:.25rem;
    }
    .mobile-nav-link {
      display:block;
      padding:.6rem .85rem;
      border-radius:var(--r-sm);
      font-size:.83rem; font-weight:500;
      color:rgba(255,255,255,.65);
      text-decoration:none;
      transition:all .15s;
    }
    .mobile-nav-link:hover {
      background:rgba(255,255,255,.07);
      color:white;
    }
    .mobile-nav-link.active {
      background:rgba(37,99,235,.25);
      color:rgba(255,255,255,.95);
    }
    .mobile-nav-divider {
      border:none;
      border-top:1px solid rgba(255,255,255,.07);
      margin:.5rem 0;
    }

    /* ── Flash ───────────────────────────────── */
    .flash{display:flex;align-items:center;gap:.75rem;
           padding:.75rem 2rem;font-size:.8rem;font-weight:500;
           border-bottom:1px solid transparent;}
    .flash-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0;}
    .flash.success{background:#f0fdf4;color:#166534;border-color:#bbf7d0;}
    .flash.success .flash-dot{background:#16a34a;}
    .flash.error{background:#fff1f2;color:#9f1239;border-color:#fecdd3;}
    .flash.error .flash-dot{background:#e11d48;}

    /* ── Main ────────────────────────────────── */
    #page-content{min-height:calc(100vh - 60px - 80px);}

    /* ── Footer ──────────────────────────────── */
    #footer {
      background:var(--navy);
      padding:1.5rem 2rem;
      border-top:1px solid rgba(255,255,255,.05);
    }
    .footer-inner {
      max-width:1200px; margin:0 auto;
      display:flex; flex-direction:column;
      align-items:center; justify-content:space-between;
      gap:.75rem;
    }
    @media (min-width:640px) {
      .footer-inner { flex-direction:row; }
    }
    .footer-text {
      font-size:.73rem;
      color:rgba(255,255,255,.3);
      font-weight:400;
    }
    .footer-links {
      display:flex; align-items:center; gap:.75rem;
      font-size:.72rem;
      color:rgba(255,255,255,.25);
    }
    .footer-links a {
      color:rgba(255,255,255,.3);
      text-decoration:none;
      transition:color .18s;
    }
    .footer-links a:hover { color:rgba(255,255,255,.6); }
    .footer-divider {
      display:inline-block;
      margin:0 .5rem;
      color:rgba(255,255,255,.15);
    }

    /* ── Animations ──────────────────────────── */
    @keyframes fadeUp{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
    .animate-in{opacity:0;animation:fadeUp .5s ease forwards;}

    /* ── Shared ──────────────────────────────── */
    .card{background:var(--card);border:1px solid var(--card-border);
          border-radius:var(--r-lg);box-shadow:var(--shadow-sm);}
    .form-label{display:block;font-size:.73rem;font-weight:600;
                color:var(--text-2);margin-bottom:.375rem;}
    .form-input{width:100%;background:white;border:1px solid var(--card-border);
                border-radius:var(--r-sm);padding:.55rem .8rem;font-size:.83rem;
                font-family:var(--font-body);color:var(--text-1);outline:none;
                transition:border-color .18s,box-shadow .18s;}
    .form-input:focus{border-color:var(--blue-vivid);
                      box-shadow:0 0 0 3px rgba(37,99,235,.12);}
    .form-input::placeholder{color:var(--text-4);}
    .form-error{font-size:.72rem;color:var(--danger);margin-top:.3rem;}
    .section-label{font-size:.63rem;font-weight:700;letter-spacing:.12em;
                   text-transform:uppercase;color:var(--text-3);}
    .heading{font-family:var(--font-display);font-style:italic;color:var(--text-1);}
    .btn-primary{display:inline-flex;align-items:center;gap:.5rem;
                 background:var(--blue-brand);color:white;font-size:.82rem;
                 font-weight:600;padding:.6rem 1.25rem;border-radius:var(--r-sm);
                 border:none;cursor:pointer;text-decoration:none;transition:all .2s;
                 box-shadow:0 1px 3px rgba(29,78,216,.3);}
    .btn-primary:hover{background:var(--navy-mid);transform:translateY(-1px);
                       box-shadow:0 4px 12px rgba(29,78,216,.3);}
    *::-webkit-scrollbar{width:5px;}
    *::-webkit-scrollbar-track{background:transparent;}
    *::-webkit-scrollbar-thumb{background:rgba(26,58,143,.15);border-radius:99px;}

    /* ── Responsive nav ──────────────────────── */
    @media (max-width:767px) {
      .navbar-nav-links { display:none; }
      #menu-btn { display:inline-flex; }
    }
  </style>
</head>
<body>

<nav id="navbar">
  <div class="navbar-inner">

    {{-- Brand --}}
    <a href="{{ route('home') }}" class="navbar-brand">
      <div class="navbar-brand-mark">
        <img src="/logo.png" style="width:75px;height:auto;" alt="CPSM 2026">
      </div>
      <div>
        <div class="navbar-brand-text">CPSM 2026</div>
        <div class="navbar-brand-sub">Psiquiatria · Angola</div>
      </div>
    </a>

    <div class="navbar-spacer"></div>

    {{-- Navegação principal (desktop) --}}
    <div class="navbar-nav-links" style="display:flex;align-items:center;gap:1.25rem;">
      <a href="{{ route('home') }}"
         class="navbar-link {{ request()->routeIs('home') ? 'active' : '' }}">
        Início
      </a>
      <a href="{{ route('speakers.index') }}"
         class="navbar-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}">
        Palestrantes
      </a>
      <a href="#programa" class="navbar-link">Programa</a>
      <a href="#local" class="navbar-link">Galeria</a>
    </div>

    {{-- Acções --}}
    @auth
      <span class="navbar-link hidden sm:block" style="color:rgba(255,255,255,.55);">{{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:contents;">
        @csrf
        <button type="submit" class="navbar-btn navbar-btn-outline" style="font-family:var(--font-body);">
          Sair
        </button>
      </form>
    @else
      <a href="{{ route('login') }}" class="navbar-btn navbar-btn-outline">Entrar</a>
      <a href="{{ route('inscricao.create') }}" class="navbar-btn navbar-btn-solid">Inscrever-me</a>
    @endauth

    {{-- Botão menu mobile --}}
    <button id="menu-btn" aria-label="Menu" aria-expanded="false" aria-controls="mobile-menu">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

  </div>
</nav>

{{-- Menu mobile --}}
<div id="mobile-menu" role="navigation" aria-label="Menu mobile">
  <nav class="mobile-nav">
    <a href="{{ route('home') }}"
       class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
      Início
    </a>
    <a href="{{ route('speakers.index') }}"
       class="mobile-nav-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}">
      Palestrantes
    </a>
    <a href="#programa" class="mobile-nav-link">Programa</a>
    <a href="#local" class="mobile-nav-link">Local</a>
    <hr class="mobile-nav-divider">
    @auth
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="mobile-nav-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:var(--font-body);">
          Sair ({{ Auth::user()->name }})
        </button>
      </form>
    @else
      <a href="{{ route('login') }}" class="mobile-nav-link">Entrar</a>
      <a href="{{ route('inscricao.create') }}" class="mobile-nav-link active">Inscrever-me</a>
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
      <span>·</span>
      {{-- Link discreto para o painel — não visível como botão de login --}}
      <a href="{{ route('login') }}">Painel</a>
    </div>
  </div>
</footer>

<script>
  // Toggle menu mobile
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  menuBtn?.addEventListener('click', function () {
    const isOpen = mobileMenu.classList.toggle('open');
    this.setAttribute('aria-expanded', String(isOpen));

    // Trocar ícone hamburger ↔ X
    this.innerHTML = isOpen
      ? `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
         </svg>`
      : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
         </svg>`;
  });

  // Fechar menu ao clicar em âncoras internas
  mobileMenu?.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      menuBtn?.setAttribute('aria-expanded', 'false');
      if (menuBtn) menuBtn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>`;
    });
  });
</script>

@stack('scripts')
</body>
</html>
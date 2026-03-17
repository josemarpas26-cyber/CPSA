<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','CPSM 2026') — 1º Congresso de Psiquiatria e Saúde Mental em Angola</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
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
    .navbar-brand-mark {
      width:32px; height:32px; border-radius:6px;
      background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0;
      box-shadow:0 2px 8px rgba(37,99,235,.5);
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
      text-align:center;
      border-top:1px solid rgba(255,255,255,.05);
    }
    .footer-text {
      font-size:.73rem;
      color:rgba(255,255,255,.3);
      font-weight:400;
    }
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
  </style>
</head>
<body>

<nav id="navbar">
  <div class="navbar-inner">
    <a href="{{ route('home') }}" class="navbar-brand">
      <div class="navbar-brand-mark">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
        </svg>
      </div>
      <div>
        <div class="navbar-brand-text">CPSM 2026</div>
        <div class="navbar-brand-sub">Psiquiatria · Angola</div>
      </div>
    </a>
    <div class="navbar-spacer"></div>
    @auth
      <span class="navbar-link hidden sm:block">{{ Auth::user()->name }}</span>
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
  </div>
</nav>

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
  <p class="footer-text">
    © {{ date('Y') }} 1º Congresso de Psiquiatria e Saúde Mental em Angola
    <span class="footer-divider">·</span>
    Luanda, República de Angola
    <span class="footer-divider">·</span>
    Todos os direitos reservados
  </p>
</footer>

</body>
</html>
<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Painel') — CPSM 2026</title>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/faviconC.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/faviconC.png') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
      --navy:#0b1f4a; --navy-mid:#102668;
      --blue:#1a3a8f; --blue-brand:#1d4ed8;
      --blue-vivid:#2563eb; --blue-light:#3b82f6;
      --teal:#0f766e;
      --success:#059669; --success-bg:#ecfdf5;
      --warning:#b45309; --warning-bg:#fffbeb;
      --danger:#be123c;  --danger-bg:#fff1f2;
      --purple:#6d28d9;  --purple-bg:#f5f3ff;
      --surface:#f4f7ff; --card:#ffffff;
      --card-border:rgba(26,58,143,.09);
      --divider:rgba(26,58,143,.07);
      --text-1:#0b1f4a; --text-2:#3d5080;
      --text-3:#7a8fb5; --text-4:#b0bdd8;
      --shadow-sm:0 1px 4px rgba(11,31,74,.07),0 0 0 1px rgba(11,31,74,.04);
      --shadow-md:0 4px 20px rgba(11,31,74,.09),0 1px 4px rgba(11,31,74,.05);
      --shadow-lg:0 8px 40px rgba(11,31,74,.13),0 2px 8px rgba(11,31,74,.06);
      --r-sm:8px; --r-md:12px; --r-lg:16px; --r-xl:20px;
      --font-body:'DM Sans',sans-serif;
      --font-display:'Instrument Serif',serif;
      --font-mono:'JetBrains Mono',monospace;
      --sidebar-w:240px;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html, body { overflow-x: hidden; max-width: 100%; }

    body {
      font-family: var(--font-body);
      background: var(--surface);
      color: var(--text-1);
      -webkit-font-smoothing: antialiased;
      margin: 0;
    }

    /* ════════════════════════════════════════
       SIDEBAR
    ════════════════════════════════════════ */
    #sidebar {
      width: var(--sidebar-w);
      background: var(--navy);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 200;
      transition: transform .3s cubic-bezier(.4,0,.2,1);
      overflow-y: auto;
      overflow-x: hidden;
    }

    /* Mobile: sidebar escondida por defeito */
    @media (max-width: 768px) {
      #sidebar {
        transform: translateX(-100%);
        box-shadow: none;
      }
      #sidebar.sidebar-open {
        transform: translateX(0);
        box-shadow: 4px 0 32px rgba(0,0,0,.35);
      }
    }

    .sidebar-logo {
      padding: 1.25rem 1.5rem 1rem;
      border-bottom: 1px solid rgba(255,255,255,.06);
      flex-shrink: 0;
    }
    .sidebar-logo-mark {
      display: flex;
      align-items: center;
      gap: .75rem;
    }
    .sidebar-logo-name {
      font-family: var(--font-display);
      font-size: 1rem;
      color: white;
      font-style: italic;
    }
    .sidebar-logo-sub {
      font-size: .58rem;
      color: rgba(255,255,255,.35);
      font-weight: 500;
      letter-spacing: .06em;
      text-transform: uppercase;
      line-height: 1.4;
    }

    .sidebar-nav {
      flex: 1;
      overflow-y: auto;
      padding: 1rem .75rem;
    }
    .sidebar-section-label {
      font-size: .6rem;
      font-weight: 700;
      letter-spacing: .14em;
      text-transform: uppercase;
      color: rgba(255,255,255,.25);
      padding: 0 .625rem;
      margin-bottom: .375rem;
      margin-top: 1.25rem;
    }
    .sidebar-section-label:first-child { margin-top: 0; }

    .nav-item {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .625rem .75rem;
      border-radius: var(--r-sm);
      color: rgba(255,255,255,.55);
      font-size: .82rem;
      font-weight: 500;
      text-decoration: none;
      transition: all .18s ease;
      margin-bottom: 2px;
      position: relative;
    }
    .nav-item:hover {
      background: rgba(255,255,255,.07);
      color: rgba(255,255,255,.9);
    }
    .nav-item.active {
      background: rgba(37,99,235,.22);
      color: #93c5fd;
    }
    .nav-item.active::before {
      content: '';
      position: absolute;
      left: 0; top: 25%; bottom: 25%;
      width: 2px;
      background: var(--blue-light);
      border-radius: 0 2px 2px 0;
    }
    .nav-item-icon {
      width: 16px; height: 16px;
      flex-shrink: 0;
      opacity: .75;
    }
    .nav-item.active .nav-item-icon { opacity: 1; }
    .nav-badge {
      margin-left: auto;
      background: rgba(239,68,68,.18);
      color: #fca5a5;
      font-size: .63rem;
      font-weight: 700;
      padding: 1px 7px;
      border-radius: 99px;
    }

    .sidebar-footer {
      padding: .875rem .75rem;
      border-top: 1px solid rgba(255,255,255,.06);
      flex-shrink: 0;
    }
    .sidebar-avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg,#2563eb,#6d28d9);
      display: flex; align-items: center; justify-content: center;
      font-size: .75rem;
      font-weight: 700;
      color: white;
      flex-shrink: 0;
    }
    .sidebar-user-name {
      font-size: .8rem;
      font-weight: 600;
      color: rgba(255,255,255,.85);
      line-height: 1.2;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      flex: 1;
      min-width: 0;
    }
    .sidebar-user-role {
      font-size: .65rem;
      color: rgba(255,255,255,.35);
    }
    .sidebar-logout {
      background: none;
      border: none;
      cursor: pointer;
      color: rgba(255,255,255,.3);
      padding: 4px;
      border-radius: 4px;
      transition: color .15s;
      flex-shrink: 0;
    }
    .sidebar-logout:hover { color: rgba(255,255,255,.7); }

    /* ════════════════════════════════════════
       OVERLAY (mobile)
    ════════════════════════════════════════ */
    #sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.5);
      z-index: 199;
      backdrop-filter: blur(2px);
    }
    #sidebar-overlay.open { display: block; }

    /* ════════════════════════════════════════
       MAIN WRAPPER
    ════════════════════════════════════════ */
    #main-wrapper {
      margin-left: var(--sidebar-w);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      transition: margin-left .3s cubic-bezier(.4,0,.2,1);
    }

    @media (max-width: 768px) {
      #main-wrapper {
        margin-left: 0 !important;
      }
    }

    /* ════════════════════════════════════════
       TOPBAR
    ════════════════════════════════════════ */
    #topbar {
      position: sticky;
      top: 0;
      z-index: 100;
      height: 56px;
      background: rgba(244,247,255,.95);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--card-border);
      display: flex;
      align-items: center;
      padding: 0 1.25rem;
      gap: .875rem;
    }

    /* Botão hamburger — visível só em mobile */
    #sidebar-toggle {
      display: none;
      align-items: center;
      justify-content: center;
      background: var(--surface);
      border: 1px solid var(--card-border);
      border-radius: var(--r-sm);
      padding: .4rem;
      cursor: pointer;
      color: var(--text-2);
      transition: all .18s;
      flex-shrink: 0;
      min-width: 36px;
      min-height: 36px;
      -webkit-tap-highlight-color: transparent;
    }
    #sidebar-toggle:hover {
      background: white;
      border-color: rgba(26,58,143,.18);
      color: var(--text-1);
    }

    @media (max-width: 768px) {
      #sidebar-toggle { display: inline-flex !important; }
    }

    .topbar-title {
      font-family: var(--font-display);
      font-size: 1.05rem;
      color: var(--text-1);
      font-style: italic;
    }
    .topbar-date {
      margin-left: auto;
      font-size: .73rem;
      color: var(--text-3);
      font-weight: 500;
      white-space: nowrap;
    }

    /* ════════════════════════════════════════
       FLASH MESSAGES
    ════════════════════════════════════════ */
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
    .flash.success  { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .flash.success .flash-dot { background: #16a34a; }
    .flash.error    { background: #fff1f2; color: #9f1239; border-color: #fecdd3; }
    .flash.error   .flash-dot { background: #e11d48; }
    .flash.info     { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .flash.info    .flash-dot { background: #2563eb; }
    .flash.warning  { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .flash.warning .flash-dot { background: #d97706; }

    /* ════════════════════════════════════════
       CONTENT
    ════════════════════════════════════════ */
    #content {
      flex: 1;
      padding: 1.5rem 1.25rem;
    }

    /* ════════════════════════════════════════
       ANIMATIONS
    ════════════════════════════════════════ */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .animate-in { opacity: 0; animation: fadeUp .4s ease forwards; }

    /* ════════════════════════════════════════
       SHARED COMPONENTS
    ════════════════════════════════════════ */
    .card {
      background: var(--card);
      border: 1px solid var(--card-border);
      border-radius: var(--r-lg);
      box-shadow: var(--shadow-sm);
    }
    .section-label {
      font-size: .63rem;
      font-weight: 700;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--text-3);
    }
    .heading {
      font-family: var(--font-display);
      font-style: italic;
      color: var(--text-1);
    }
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 10px;
      border-radius: 99px;
      font-size: .7rem;
      font-weight: 600;
      letter-spacing: .02em;
      border: 1px solid;
    }
    .status-dot { width: 5px; height: 5px; border-radius: 50%; }
    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      background: var(--blue-brand);
      color: white;
      font-size: .8rem;
      font-weight: 600;
      padding: .5rem 1rem;
      border-radius: var(--r-sm);
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all .2s ease;
      box-shadow: 0 1px 3px rgba(29,78,216,.3);
    }
    .btn-primary:hover {
      background: var(--navy-mid);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(29,78,216,.3);
    }
    .btn-secondary {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      background: white;
      color: var(--text-2);
      font-size: .8rem;
      font-weight: 600;
      padding: .5rem 1rem;
      border-radius: var(--r-sm);
      border: 1px solid var(--card-border);
      cursor: pointer;
      text-decoration: none;
      transition: all .2s ease;
    }
    .btn-secondary:hover {
      background: var(--surface);
      color: var(--text-1);
      border-color: rgba(26,58,143,.18);
    }
    .form-label {
      display: block;
      font-size: .73rem;
      font-weight: 600;
      color: var(--text-2);
      margin-bottom: .375rem;
      letter-spacing: .01em;
    }
    .form-input {
      width: 100%;
      background: white;
      border: 1px solid var(--card-border);
      border-radius: var(--r-sm);
      padding: .5rem .75rem;
      font-size: .83rem;
      font-family: var(--font-body);
      color: var(--text-1);
      transition: border-color .18s, box-shadow .18s;
      outline: none;
    }
    .form-input:focus {
      border-color: var(--blue-vivid);
      box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }
    .form-input::placeholder { color: var(--text-4); }
    .form-error { font-size: .72rem; color: var(--danger); margin-top: .3rem; }

    .table-wrap { overflow-x: auto; }
    table.data-table { width: 100%; border-collapse: collapse; }
    table.data-table thead tr {
      background: var(--surface);
      border-bottom: 1px solid var(--divider);
    }
    table.data-table thead th {
      padding: .625rem 1rem;
      text-align: left;
    }
    table.data-table tbody tr {
      border-bottom: 1px solid var(--divider);
      transition: background .15s;
    }
    table.data-table tbody tr:last-child { border-bottom: none; }
    table.data-table tbody tr:hover { background: #f8faff; }
    table.data-table td { padding: .75rem 1rem; }

    .mono { font-family: var(--font-mono); }

    /* Scrollbar */
    *::-webkit-scrollbar { width: 5px; height: 5px; }
    *::-webkit-scrollbar-track { background: transparent; }
    *::-webkit-scrollbar-thumb { background: rgba(26,58,143,.15); border-radius: 99px; }
  </style>
</head>
<body>

{{-- Overlay (fecha sidebar ao clicar fora em mobile) --}}
<div id="sidebar-overlay"></div>

{{-- Sidebar --}}
<nav id="sidebar">
  <div class="sidebar-logo">
    <div class="sidebar-logo-mark">
      <img src="/logo.png" style="width:100px;height:auto;" alt="CPSM 2026">
      <div>
        <div class="sidebar-logo-name">CPSM 2026</div>
        <div class="sidebar-logo-sub">Painel<br>da Comissão</div>
      </div>
    </div>
  </div>

  <div class="sidebar-nav">

    <div class="sidebar-section-label">Principal</div>

    @php
      $navItems = [
        ['route' => 'admin.dashboard',         'label' => 'Dashboard',    'icon' => 'chart'],
        ['route' => 'admin.inscricoes.index',   'label' => 'Inscrições',   'icon' => 'list'],
        ['route' => 'admin.certificados.index', 'label' => 'Certificados', 'icon' => 'badge'],
      ];
      $exportItems = [
        ['route' => 'admin.exportar.excel',    'label' => 'Exportar Excel',    'icon' => 'download'],
        ['route' => 'admin.exportar.csv',      'label' => 'Exportar CSV',      'icon' => 'download'],
        ['route' => 'admin.exportar.presenca', 'label' => 'Lista de Presença', 'icon' => 'users'],
      ];
    @endphp

    @foreach($navItems as $item)
      <a href="{{ route($item['route']) }}"
         class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
        @if($item['icon'] === 'chart')
          <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
          </svg>
        @elseif($item['icon'] === 'list')
          <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
          </svg>
        @else
          <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
          </svg>
        @endif
        {{ $item['label'] }}
        @if($item['route'] === 'admin.inscricoes.index')
          @php $pending = \App\Models\Inscricao::where('status','pendente')->count(); @endphp
          @if($pending > 0)
            <span class="nav-badge">{{ $pending }}</span>
          @endif
        @endif
      </a>
    @endforeach

    <div class="sidebar-section-label">Exportação</div>
    @foreach($exportItems as $item)
      {{-- target="_blank" para abrir em nova aba --}}
      <a href="{{ route($item['route']) }}" target="_blank" rel="noopener" class="nav-item">
        <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        {{ $item['label'] }}
        {{-- Ícone indicador de nova aba --}}
        <svg style="margin-left:auto;opacity:.35;flex-shrink:0;" width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
      </a>
    @endforeach

    @if(Auth::user()?->hasRole('admin'))
      <div class="sidebar-section-label">Administração</div>

      <a href="{{ route('admin.cursos.index') }}"
         class="nav-item {{ request()->routeIs('admin.cursos.*') ? 'active' : '' }}">
        <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
        </svg>
        Cursos
      </a>

      <a href="{{ route('admin.speakers.index') }}"
         class="nav-item {{ request()->routeIs('admin.speakers.*') ? 'active' : '' }}">
        <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
        </svg>
        Palestrantes
      </a>

      <a href="{{ route('admin.galeria.index') }}"
         class="nav-item {{ request()->routeIs('admin.galeria.*') ? 'active' : '' }}">
        <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
        </svg>
        Galeria
      </a>

      <a href="{{ route('admin.programa.index') }}"
         class="nav-item {{ request()->routeIs('admin.programa.*') ? 'active' : '' }}">
        <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
        </svg>
        Programa
      </a>

      <a href="{{ route('admin.utilizadores.index') }}"
         class="nav-item {{ request()->routeIs('admin.utilizadores.*') ? 'active' : '' }}">
        <svg class="nav-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
        </svg>
        Utilizadores
      </a>
    @endif

  </div>

  <div class="sidebar-footer">
    <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem .625rem;">
      <div class="sidebar-avatar">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
      </div>
      <div style="flex:1;min-width:0;">
        <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
        <div class="sidebar-user-role">
          @if(Auth::user()->hasRole('admin')) Administrador @else Organizador @endif
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-logout" title="Terminar sessão">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
          </svg>
        </button>
      </form>
    </div>
  </div>
</nav>

{{-- Main --}}
<div id="main-wrapper">

  <header id="topbar">
    {{-- Botão hamburger — só mobile --}}
    <button id="sidebar-toggle" aria-label="Abrir menu" aria-expanded="false">
      <svg id="toggle-icon-menu" width="18" height="18" fill="none" viewBox="0 0 24 24"
           stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
      </svg>
      <svg id="toggle-icon-close" width="18" height="18" fill="none" viewBox="0 0 24 24"
           stroke="currentColor" stroke-width="2" style="display:none;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

    <span class="topbar-title">@yield('page-title', 'Dashboard')</span>

    <div class="topbar-date">
      {{ now()->format('d/m/Y · H:i') }}
    </div>
  </header>

  {{-- Flash --}}
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

  <main id="content">
    @yield('content')
  </main>
</div>

<script>
(function () {
  const sidebar  = document.getElementById('sidebar');
  const overlay  = document.getElementById('sidebar-overlay');
  const toggleBtn= document.getElementById('sidebar-toggle');
  const iconMenu = document.getElementById('toggle-icon-menu');
  const iconClose= document.getElementById('toggle-icon-close');

  if (!sidebar || !toggleBtn) return;

  function openSidebar() {
    sidebar.classList.add('sidebar-open');
    overlay.classList.add('open');
    toggleBtn.setAttribute('aria-expanded', 'true');
    toggleBtn.setAttribute('aria-label', 'Fechar menu');
    iconMenu.style.display  = 'none';
    iconClose.style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('sidebar-open');
    overlay.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
    toggleBtn.setAttribute('aria-label', 'Abrir menu');
    iconMenu.style.display  = 'block';
    iconClose.style.display = 'none';
    document.body.style.overflow = '';
  }

  toggleBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
  });

  overlay.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sidebar.classList.contains('sidebar-open')) closeSidebar();
  });

  /* Fechar ao navegar em mobile */
  sidebar.querySelectorAll('a.nav-item').forEach(function (link) {
    link.addEventListener('click', function () {
      if (window.innerWidth < 768) setTimeout(closeSidebar, 80);
    });
  });

  /* Fechar se o ecrã passar para desktop */
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768 && sidebar.classList.contains('sidebar-open')) {
      closeSidebar();
    }
  });
}());
</script>
</body>
</html>
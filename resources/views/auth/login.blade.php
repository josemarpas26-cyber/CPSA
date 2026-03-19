{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Acesso Restrito — CPSM 2026')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
  /* Sobrepõe o layout do app nesta página — fundo navy ocupa o ecrã todo */
  #login-scene {
    position: fixed; inset: 0; z-index: 50;
    font-family: 'DM Sans', sans-serif;
    background: #0b1f4a;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    overflow: hidden;
    -webkit-font-smoothing: antialiased;
  }

 /* Esconde estrutura global do layout na tela de login */
  body #navbar,
  body #mobile-menu,
  body #footer,
  body .flash {
    display: none !important;
  }

  body #page-content {
    min-height: 100vh !important;
  }


  /* ── Fundo decorativo ──────────────────────── */
  .lg-grid {
    position: absolute; inset: 0; pointer-events: none;
    background-image:
      linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size: 40px 40px;
  }
  .lg-glow {
    position: absolute; inset: 0; pointer-events: none;
    background:
      radial-gradient(ellipse 60% 50% at 20% 30%, rgba(37,99,235,.15), transparent 60%),
      radial-gradient(ellipse 50% 40% at 80% 70%, rgba(109,40,217,.10), transparent 60%);
  }

  /* ── Card ──────────────────────────────────── */
  .lg-card {
    position: relative; z-index: 1;
    width: 100%; max-width: 450px;
    margin: 0;
    background: #ffffff;
    border: 1px solid rgba(26,58,143,.09);
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(11,31,74,.18), 0 2px 8px rgba(11,31,74,.08);
    overflow: hidden;
    animation: lgFadeUp .45s ease both;
  }
  @keyframes lgFadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── Header ────────────────────────────────── */
  .lg-header {
    background: linear-gradient(135deg, #0b1f4a 0%, #1a3a8f 100%);
    padding: 0.5rem 2rem 1.75rem;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,.06);
  }
  
  .lg-icon {
  width: 52px; 
  height: 52px; 
  border-radius: 12px;
  background: linear-gradient(135deg, #2563eb, #6d28d9);
  display: flex; 
  align-items: center; 
  justify-content: center;
  margin: 1rem auto 1rem; /* Distanciamento de 1rem em cima, centralizado à esquerda/direita, e 1rem em baixo */
  box-shadow: 0 4px 16px rgba(37,99,235,.4);
}
  .lg-title {
    font-family: 'Instrument Serif', serif; font-style: italic;
    font-size: 1.35rem; color: white; margin-bottom: .25rem;
  }
  .lg-sub {
    font-size: .7rem; color: rgba(255,255,255,.4);
    font-weight: 500; letter-spacing: .04em;
  }
  .lg-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(190,18,60,.15); border: 1px solid rgba(190,18,60,.3);
    color: #fca5a5; font-size: .62rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    padding: .22rem .7rem; border-radius: 99px; margin-top: .7rem;
  }
  .lg-dot {
    width: 5px; height: 5px; border-radius: 50%; background: #f87171;
    animation: lgBlink 2s ease-in-out infinite;
  }
  @keyframes lgBlink { 0%,100%{opacity:1} 50%{opacity:.25} }

  /* ── Body ──────────────────────────────────── */
  .lg-body { padding: 1.75rem 2rem 2rem; }

  .lg-alert {
    display: flex; align-items: flex-start; gap: .6rem;
    border-radius: 10px; padding: .875rem 1rem;
    margin-bottom: 1.25rem;
    font-size: .78rem; line-height: 1.5;
  }
  .lg-alert svg { flex-shrink: 0; margin-top: 1px; }
  .lg-alert-error   { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }
  .lg-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

  .lg-group { margin-bottom: 1rem; }
  .lg-label {
    display: block; font-size: .72rem; font-weight: 600;
    color: #3d5080; margin-bottom: .35rem;
  }
  .lg-input {
    width: 100%; background: #f4f7ff;
    border: 1px solid rgba(26,58,143,.09);
    border-radius: 8px; padding: .6rem .875rem;
    font-size: .85rem; font-family: 'DM Sans', sans-serif;
    color: #0b1f4a; outline: none;
    transition: border-color .18s, box-shadow .18s, background .18s;
  }
  .lg-input:focus {
    border-color: #2563eb; background: white;
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  }
  .lg-input.is-error { border-color: #be123c; box-shadow: 0 0 0 3px rgba(190,18,60,.08); }
  .lg-input::placeholder { color: #b0bdd8; }

  .lg-input-wrap { position: relative; }
  .lg-input-wrap .lg-input { padding-right: 2.75rem; }
  .lg-toggle-pwd {
    position: absolute; right: .75rem; top: 50%;
    transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #7a8fb5; padding: 3px; transition: color .15s;
  }
  .lg-toggle-pwd:hover { color: #0b1f4a; }

  .lg-remember {
    display: flex; align-items: center; gap: .5rem;
    margin-bottom: 0; font-size: .78rem; color: #3d5080; cursor: pointer;
  }
  .lg-remember input { accent-color: #2563eb; width: 14px; height: 14px; cursor: pointer; }

  .lg-btn {
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    background: #0b1f4a; color: white;
    font-size: .85rem; font-weight: 600;
    padding: .72rem 1.25rem; border-radius: 8px; border: none;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    box-shadow: 0 2px 8px rgba(11,31,74,.25);
    transition: all .2s ease; margin-top: 1.25rem;
  }
  .lg-btn:hover:not(:disabled) {
    background: #0d2a60;
    box-shadow: 0 4px 16px rgba(11,31,74,.35);
    transform: translateY(-1px);
  }
  .lg-btn:active:not(:disabled) { transform: translateY(0); }
  .lg-btn:disabled { opacity: .6; cursor: not-allowed; }

  .lg-hint {
    font-size: .68rem; color: #b0bdd8;
    text-align: center; margin-top: .75rem; line-height: 1.5;
  }

  /* ── Footer ────────────────────────────────── */
  .lg-footer {
    padding: .875rem 2rem 1.25rem; text-align: center;
    border-top: 1px solid rgba(26,58,143,.07);
  }
  .lg-footer a {
    font-size: .72rem; color: #7a8fb5;
    text-decoration: none; transition: color .15s;
  }
  .lg-footer a:hover { color: #2563eb; }

  /* Honeypot */
  .hp-wrap {
    position: absolute !important; width: 1px !important; height: 1px !important;
    margin: -1px !important; padding: 0 !important; overflow: hidden !important;
    clip: rect(0,0,0,0) !important; white-space: nowrap !important;
    border: 0 !important; opacity: 0 !important; pointer-events: none !important;
  }

  @keyframes lgSpin { to { transform: rotate(360deg); } }
  
   @media (max-width: 520px) {
    #login-scene {
      padding: .75rem;
    }

    .lg-header {
      padding: 1.5rem 1.25rem 1.25rem;
    }

    .lg-body {
      padding: 1.25rem;
    }

    .lg-footer {
      padding: .875rem 1.25rem 1.1rem;
    }
  }

</style>
@endpush

@section('content')
<div id="login-scene">
  <div class="lg-grid"></div>
  <div class="lg-glow"></div>

  <div class="lg-card">

    {{-- Header --}}
    <div class="lg-header">
      <div class="lg-icon">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
      </div>
      <h1 class="lg-title">Painel Administrativo</h1>
      <p class="lg-sub">CPSM 2026 — Sistema de Gestão de Inscrições</p>
      <div><span class="lg-badge"><span class="lg-dot"></span>Acesso Restrito</span></div>
    </div>

    {{-- Body --}}
    <div class="lg-body">

      @if(session('success'))
        <div class="lg-alert lg-alert-success">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if(session('error') || $errors->any())
        <div class="lg-alert lg-alert-error">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
          </svg>
          <div>
            @if(session('error'))
              <p>{{ session('error') }}</p>
            @endif
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" id="loginForm" autocomplete="off">
        @csrf

        {{-- Honeypot --}}
        <div class="hp-wrap" aria-hidden="true">
          <label for="website">Deixe este campo vazio</label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off" value="">
        </div>

        <div class="lg-group">
          <label class="lg-label" for="email">Endereço de email</label>
          <input
            type="email" id="email" name="email"
            value="{{ old('email') }}"
            class="lg-input {{ $errors->has('email') ? 'is-error' : '' }}"
            placeholder="admin@cpsm2026.ao"
            autocomplete="username" required autofocus
          >
        </div>

        <div class="lg-group">
          <label class="lg-label" for="password">Senha</label>
          <div class="lg-input-wrap">
            <input
              type="password" id="password" name="password"
              class="lg-input {{ $errors->has('password') ? 'is-error' : '' }}"
              placeholder="••••••••••••"
              autocomplete="current-password" required
            >
            <button type="button" class="lg-toggle-pwd" id="togglePwd" aria-label="Mostrar/ocultar senha">
              <svg id="eyeIcon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </button>
          </div>
        </div>

        <label class="lg-remember">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          Manter sessão iniciada
        </label>

        <button type="submit" class="lg-btn" id="submitBtn">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
          </svg>
          Entrar no painel
        </button>

        <p class="lg-hint">Área exclusiva para a equipa de organização do CPSM 2026.</p>
      </form>
    </div>

    {{-- Footer --}}
    <div class="lg-footer">
      <a href="{{ route('home') }}">← Voltar ao site público</a>
    </div>

  </div>{{-- /lg-card --}}
</div>{{-- /login-scene --}}
@endsection

@push('scripts')
<script>
(function () {
  // Toggle mostrar/ocultar senha
  const btn = document.getElementById('togglePwd');
  const pwd = document.getElementById('password');
  if (btn && pwd) {
    const PATH_SHOW = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    const PATH_HIDE = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`;
    btn.addEventListener('click', function () {
      const hidden = pwd.type === 'password';
      pwd.type = hidden ? 'text' : 'password';
      document.getElementById('eyeIcon').innerHTML = hidden ? PATH_HIDE : PATH_SHOW;
      btn.setAttribute('aria-label', hidden ? 'Ocultar senha' : 'Mostrar senha');
    });
  }

  // Anti double-submit
  document.getElementById('loginForm').addEventListener('submit', function () {
    const b = document.getElementById('submitBtn');
    b.disabled = true;
    b.innerHTML = `<svg style="animation:lgSpin .7s linear infinite" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg> A verificar...`;
  });
}());
</script>
@endpush
@extends('layouts.app')
@section('title','Entrar')
@section('content')
<style>
  .auth-wrap{
    min-height:calc(100vh - 60px - 80px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:3rem 1rem;
    position:relative;
    overflow:hidden;
  }
  .auth-bg{
    position:absolute;inset:0;
    background:
      radial-gradient(ellipse 80% 50% at 50% -20%, rgba(37,99,235,.1) 0%, transparent 60%),
      radial-gradient(ellipse 50% 40% at 80% 80%, rgba(109,40,217,.06) 0%, transparent 60%);
    pointer-events:none;
  }
  .auth-card{
    width:100%;max-width:420px;
    background:var(--card);
    border:1px solid var(--card-border);
    border-radius:var(--r-2xl);
    box-shadow:var(--shadow-lg);
    padding:2.5rem;
    position:relative;
    z-index:1;
    opacity:0;
    animation:fadeUp .5s ease .1s forwards;
  }
  .auth-divider{
    height:1px;
    background:linear-gradient(90deg,transparent,var(--divider) 30%,var(--divider) 70%,transparent);
    margin:1.5rem 0;
  }
  @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
</style>

<div class="auth-wrap">
  <div class="auth-bg"></div>
  <div class="auth-card">

    <div style="text-align:center;margin-bottom:2rem;">
      <div style="width:52px;height:52px;border-radius:14px;
                  background:linear-gradient(135deg,var(--blue-vivid),var(--purple));
                  display:flex;align-items:center;justify-content:center;
                  margin:0 auto 1rem;
                  box-shadow:0 4px 16px rgba(37,99,235,.35);">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
        </svg>
      </div>
      <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.5rem;
                 color:var(--text-1);margin:0 0 .3rem;">Bem-vindo de volta</h1>
      <p style="font-size:.8rem;color:var(--text-3);margin:0;">CPSM 2026 — Portal de Inscrições</p>
    </div>

    <form method="POST" action="{{ route('login') }}"
          style="display:flex;flex-direction:column;gap:1rem;">
      @csrf

      <div>
        <label class="form-label" for="email">Endereço de email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}"
               class="form-input" placeholder="nome@instituicao.ao"
               autocomplete="email">
        @error('email')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="form-label" for="password">Senha</label>
        <input type="password" id="password" name="password"
               class="form-input" placeholder="••••••••"
               autocomplete="current-password">
        @error('password')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div style="display:flex;align-items:center;justify-content:space-between;">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;
                      font-size:.75rem;color:var(--text-2);">
          <input type="checkbox" name="remember" style="width:14px;height:14px;cursor:pointer;">
          Lembrar sessão
        </label>
      </div>

      <button type="submit" class="btn-primary"
              style="justify-content:center;padding:.7rem;font-size:.85rem;margin-top:.25rem;">
        Entrar
      </button>
    </form>

    <div class="auth-divider"></div>

    <p style="text-align:center;font-size:.78rem;color:var(--text-3);">
      Ainda não tem conta?
      <a href="{{ route('register') }}"
         style="color:var(--blue-brand);font-weight:600;text-decoration:none;
                transition:color .15s;">
        Criar conta
      </a>
    </p>
  </div>
</div>
@endsection
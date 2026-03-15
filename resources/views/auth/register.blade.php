@extends('layouts.app')
@section('title','Criar Conta')
@section('content')
<style>
  .auth-wrap{min-height:calc(100vh - 60px - 80px);display:flex;align-items:center;
             justify-content:center;padding:3rem 1rem;position:relative;overflow:hidden;}
  .auth-bg{position:absolute;inset:0;
    background:radial-gradient(ellipse 80% 50% at 50% -20%,rgba(37,99,235,.1),transparent 60%),
               radial-gradient(ellipse 50% 40% at 80% 80%,rgba(109,40,217,.06),transparent 60%);
    pointer-events:none;}
  .auth-card{width:100%;max-width:460px;background:var(--card);border:1px solid var(--card-border);
             border-radius:var(--r-2xl);box-shadow:var(--shadow-lg);padding:2.5rem;position:relative;z-index:1;
             opacity:0;animation:fadeUp .5s ease .1s forwards;}
  .auth-divider{height:1px;background:linear-gradient(90deg,transparent,var(--divider) 30%,var(--divider) 70%,transparent);margin:1.5rem 0;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
</style>

<div class="auth-wrap">
  <div class="auth-bg"></div>
  <div class="auth-card">
    <div style="margin-bottom:1.75rem;">
      <p class="section-label" style="margin-bottom:.25rem;">Acesso</p>
      <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.4rem;color:var(--text-1);margin:0 0 .3rem;">
        Criar conta
      </h1>
      <p style="font-size:.78rem;color:var(--text-3);margin:0;">Para acompanhar e gerir a sua inscrição</p>
    </div>

    <form method="POST" action="{{ route('register') }}"
          style="display:flex;flex-direction:column;gap:.875rem;">
      @csrf

      <div>
        <label class="form-label">Nome completo</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-input" required autocomplete="name">
        @error('name')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
        <div>
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-input" required autocomplete="email">
          @error('email')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="form-label">Telefone</label>
          <input type="text" name="telefone" value="{{ old('telefone') }}"
                 class="form-input" placeholder="+244 9XX XXX XXX" required>
          @error('telefone')<p class="form-error">{{ $message }}</p>@enderror
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
        <div>
          <label class="form-label">Senha</label>
          <input type="password" name="password" class="form-input" required autocomplete="new-password">
          @error('password')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="form-label">Confirmar senha</label>
          <input type="password" name="password_confirmation" class="form-input" required>
        </div>
      </div>

      <button type="submit" class="btn-primary"
              style="justify-content:center;padding:.7rem;font-size:.85rem;margin-top:.375rem;">
        Criar conta
      </button>
    </form>

    <div class="auth-divider"></div>

    <p style="text-align:center;font-size:.78rem;color:var(--text-3);">
      Já tem conta?
      <a href="{{ route('login') }}"
         style="color:var(--blue-brand);font-weight:600;text-decoration:none;">
        Entrar
      </a>
    </p>
  </div>
</div>
@endsection
@extends('layouts.admin')
@section('title','Utilizadores')
@section('page-title','Utilizadores')
@section('content')
<style>
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;">

  <div class="a1">
    <p class="section-label" style="margin-bottom:.2rem;">Administração</p>
    <h1 class="heading" style="font-size:1.5rem;margin:0;">Utilizadores</h1>
  </div>

  <div style="display:grid;grid-template-columns:320px 1fr;gap:1.25rem;" class="responsive-grid">

    {{-- Add user form --}}
    <div class="card a2" style="padding:1.5rem;align-self:start;">
      <p class="section-label" style="margin-bottom:.3rem;">Novo utilizador</p>
      <h3 class="heading" style="font-size:.95rem;margin:0 0 1.25rem;">Adicionar Gestor</h3>

      @if($errors->any())
        <div style="background:var(--danger-bg);border:1px solid #fecdd3;border-radius:var(--r-sm);
                    padding:.875rem 1rem;margin-bottom:1rem;">
          <p style="font-size:.73rem;font-weight:700;color:var(--danger);margin:0 0 .375rem;">
            Corrija os erros:
          </p>
          @foreach($errors->all() as $error)
            <p style="font-size:.72rem;color:#9f1239;margin:0;">{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('admin.utilizadores.store') }}"
            style="display:flex;flex-direction:column;gap:.875rem;">
        @csrf
        <div>
          <label class="form-label">Nome completo</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
        </div>
        <div>
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
        </div>
        <div>
          <label class="form-label">Telefone</label>
          <input type="text" name="telefone" value="{{ old('telefone') }}" class="form-input" placeholder="+244 9XX XXX XXX">
        </div>
        <div>
          <label class="form-label">Perfil</label>
          <select name="role" class="form-input" required>
            <option value="organizador" @selected(old('role')==='organizador')>Organizador</option>
            <option value="admin" @selected(old('role')==='admin')>Administrador</option>
          </select>
        </div>
        <div>
          <label class="form-label">Senha</label>
          <input type="password" name="password" class="form-input" required>
        </div>
        <div>
          <label class="form-label">Confirmar senha</label>
          <input type="password" name="password_confirmation" class="form-input" required>
        </div>
        <button type="submit" class="btn-primary" style="justify-content:center;">Criar utilizador</button>
      </form>
    </div>

    {{-- Users table --}}
    <div class="card a3" style="overflow:hidden;align-self:start;">
      <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--divider);">
        <p class="section-label" style="margin-bottom:.15rem;">Lista</p>
        <h3 class="heading" style="font-size:.95rem;margin:0;">Administradores & Organizadores</h3>
      </div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead>
            <tr>
              <th><span class="section-label">Utilizador</span></th>
              <th><span class="section-label">Telefone</span></th>
              <th><span class="section-label">Perfis</span></th>
              <th><span class="section-label">Criado em</span></th>
            </tr>
          </thead>
          <tbody>
            @forelse($utilizadores as $user)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:34px;height:34px;border-radius:50%;
                                background:linear-gradient(135deg,var(--blue-vivid),var(--purple));
                                display:flex;align-items:center;justify-content:center;
                                font-size:.75rem;font-weight:700;color:white;flex-shrink:0;">
                      {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                    <div>
                      <div style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $user->name }}</div>
                      <div style="font-size:.7rem;color:var(--text-3);">{{ $user->email }}</div>
                    </div>
                  </div>
                </td>
                <td><span style="font-size:.75rem;color:var(--text-2);">{{ $user->telefone ?: '—' }}</span></td>
                <td>
                  <div style="display:flex;flex-wrap:wrap;gap:.25rem;">
                    @foreach($user->roles as $role)
                      @if(in_array($role->name,['admin','organizador']))
                        <span class="status-badge"
                              style="color:{{ $role->name==='admin'?'var(--danger)':'var(--blue-brand)' }};
                                     background:{{ $role->name==='admin'?'var(--danger-bg)':'var(--info-bg)' }};
                                     border-color:{{ $role->name==='admin'?'#fecdd3':'#bfdbfe' }};">
                          {{ $role->display_name }}
                        </span>
                      @endif
                    @endforeach
                  </div>
                </td>
                <td><span style="font-size:.72rem;color:var(--text-3);">{{ $user->created_at->format('d/m/Y H:i') }}</span></td>
              </tr>
            @empty
              <tr><td colspan="4" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">Nenhum utilizador de gestão.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
  @media(max-width:768px){.responsive-grid{grid-template-columns:1fr!important;}}
</style>
@endsection
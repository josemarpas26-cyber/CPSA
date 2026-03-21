@extends('layouts.admin')
@section('title', $actividade->exists ? 'Editar Actividade' : 'Nova Actividade')
@section('page-title', $actividade->exists ? 'Editar Actividade' : 'Nova Actividade')
@section('content')
<style>
  .form-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;box-shadow:var(--shadow-sm);max-width:820px;
  }
  .form-section-title{
    font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
    color:var(--text-3);padding-bottom:.5rem;border-bottom:1px solid var(--divider);
    margin:1.75rem 0 1.25rem;
  }
  .form-section-title:first-child{margin-top:0;}
  .form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;}
  .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;}
  .form-group{display:flex;flex-direction:column;gap:.375rem;margin-bottom:1.25rem;}
  .form-group:last-child{margin-bottom:0;}
  .speakers-grid{
    display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.5rem;
  }
  .speaker-check{
    display:flex;align-items:center;gap:.5rem;
    padding:.5rem .75rem;border-radius:var(--r-sm);border:1px solid var(--card-border);
    background:var(--surface);cursor:pointer;transition:all .15s;
  }
  .speaker-check:has(input:checked){
    border-color:var(--blue-vivid);background:#eff6ff;
  }
  .speaker-check img{
    width:28px;height:28px;border-radius:50%;object-fit:cover;
    background:var(--surface-2);flex-shrink:0;
  }
  .speaker-check span{
    font-size:.75rem;font-weight:600;color:var(--text-1);
    overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
  }
  .form-actions{
    display:flex;gap:.75rem;align-items:center;
    padding-top:1.5rem;border-top:1px solid var(--divider);margin-top:1.5rem;
  }
  .btn-cancel{
    display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;font-weight:600;
    color:var(--text-2);text-decoration:none;padding:.55rem 1rem;border-radius:var(--r-sm);
    border:1px solid var(--card-border);transition:all .18s;background:transparent;cursor:pointer;
    font-family:var(--font-body);
  }
  .btn-cancel:hover{background:var(--surface);color:var(--text-1);}
  @media(max-width:640px){
    .form-grid-2,.form-grid-3{grid-template-columns:1fr;}
  }
</style>

<div class="form-card">
  <form method="POST"
        action="{{ $actividade->exists
            ? route('admin.programa.update', $actividade)
            : route('admin.programa.store') }}">
    @csrf
    @if($actividade->exists) @method('PUT') @endif

    <p class="form-section-title">Informações da Actividade</p>

    <div class="form-group">
      <label class="form-label" for="nome">Nome da Actividade *</label>
      <input type="text" id="nome" name="nome"
             class="form-input @error('nome') border-red-400 @enderror"
             value="{{ old('nome', $actividade->nome) }}"
             placeholder="Ex: Mesa Redonda — Saúde Mental no Trabalho"
             required>
      @error('nome')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="descricao">Descrição <span style="font-weight:400;color:var(--text-4);">(opcional)</span></label>
      <textarea id="descricao" name="descricao" rows="3"
                class="form-input" style="resize:vertical;"
                placeholder="Resumo ou ementa da actividade...">{{ old('descricao', $actividade->descricao) }}</textarea>
      @error('descricao')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-grid-2" style="margin-bottom:1.25rem;">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="tipo">Tipo de Actividade *</label>
        <select id="tipo" name="tipo"
                class="form-input @error('tipo') border-red-400 @enderror" required>
          <option value="">Seleccionar...</option>
          @foreach($tipos as $val => $lbl)
            <option value="{{ $val }}"
                    {{ old('tipo', $actividade->tipo) === $val ? 'selected' : '' }}>
              {{ $lbl }}
            </option>
          @endforeach
        </select>
        @error('tipo')<p class="form-error">{{ $message }}</p>@enderror
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="sala">Sala / Local</label>
        <input type="text" id="sala" name="sala"
               class="form-input"
               value="{{ old('sala', $actividade->sala) }}"
               placeholder="Ex: Auditório Principal, Sala A">
        @error('sala')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    <p class="form-section-title">Agenda</p>

    <div class="form-grid-3" style="margin-bottom:1.25rem;">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="dia">Dia *</label>
        <select id="dia" name="dia"
                class="form-input @error('dia') border-red-400 @enderror" required>
          <option value="">Seleccionar dia...</option>
          @foreach($dias as $val => $lbl)
            <option value="{{ $val }}"
                    {{ old('dia', $actividade->dia?->format('Y-m-d')) === $val ? 'selected' : '' }}>
              {{ $lbl }}
            </option>
          @endforeach
        </select>
        @error('dia')<p class="form-error">{{ $message }}</p>@enderror
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="hora_inicio">Hora de Início *</label>
        <input type="time" id="hora_inicio" name="hora_inicio"
               class="form-input @error('hora_inicio') border-red-400 @enderror"
               value="{{ old('hora_inicio', $actividade->hora_inicio ? substr($actividade->hora_inicio,0,5) : '') }}"
               required>
        @error('hora_inicio')<p class="form-error">{{ $message }}</p>@enderror
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="hora_fim">Hora de Fim *</label>
        <input type="time" id="hora_fim" name="hora_fim"
               class="form-input @error('hora_fim') border-red-400 @enderror"
               value="{{ old('hora_fim', $actividade->hora_fim ? substr($actividade->hora_fim,0,5) : '') }}"
               required>
        @error('hora_fim')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    @if($speakers->isNotEmpty())
      <p class="form-section-title">Palestrantes</p>
      <div class="speakers-grid" style="margin-bottom:1.25rem;">
        @php $selectedSpeakers = old('speaker_ids', $actividade->speakers->pluck('id')->toArray()); @endphp
        @foreach($speakers as $sp)
          <label class="speaker-check">
            <input type="checkbox"
                   name="speaker_ids[]"
                   value="{{ $sp->id }}"
                   {{ in_array($sp->id, $selectedSpeakers) ? 'checked' : '' }}
                   style="width:13px;height:13px;accent-color:var(--blue-vivid);flex-shrink:0;">
            @if($sp->foto)
              <img src="{{ $sp->foto_url ?? asset('storage/'.$sp->foto) }}" alt="{{ $sp->nome }}">
            @else
              <div style="width:28px;height:28px;border-radius:50%;background:var(--blue-vivid);
                          display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-size:.7rem;font-weight:700;color:white;">
                  {{ strtoupper(substr($sp->nome,0,1)) }}
                </span>
              </div>
            @endif
            <span>{{ \Str::words($sp->nome, 3, '…') }}</span>
          </label>
        @endforeach
      </div>
    @endif

    <p class="form-section-title">Configurações</p>

    <div class="form-grid-2">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="ordem">Ordem de exibição</label>
        <input type="number" id="ordem" name="ordem" min="0"
               class="form-input"
               value="{{ old('ordem', $actividade->ordem ?? 0) }}">
        <p style="font-size:.7rem;color:var(--text-4);margin:.25rem 0 0;">
          Dentro do mesmo horário, o menor valor aparece primeiro.
        </p>
      </div>
      <div style="display:flex;align-items:center;padding-top:1.5rem;">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
          <input type="checkbox" name="ativo" value="1"
                 {{ old('ativo', $actividade->exists ? $actividade->ativo : true) ? 'checked' : '' }}
                 style="width:15px;height:15px;accent-color:var(--blue-vivid);">
          <span style="font-size:.82rem;font-weight:500;color:var(--text-1);">Activo (visível no programa público)</span>
        </label>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $actividade->exists ? 'Guardar alterações' : 'Criar actividade' }}
      </button>
      <a href="{{ route('admin.programa.index') }}" class="btn-cancel">Cancelar</a>
    </div>
  </form>
</div>
@endsection
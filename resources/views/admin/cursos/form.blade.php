@extends('layouts.admin')
@section('title', $curso->exists ? 'Editar Curso' : 'Novo Curso')
@section('page-title', $curso->exists ? 'Editar Curso' : 'Novo Curso')
@section('content')
<style>
  .form-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;box-shadow:var(--shadow-sm);
    max-width:860px;
  }
  .form-section-title{
    font-size:.65rem;font-weight:700;letter-spacing:.12em;
    text-transform:uppercase;color:var(--text-3);
    padding-bottom:.5rem;border-bottom:1px solid var(--divider);
    margin:1.75rem 0 1.25rem;
  }
  .form-section-title:first-child{margin-top:0;}
  .form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;}
  .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;}
  .form-group{display:flex;flex-direction:column;gap:.375rem;margin-bottom:1.25rem;}

  /* Speaker checkboxes */
  .speaker-grid{
    display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:.625rem;
    margin-top:.5rem;
  }
  .speaker-check{
    display:flex;align-items:center;gap:.625rem;
    padding:.625rem .75rem;border:1px solid var(--card-border);
    border-radius:var(--r-sm);cursor:pointer;
    transition:border-color .18s,background .18s;
  }
  .speaker-check:has(input:checked){
    border-color:var(--blue-vivid);background:rgba(37,99,235,.05);
  }
  .speaker-check input[type=checkbox]{
    width:14px;height:14px;accent-color:var(--blue-vivid);cursor:pointer;flex-shrink:0;
  }
  .speaker-avatar-sm{
    width:28px;height:28px;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
    display:flex;align-items:center;justify-content:center;
    font-size:.65rem;font-weight:700;color:white;overflow:hidden;
  }
  .speaker-avatar-sm img{width:28px;height:28px;object-fit:cover;}

  .form-actions{
    display:flex;gap:.75rem;align-items:center;
    padding-top:1.5rem;border-top:1px solid var(--divider);margin-top:1.5rem;
  }
  .btn-cancel{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.8rem;font-weight:600;
    color:var(--text-2);text-decoration:none;
    padding:.55rem 1rem;border-radius:var(--r-sm);
    border:1px solid var(--card-border);
    transition:all .18s;background:transparent;cursor:pointer;
    font-family:var(--font-body);
  }
  .btn-cancel:hover{background:var(--surface);color:var(--text-1);}

  @media(max-width:640px){
    .form-grid-2,.form-grid-3{grid-template-columns:1fr;}
  }
</style>

<div class="form-card">
  <form method="POST"
        action="{{ $curso->exists
            ? route('admin.cursos.update', $curso)
            : route('admin.cursos.store') }}">
    @csrf
    @if($curso->exists) @method('PUT') @endif

    {{-- ── Informações Gerais ──────────────── --}}
    <p class="form-section-title">Informações Gerais</p>

    <div class="form-group">
      <label class="form-label" for="nome">Nome do Curso *</label>
      <input type="text" id="nome" name="nome"
             class="form-input @error('nome') border-red-400 @enderror"
             value="{{ old('nome', $curso->nome) }}"
             placeholder="Ex: Workshop de Psicopatologia Forense"
             required>
      @error('nome')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="descricao">Descrição</label>
      <textarea id="descricao" name="descricao"
                class="form-input"
                style="resize:vertical;min-height:90px;"
                placeholder="Breve descrição do conteúdo e objectivos do curso...">{{ old('descricao', $curso->descricao) }}</textarea>
      @error('descricao')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    {{-- ── Local & Horário ─────────────────── --}}
    <p class="form-section-title">Local & Horário</p>

    <div class="form-grid-2" style="margin-bottom:1.25rem;">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="sala">Sala *</label>
        <input type="text" id="sala" name="sala"
               class="form-input @error('sala') border-red-400 @enderror"
               value="{{ old('sala', $curso->sala) }}"
               placeholder="Ex: Sala A · Auditório Principal"
               required>
        @error('sala')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="dia">Dia *</label>
        <input type="date" id="dia" name="dia"
               class="form-input @error('dia') border-red-400 @enderror"
               value="{{ old('dia', $curso->dia?->format('Y-m-d')) }}"
               required>
        @error('dia')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="form-grid-3">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="hora_inicio">Hora de Início *</label>
        <input type="time" id="hora_inicio" name="hora_inicio"
               class="form-input @error('hora_inicio') border-red-400 @enderror"
               value="{{ old('hora_inicio', $curso->hora_inicio ? substr($curso->hora_inicio,0,5) : '') }}"
               required>
        @error('hora_inicio')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="hora_fim">Hora de Fim *</label>
        <input type="time" id="hora_fim" name="hora_fim"
               class="form-input @error('hora_fim') border-red-400 @enderror"
               value="{{ old('hora_fim', $curso->hora_fim ? substr($curso->hora_fim,0,5) : '') }}"
               required>
        @error('hora_fim')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="vagas">Vagas (vazio = ilimitado)</label>
        <input type="number" id="vagas" name="vagas" min="1"
               class="form-input"
               value="{{ old('vagas', $curso->vagas) }}"
               placeholder="Ex: 30">
        @error('vagas')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    {{-- ── Palestrantes ────────────────────── --}}
    <p class="form-section-title">Palestrantes</p>

    @if($speakers->isEmpty())
      <p style="font-size:.78rem;color:var(--text-3);margin-bottom:1.25rem;">
        Nenhum palestrante activo registado.
        <a href="{{ route('admin.speakers.create') }}" style="color:var(--blue-vivid);">
          Adicionar palestrante
        </a>
      </p>
    @else
      @error('speaker_ids')<p class="form-error" style="margin-bottom:.5rem;">{{ $message }}</p>@enderror
      <div class="speaker-grid">
        @foreach($speakers as $sp)
          @php
            $checked = old('speaker_ids')
                ? in_array($sp->id, (array) old('speaker_ids'))
                : ($curso->exists && $curso->speakers->contains($sp->id));
          @endphp
          <label class="speaker-check">
            <input type="checkbox" name="speaker_ids[]"
                   value="{{ $sp->id }}"
                   {{ $checked ? 'checked' : '' }}>
            <div class="speaker-avatar-sm">
              @if($sp->foto_url)
                <img src="{{ $sp->foto_url }}" alt="{{ $sp->nome }}">
              @else
                {{ $sp->inicial }}
              @endif
            </div>
            <div style="min-width:0;">
              <p style="font-size:.78rem;font-weight:600;color:var(--text-1);
                         margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $sp->nome }}
              </p>
              <p style="font-size:.65rem;color:var(--text-3);margin:0;
                         white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $sp->especialidade }}
              </p>
            </div>
          </label>
        @endforeach
      </div>
    @endif

    {{-- ── Configurações ───────────────────── --}}
    <p class="form-section-title" style="margin-top:1.75rem;">Configurações</p>

    <div class="form-grid-2">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="ordem">Ordem de exibição</label>
        <input type="number" id="ordem" name="ordem" min="0"
               class="form-input"
               value="{{ old('ordem', $curso->ordem ?? 0) }}"
               placeholder="0">
        <p style="font-size:.7rem;color:var(--text-4);margin:.25rem 0 0;">
          Menor número = aparece primeiro no formulário de inscrição.
        </p>
      </div>
      <div style="display:flex;align-items:center;padding-top:1.5rem;">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
          <input type="checkbox" name="ativo" value="1"
                 {{ old('ativo', $curso->exists ? $curso->ativo : true) ? 'checked' : '' }}
                 style="width:15px;height:15px;accent-color:var(--blue-vivid);">
          <span style="font-size:.82rem;font-weight:500;color:var(--text-1);">
            Curso activo (disponível para selecção na inscrição)
          </span>
        </label>
      </div>
    </div>

    {{-- ── Acções ──────────────────────────── --}}
    <div class="form-actions">
      <button type="submit" class="btn-primary">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $curso->exists ? 'Guardar alterações' : 'Criar curso' }}
      </button>
      <a href="{{ route('admin.cursos.index') }}" class="btn-cancel">Cancelar</a>
    </div>
  </form>
</div>
@endsection
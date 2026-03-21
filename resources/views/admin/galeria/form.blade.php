@extends('layouts.admin')
@section('title', $item->exists ? 'Editar Foto' : 'Adicionar Foto')
@section('page-title', $item->exists ? 'Editar Foto' : 'Adicionar Foto')
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
  .form-group{display:flex;flex-direction:column;gap:.375rem;margin-bottom:1.25rem;}
  .foto-preview-wrap{display:flex;align-items:center;gap:1.25rem;margin-top:.5rem;}
  .foto-preview{
    width:100px;height:80px;border-radius:var(--r-md);overflow:hidden;
    background:var(--surface);border:1px solid var(--card-border);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
  }
  .foto-preview img{width:100%;height:100%;object-fit:cover;}
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
  @media(max-width:640px){.form-grid-2{grid-template-columns:1fr;}}
</style>

<div class="form-card">
  <form method="POST"
        action="{{ $item->exists ? route('admin.galeria.update', $item) : route('admin.galeria.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if($item->exists) @method('PUT') @endif

    <p class="form-section-title">Informações</p>

    <div class="form-group">
      <label class="form-label" for="titulo">Título *</label>
      <input type="text" id="titulo" name="titulo"
             class="form-input @error('titulo') border-red-400 @enderror"
             value="{{ old('titulo', $item->titulo) }}"
             placeholder="Ex: Conferência de Abertura — Sessão Plenária"
             required>
      @error('titulo')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
      <label class="form-label" for="descricao">Descrição <span style="font-weight:400;color:var(--text-4);">(opcional)</span></label>
      <textarea id="descricao" name="descricao" rows="3"
                class="form-input" style="resize:vertical;"
                placeholder="Breve descrição do momento registado...">{{ old('descricao', $item->descricao) }}</textarea>
      @error('descricao')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-grid-2" style="margin-bottom:1.25rem;">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="categoria">Categoria *</label>
        <select id="categoria" name="categoria"
                class="form-input @error('categoria') border-red-400 @enderror" required>
          <option value="">Seleccionar...</option>
          @foreach($categorias as $val => $lbl)
            <option value="{{ $val }}" {{ old('categoria', $item->categoria) === $val ? 'selected' : '' }}>
              {{ $lbl }}
            </option>
          @endforeach
        </select>
        @error('categoria')<p class="form-error">{{ $message }}</p>@enderror
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="data_publicacao">Data de Publicação *</label>
        <input type="date" id="data_publicacao" name="data_publicacao"
               class="form-input @error('data_publicacao') border-red-400 @enderror"
               value="{{ old('data_publicacao', $item->data_publicacao?->format('Y-m-d')) }}"
               required>
        @error('data_publicacao')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    <p class="form-section-title">Fotografia</p>

    <div class="form-group">
      <label class="form-label">Imagem * (JPG, PNG, WebP — máx. 4 MB)</label>
      <div class="foto-preview-wrap">
        <div class="foto-preview" id="fotoPreview">
          @if($item->foto)
            <img src="{{ $item->foto_url }}" alt="{{ $item->titulo }}" id="fotoImg">
          @else
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="var(--text-4)" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/>
            </svg>
          @endif
        </div>
        <div>
          <input type="file" id="foto" name="foto" accept="image/*" style="font-size:.78rem;">
          @error('foto')<p class="form-error">{{ $message }}</p>@enderror
          @if($item->foto)
            <label style="display:flex;align-items:center;gap:.5rem;margin-top:.5rem;cursor:pointer;">
              <input type="checkbox" name="remover_foto" value="1"
                     {{ old('remover_foto') ? 'checked' : '' }}
                     style="width:14px;height:14px;accent-color:var(--danger);">
              <span style="font-size:.78rem;color:var(--danger);">Remover foto actual</span>
            </label>
          @endif
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label" for="foto_alt">Texto alternativo (acessibilidade)</label>
      <input type="text" id="foto_alt" name="foto_alt"
             class="form-input"
             value="{{ old('foto_alt', $item->foto_alt) }}"
             placeholder="Descreva a imagem para utilizadores com leitores de ecrã">
      @error('foto_alt')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <p class="form-section-title">Configurações</p>

    <div class="form-grid-2">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label" for="ordem">Ordem de exibição</label>
        <input type="number" id="ordem" name="ordem" min="0"
               class="form-input"
               value="{{ old('ordem', $item->ordem ?? 0) }}"
               placeholder="0">
        <p style="font-size:.7rem;color:var(--text-4);margin:.25rem 0 0;">Menor = aparece primeiro.</p>
      </div>
      <div style="display:flex;align-items:center;padding-top:1.5rem;">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
          <input type="checkbox" name="ativo" value="1"
                 {{ old('ativo', $item->exists ? $item->ativo : true) ? 'checked' : '' }}
                 style="width:15px;height:15px;accent-color:var(--blue-vivid);">
          <span style="font-size:.82rem;font-weight:500;color:var(--text-1);">Publicado (visível na galeria pública)</span>
        </label>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $item->exists ? 'Guardar alterações' : 'Adicionar à galeria' }}
      </button>
      <a href="{{ route('admin.galeria.index') }}" class="btn-cancel">Cancelar</a>
    </div>
  </form>
</div>

<script>
  document.getElementById('foto')?.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
      const p = document.getElementById('fotoPreview');
      p.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
    };
    reader.readAsDataURL(file);
  });
</script>
@endsection
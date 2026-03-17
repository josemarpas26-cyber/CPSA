@extends('layouts.admin')
@section('title', $speaker->exists ? 'Editar Palestrante' : 'Novo Palestrante')
@section('page-title', $speaker->exists ? 'Editar Palestrante' : 'Novo Palestrante')
@section('content')
<style>
  .form-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;box-shadow:var(--shadow-sm);
    max-width:820px;
  }
  .form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;}
  .form-group{display:flex;flex-direction:column;gap:.375rem;margin-bottom:1.25rem;}
  .form-section-title{
    font-size:.65rem;font-weight:700;letter-spacing:.12em;
    text-transform:uppercase;color:var(--text-3);
    padding-bottom:.5rem;border-bottom:1px solid var(--divider);
    margin:1.75rem 0 1.25rem;
  }
  .form-section-title:first-child{margin-top:0;}
  .foto-preview-wrap{
    display:flex;align-items:center;gap:1.25rem;margin-top:.5rem;
  }
  .foto-preview{
    width:72px;height:72px;border-radius:var(--r-md);overflow:hidden;
    background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
    display:flex;align-items:center;justify-content:center;
    font-family:var(--font-display);font-style:italic;
    font-size:1.75rem;color:white;font-weight:700;flex-shrink:0;
  }
  .foto-preview img{width:72px;height:72px;object-fit:cover;}
  .form-check{
    display:flex;align-items:center;gap:.5rem;cursor:pointer;
  }
  .form-check input[type=checkbox]{
    width:16px;height:16px;accent-color:var(--blue-vivid);cursor:pointer;
  }
  .form-check span{font-size:.82rem;color:var(--text-1);font-weight:500;}
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

  @media(max-width:640px){.form-grid-2{grid-template-columns:1fr;}}
</style>

<div class="form-card">
  <form method="POST"
        action="{{ $speaker->exists
            ? route('admin.speakers.update', $speaker)
            : route('admin.speakers.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if($speaker->exists) @method('PUT') @endif

    {{-- ── Dados Pessoais ───────────────────────── --}}
    <p class="form-section-title">Dados Pessoais</p>

    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label" for="nome">Nome Completo *</label>
        <input type="text" id="nome" name="nome"
               class="form-input @error('nome') border-red-400 @enderror"
               value="{{ old('nome', $speaker->nome) }}"
               placeholder="Ex: Prof. Dr. João Silva"
               required>
        @error('nome')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="especialidade">Especialidade *</label>
        <input type="text" id="especialidade" name="especialidade"
               class="form-input @error('especialidade') border-red-400 @enderror"
               value="{{ old('especialidade', $speaker->especialidade) }}"
               placeholder="Ex: Psiquiatria Clínica"
               required>
        @error('especialidade')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label" for="instituicao">Instituição</label>
        <input type="text" id="instituicao" name="instituicao"
               class="form-input"
               value="{{ old('instituicao', $speaker->instituicao) }}"
               placeholder="Ex: Universidade Agostinho Neto">
        @error('instituicao')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="pais">País</label>
        <input type="text" id="pais" name="pais"
               class="form-input"
               value="{{ old('pais', $speaker->pais ?? 'Angola') }}"
               placeholder="Ex: Angola">
        @error('pais')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    {{-- ── Biografia ─────────────────────────────── --}}
    <p class="form-section-title">Biografia</p>

    <div class="form-group">
      <label class="form-label" for="biografia">Biografia</label>
      <textarea id="biografia" name="biografia"
                class="form-input"
                style="resize:vertical;min-height:130px;"
                placeholder="Breve descrição do percurso e experiência do palestrante...">{{ old('biografia', $speaker->biografia) }}</textarea>
      @error('biografia')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    {{-- ── Foto ─────────────────────────────────── --}}
    <p class="form-section-title">Foto</p>

    <div class="form-group">
      <label class="form-label">Fotografia (máx. 2 MB — JPG, PNG, WebP)</label>
      <div class="foto-preview-wrap">
        <div class="foto-preview" id="fotoPreview">
          @if($speaker->foto_url)
            <img src="{{ $speaker->foto_url }}" alt="{{ $speaker->nome }}" id="fotoImg">
          @else
            <span id="fotoInicialPlaceholder">
              {{ $speaker->exists ? $speaker->inicial : '?' }}
            </span>
          @endif
        </div>
        <div>
          <input type="file" id="foto" name="foto"
                 accept="image/*"
                 style="font-size:.78rem;">
          @error('foto')<p class="form-error">{{ $message }}</p>@enderror
          @if($speaker->foto)
            <label class="form-check" style="margin-top:.5rem;">
              <input type="checkbox" name="remover_foto" value="1"
                     {{ old('remover_foto') ? 'checked' : '' }}>
              <span>Remover foto atual</span>
            </label>
          @endif
        </div>
      </div>
    </div>

    {{-- ── Contacto ─────────────────────────────── --}}
    <p class="form-section-title">Contacto & Redes Sociais</p>

    <div class="form-group">
      <label class="form-label" for="email">Email de Contacto</label>
      <input type="email" id="email" name="email"
             class="form-input @error('email') border-red-400 @enderror"
             value="{{ old('email', $speaker->email) }}"
             placeholder="palestrante@email.com">
      @error('email')<p class="form-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label" for="linkedin">LinkedIn (URL completo)</label>
        <input type="url" id="linkedin" name="linkedin"
               class="form-input @error('linkedin') border-red-400 @enderror"
               value="{{ old('linkedin', $speaker->linkedin) }}"
               placeholder="https://linkedin.com/in/...">
        @error('linkedin')<p class="form-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="twitter">Twitter / X (URL completo)</label>
        <input type="url" id="twitter" name="twitter"
               class="form-input @error('twitter') border-red-400 @enderror"
               value="{{ old('twitter', $speaker->twitter) }}"
               placeholder="https://x.com/...">
        @error('twitter')<p class="form-error">{{ $message }}</p>@enderror
      </div>
    </div>

    {{-- ── Configurações ─────────────────────────── --}}
    <p class="form-section-title">Configurações</p>

    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label" for="ordem">Ordem de exibição</label>
        <input type="number" id="ordem" name="ordem" min="0"
               class="form-input"
               value="{{ old('ordem', $speaker->ordem ?? 0) }}"
               placeholder="0">
        <p style="font-size:.7rem;color:var(--text-4);margin:.25rem 0 0;">
          Menor número = aparece primeiro.
        </p>
      </div>
      <div style="display:flex;flex-direction:column;gap:.75rem;padding-top:1.5rem;">
        <label class="form-check">
          <input type="checkbox" name="destaque" value="1"
                 {{ old('destaque', $speaker->destaque) ? 'checked' : '' }}>
          <span>⭐ Mostrar em destaque na página inicial</span>
        </label>
        <label class="form-check">
          <input type="checkbox" name="ativo" value="1"
                 {{ old('ativo', $speaker->exists ? $speaker->ativo : true) ? 'checked' : '' }}>
          <span>Palestrante ativo (visível ao público)</span>
        </label>
      </div>
    </div>

    {{-- ── Ações ────────────────────────────────── --}}
    <div class="form-actions">
      <button type="submit" class="btn-primary">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $speaker->exists ? 'Guardar alterações' : 'Criar palestrante' }}
      </button>
      <a href="{{ route('admin.speakers.index') }}" class="btn-cancel">Cancelar</a>
    </div>
  </form>
</div>

<script>
  /* Preview da foto antes de guardar */
  document.getElementById('foto')?.addEventListener('change', function(){
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e){
      const preview = document.getElementById('fotoPreview');
      preview.innerHTML = '<img src="' + e.target.result + '" style="width:72px;height:72px;object-fit:cover;">';
    };
    reader.readAsDataURL(file);
  });
</script>
@endsection
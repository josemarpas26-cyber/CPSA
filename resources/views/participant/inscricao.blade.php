@extends('layouts.app')
@section('title','Inscrição')
@section('content')
<style>
  .form-wrap{max-width:680px;margin:0 auto;padding:3rem 1.5rem;}
  .step-bar{display:flex;align-items:center;gap:.5rem;margin-bottom:2.5rem;}
  .step-node{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;
             justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;transition:all .3s;}
  .step-line-seg{flex:1;height:1px;background:var(--divider);}
  .step-label{font-size:.68rem;font-weight:600;color:var(--text-3);white-space:nowrap;}
  .form-section{margin-bottom:2rem;}
  .form-section-title{
    font-family:var(--font-display);font-style:italic;
    font-size:.95rem;color:var(--text-1);
    margin:0 0 1rem;padding-bottom:.75rem;
    border-bottom:1px solid var(--divider);
    display:flex;align-items:center;gap:.625rem;
  }
  .upload-zone{
    border:2px dashed var(--card-border);border-radius:var(--r-lg);
    padding:2.5rem 1.5rem;text-align:center;
    transition:all .2s;cursor:pointer;background:var(--surface);
  }
  .upload-zone:hover,.upload-zone.dragover{border-color:var(--blue-vivid);background:#f0f6ff;}
  .upload-zone.has-file{border-color:var(--success);background:var(--success-bg);}
  @keyframes fadeUp{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .5s ease forwards;}
  .radio-option{
    display:flex;align-items:center;gap:.75rem;
    padding:.75rem 1rem;border:1px solid var(--card-border);border-radius:var(--r-sm);
    cursor:pointer;transition:all .18s;background:white;flex:1;
  }
  .radio-option:has(input:checked){border-color:var(--blue-vivid);background:#f0f6ff;}
  .radio-option input[type=radio]{width:14px;height:14px;accent-color:var(--blue-vivid);}
</style>

<div class="form-wrap">
  {{-- Header --}}
  <div class="animate-in" style="margin-bottom:2rem;">
    <p class="section-label" style="margin-bottom:.3rem;">CPSA 2025</p>
    <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.75rem;
               color:var(--text-1);margin:0 0 .5rem;">Formulário de Inscrição</h1>
    <p style="font-size:.82rem;color:var(--text-3);margin:0;">
      1º Congresso de Psiquiatria e Saúde Mental em Angola
    </p>
  </div>

  {{-- Step bar --}}
  <div class="step-bar animate-in" style="animation-delay:.06s;">
    @foreach(['Dados Pessoais','Participação','Comprovativo'] as $i=>$s)
      <div style="display:flex;align-items:center;gap:.5rem;flex:{{ $i<2?'1':'auto' }};">
        <div class="step-node" style="{{ $i===0?'background:var(--navy);color:white;':'background:var(--surface);color:var(--text-3);border:1px solid var(--divider);' }}">
          {{ $i+1 }}
        </div>
        <span class="step-label" style="{{ $i===0?'color:var(--text-1);':'' }}">{{ $s }}</span>
        @if($i<2)
          <div class="step-line-seg" style="flex:1;margin-left:.5rem;"></div>
        @endif
      </div>
    @endforeach
  </div>

  {{-- Form card --}}
  <div class="animate-in" style="animation-delay:.1s;background:var(--card);
       border:1px solid var(--card-border);border-radius:var(--r-xl);
       box-shadow:var(--shadow-md);overflow:hidden;">
    <form method="POST" action="{{ route('inscricao.store') }}"
          enctype="multipart/form-data" id="form-inscricao">
      @csrf

      <div style="padding:2rem;">

        {{-- Section 1: Personal data --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span style="width:24px;height:24px;border-radius:50%;background:var(--surface);
                         display:flex;align-items:center;justify-content:center;
                         font-size:.65rem;font-weight:700;color:var(--text-2);
                         border:1px solid var(--divider);">1</span>
            Dados Pessoais
          </h2>
          <div style="display:flex;flex-direction:column;gap:.875rem;">
            <div>
              <label class="form-label">Nome completo <span style="color:var(--danger);">*</span></label>
              <input type="text" name="nome_completo" value="{{ old('nome_completo') }}"
                     class="form-input @error('nome_completo') error @enderror">
              @error('nome_completo')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
              <div>
                <label class="form-label">Email <span style="color:var(--danger);">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input">
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="form-label">Telefone <span style="color:var(--danger);">*</span></label>
                <input type="text" name="telefone" value="{{ old('telefone') }}"
                       placeholder="+244 9XX XXX XXX" class="form-input">
                @error('telefone')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
              <div>
                <label class="form-label">Instituição <span style="color:var(--danger);">*</span></label>
                <input type="text" name="instituicao" value="{{ old('instituicao') }}" class="form-input">
                @error('instituicao')<p class="form-error">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="form-label">Cargo <span style="color:var(--danger);">*</span></label>
                <input type="text" name="cargo" value="{{ old('cargo') }}" class="form-input">
                @error('cargo')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>
          </div>
        </div>

        {{-- Section 2: Participation --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span style="width:24px;height:24px;border-radius:50%;background:var(--surface);
                         display:flex;align-items:center;justify-content:center;
                         font-size:.65rem;font-weight:700;color:var(--text-2);
                         border:1px solid var(--divider);">2</span>
            Tipo de Participação
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
            <div>
              <label class="form-label">Categoria <span style="color:var(--danger);">*</span></label>
              <select name="categoria" class="form-input">
                <option value="">Seleccionar...</option>
                @foreach(['medico'=>'Médico(a)','enfermeiro'=>'Enfermeiro(a)','psicologo'=>'Psicólogo(a)','estudante'=>'Estudante','outro'=>'Outro'] as $v=>$l)
                  <option value="{{ $v }}" {{ old('categoria')===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
              </select>
              @error('categoria')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
              <label class="form-label">Modalidade <span style="color:var(--danger);">*</span></label>
              <div style="display:flex;gap:.5rem;margin-top:.1rem;">
                @foreach(['presencial'=>'Presencial','online'=>'Online'] as $v=>$l)
                  <label class="radio-option">
                    <input type="radio" name="tipo_participacao" value="{{ $v }}"
                           {{ old('tipo_participacao')===$v?'checked':'' }}>
                    <span style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $l }}</span>
                  </label>
                @endforeach
              </div>
              @error('tipo_participacao')<p class="form-error">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        {{-- Section 3: Comprovativo --}}
        <div class="form-section" style="margin-bottom:0;">
          <h2 class="form-section-title">
            <span style="width:24px;height:24px;border-radius:50%;background:var(--surface);
                         display:flex;align-items:center;justify-content:center;
                         font-size:.65rem;font-weight:700;color:var(--text-2);
                         border:1px solid var(--divider);">3</span>
            Comprovativo de Pagamento
          </h2>

          <div class="upload-zone" id="drop-zone"
               onclick="document.getElementById('comprovativo-input').click()">
            <div id="upload-idle">
              <div style="width:44px;height:44px;border-radius:var(--r-md);background:var(--surface);
                          display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;
                          border:1px solid var(--divider);">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--text-3)" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
                </svg>
              </div>
              <p style="font-size:.83rem;font-weight:600;color:var(--text-2);margin:0 0 .25rem;">
                Arraste o ficheiro ou clique para seleccionar
              </p>
              <p style="font-size:.72rem;color:var(--text-4);margin:0;">PDF, JPG, JPEG, PNG — máx. 5 MB</p>
            </div>
            <div id="upload-selected" style="display:none;">
              <div style="width:44px;height:44px;border-radius:var(--r-md);background:var(--success-bg);
                          display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;
                          border:1px solid #a7f3d0;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--success)" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <p id="upload-name" style="font-size:.83rem;font-weight:600;color:var(--success);margin:0 0 .2rem;"></p>
              <p id="upload-size" style="font-size:.72rem;color:var(--text-3);margin:0;"></p>
            </div>
            <input type="file" id="comprovativo-input" name="comprovativo"
                   accept=".pdf,.jpg,.jpeg,.png" style="display:none;"
                   onchange="handleFile(this)">
          </div>
          @error('comprovativo')<p class="form-error" style="margin-top:.5rem;">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Footer --}}
      <div style="padding:1.25rem 2rem;border-top:1px solid var(--divider);
                  background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:1rem;">
        <p style="font-size:.73rem;color:var(--text-3);margin:0;">
          Os campos marcados com <span style="color:var(--danger);">*</span> são obrigatórios.
        </p>
        <button type="submit" id="submit-btn" class="btn-primary"
                style="padding:.65rem 1.5rem;font-size:.83rem;">
          Submeter inscrição
        </button>
      </div>

    </form>
  </div>
</div>

<script>
function handleFile(input) {
  if (!input.files.length) return;
  const f = input.files[0];
  document.getElementById('upload-idle').style.display = 'none';
  document.getElementById('upload-selected').style.display = 'block';
  document.getElementById('upload-name').textContent = f.name;
  document.getElementById('upload-size').textContent = (f.size/1048576).toFixed(2) + ' MB';
  document.getElementById('drop-zone').classList.add('has-file');
}
const zone = document.getElementById('drop-zone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
  e.preventDefault();
  zone.classList.remove('dragover');
  const inp = document.getElementById('comprovativo-input');
  inp.files = e.dataTransfer.files;
  handleFile(inp);
});
document.getElementById('form-inscricao').addEventListener('submit', function() {
  const btn = document.getElementById('submit-btn');
  btn.disabled = true;
  btn.textContent = 'A submeter...';
});
</script>
@endsection
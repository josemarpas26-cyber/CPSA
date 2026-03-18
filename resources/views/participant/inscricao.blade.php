@extends('layouts.app')
@section('title','Inscrição')
@section('content')
<style>
  .form-wrap{max-width:720px;margin:0 auto;padding:3rem 1.5rem;}
  .form-section{margin-bottom:2rem;}
  .form-section-title{
    font-family:var(--font-display);font-style:italic;
    font-size:.95rem;color:var(--text-1);
    margin:0 0 1rem;padding-bottom:.75rem;
    border-bottom:1px solid var(--divider);
    display:flex;align-items:center;gap:.625rem;
  }
  .form-section-num{
    width:24px;height:24px;border-radius:50%;background:var(--surface);
    display:flex;align-items:center;justify-content:center;
    font-size:.65rem;font-weight:700;color:var(--text-2);
    border:1px solid var(--divider);flex-shrink:0;
  }
  .upload-zone{
    border:2px dashed var(--card-border);border-radius:var(--r-lg);
    padding:2rem 1.5rem;text-align:center;
    transition:all .2s;cursor:pointer;background:var(--surface);
  }
  .upload-zone:hover,.upload-zone.dragover{border-color:var(--blue-vivid);background:#f0f6ff;}
  .upload-zone.has-file{border-color:var(--success);background:var(--success-bg);}
  .radio-option{
    display:flex;align-items:center;gap:.75rem;
    padding:.75rem 1rem;border:1px solid var(--card-border);border-radius:var(--r-sm);
    cursor:pointer;transition:all .18s;background:white;flex:1;
  }
  .radio-option:has(input:checked){border-color:var(--blue-vivid);background:#f0f6ff;}

  /* Course cards */
  .course-cards{display:flex;flex-direction:column;gap:.625rem;margin-top:.5rem;}
  .course-card{
    display:flex;align-items:flex-start;gap:.875rem;
    padding:1rem 1.125rem;border:2px solid var(--card-border);
    border-radius:var(--r-md);cursor:pointer;
    transition:border-color .18s,background .18s,box-shadow .18s;
    background:white;
  }
  .course-card:has(input:checked){
    border-color:var(--blue-vivid);
    background:rgba(37,99,235,.03);
    box-shadow:0 0 0 3px rgba(37,99,235,.08);
  }
  .course-card.full{
    opacity:.6;cursor:not-allowed;
    background:var(--surface);border-color:var(--card-border);
  }
  .course-card input[type=radio]{
    margin-top:2px;width:15px;height:15px;
    accent-color:var(--blue-vivid);flex-shrink:0;
  }
  .course-badge{
    display:inline-flex;align-items:center;gap:4px;
    font-size:.65rem;font-weight:700;padding:2px 8px;
    border-radius:99px;white-space:nowrap;
  }

  @keyframes fadeUp{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .5s ease forwards;}
</style>

<div class="form-wrap">
  {{-- Header --}}
  <div class="animate-in" style="margin-bottom:2rem;">
    <p class="section-label" style="margin-bottom:.3rem;">CPSM 2026</p>
    <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.75rem;
               color:var(--text-1);margin:0 0 .5rem;">Formulário de Inscrição</h1>
    <p style="font-size:.82rem;color:var(--text-3);margin:0;">
      Iº Congresso de Psiquiatria e Saúde Mental em Angola
    </p>
  </div>

  <div class="animate-in" style="animation-delay:.08s;background:var(--card);
       border:1px solid var(--card-border);border-radius:var(--r-xl);
       box-shadow:var(--shadow-md);overflow:hidden;">
    <form method="POST" action="{{ route('inscricao.store') }}"
          enctype="multipart/form-data" id="form-inscricao">
      @csrf
      <div style="padding:2rem;">

        {{-- ── 1. Dados Pessoais ─────────────── --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span class="form-section-num">1</span>
            Dados Pessoais
          </h2>
          <div style="display:flex;flex-direction:column;gap:.875rem;">
            <div>
              <label class="form-label">Nome completo <span style="color:var(--danger);">*</span></label>
              <input type="text" name="full_name" value="{{ old('full_name') }}"
                     class="form-input @error('full_name') border-red-400 @enderror"
                     placeholder="Nome tal como consta no documento de identificação"
                     required>
              @error('full_name')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
              <div>
                <label class="form-label">Género <span style="color:var(--danger);">*</span></label>
                <select name="gender" class="form-input @error('gender') border-red-400 @enderror" required>
                  <option value="">Seleccionar...</option>
                  @foreach(['masculino'=>'Masculino','feminino'=>'Feminino','outro'=>'Outro'] as $v=>$l)
                    <option value="{{ $v }}" {{ old('gender')===$v?'selected':'' }}>{{ $l }}</option>
                  @endforeach
                </select>
                @error('gender')<p class="form-error">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="form-label">Data de nascimento <span style="color:var(--danger);">*</span></label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="form-input @error('date_of_birth') border-red-400 @enderror"
                       required>
                @error('date_of_birth')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
            <div>
              <label class="form-label">Nacionalidade <span style="color:var(--danger);">*</span></label>

              <select name="nationality"
                      class="form-input @error('nationality') border-red-400 @enderror"
                      required>
                
                @php
                  $countries = [
                    'AO' => 'Angolana',
                    'BR' => 'Brasileira',
                    'PT' => 'Portuguesa',
                    'US' => 'Americana',
                    'FR' => 'Francesa',
                    'CN' => 'Chinesa',
                    'ZA' => 'Sul-Africana',
                    'NA' => 'Namibiana',
                    'MZ' => 'Moçambicana',
                    // podes expandir
                  ];
                  $selected = old('nationality', 'AO');
                @endphp

                @foreach($countries as $code => $name)
                  <option value="{{ $code }}" {{ $selected == $code ? 'selected' : '' }}>
                    {{ $name }}
                  </option>
                @endforeach

              </select>

              @error('nationality')
                <p class="form-error">{{ $message }}</p>
              @enderror
            </div>
              <div>
                <label class="form-label">Nº BI / Passaporte <span style="color:var(--danger);">*</span></label>
                <input type="text" name="document_number" value="{{ old('document_number') }}"
                       class="form-input @error('document_number') border-red-400 @enderror"
                       placeholder="Ex: 0123456789LA041" required>
                @error('document_number')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>
          </div>
        </div>

        {{-- ── 2. Dados Profissionais ────────── --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span class="form-section-num">2</span>
            Dados Profissionais
          </h2>
          <div style="display:flex;flex-direction:column;gap:.875rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
              <div>
                <label class="form-label">Profissão <span style="color:var(--danger);">*</span></label>
                <input type="text" name="profession" value="{{ old('profession') }}"
                       class="form-input @error('profession') border-red-400 @enderror"
                       placeholder="Ex: Médico Psiquiatra" required>
                @error('profession')<p class="form-error">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="form-label">Instituição <span style="color:var(--danger);">*</span></label>
                <input type="text" name="institution" value="{{ old('institution') }}"
                       class="form-input @error('institution') border-red-400 @enderror"
                       placeholder="Local de trabalho ou estudo" required>
                @error('institution')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>

            <div>
              <label class="form-label">Categoria <span style="color:var(--danger);">*</span></label>
              <select name="category" class="form-input @error('category') border-red-400 @enderror" required>
                <option value="">Seleccionar...</option>
                @foreach([
                  'profissional' => 'Profissional de Saúde',
                  'estudante'    => 'Estudante',
                  'orador'       => 'Orador',
                  'convidado'    => 'Convidado',
                  'imprensa'     => 'Imprensa',
                ] as $v => $l)
                  <option value="{{ $v }}" {{ old('category')===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
              </select>
              @error('category')<p class="form-error">{{ $message }}</p>@enderror
            </div>
          </div>
        </div>

        {{-- ── 3. Contacto & Localização ────── --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span class="form-section-num">3</span>
            Contacto & Localização
          </h2>
          <div style="display:flex;flex-direction:column;gap:.875rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
              <div>
                <label class="form-label">Telefone (WhatsApp) <span style="color:var(--danger);">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="form-input @error('phone') border-red-400 @enderror"
                       placeholder="+244 9XX XXX XXX" required>
                @error('phone')<p class="form-error">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="form-label">E-mail <span style="color:var(--danger);">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-input @error('email') border-red-400 @enderror"
                       required>
                @error('email')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
              <div>
                <label class="form-label">Província / País <span style="color:var(--danger);">*</span></label>
                <input type="text" name="province" value="{{ old('province') }}"
                       class="form-input @error('province') border-red-400 @enderror"
                       placeholder="Ex: Luanda · Angola" required>
                @error('province')<p class="form-error">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="form-label">Modo de participação <span style="color:var(--danger);">*</span></label>
                <div style="display:flex;gap:.5rem;margin-top:.1rem;">
                  @foreach(['presencial'=>'Presencial','online'=>'Online'] as $v=>$l)
                    <label class="radio-option">
                      <input type="radio" name="participation_mode" value="{{ $v }}"
                             {{ old('participation_mode')===$v?'checked':'' }}>
                      <span style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $l }}</span>
                    </label>
                  @endforeach
                </div>
                @error('participation_mode')<p class="form-error">{{ $message }}</p>@enderror
              </div>
            </div>
          </div>
        </div>

        {{-- ── 4. Escolha do Curso ───────────── --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span class="form-section-num">4</span>
            Escolha do Curso
          </h2>
          <p style="font-size:.78rem;color:var(--text-3);margin:-.5rem 0 1rem;">
            Seleccione um curso. A inscrição é individual por curso.
          </p>
          @error('curso_id')
            <p class="form-error" style="margin-bottom:.75rem;">{{ $message }}</p>
          @enderror

          @if($cursos->isEmpty())
            <div style="padding:1.5rem;background:var(--surface);border-radius:var(--r-md);
                        border:1px solid var(--card-border);text-align:center;">
              <p style="font-size:.82rem;color:var(--text-3);margin:0;">
                Nenhum curso disponível de momento.
              </p>
            </div>
          @else
            <div class="course-cards">
              @foreach($cursos as $curso)
                @php
                  $inscritos = $curso->inscricoes_count;
                  $cheio     = $curso->vagas && $inscritos >= $curso->vagas;
                @endphp
                <label class="course-card {{ $cheio ? 'full' : '' }}">
                  <input type="radio" name="curso_id" value="{{ $curso->id }}"
                         {{ old('curso_id')==(string)$curso->id?'checked':'' }}
                         {{ $cheio ? 'disabled' : '' }}>
                  <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;flex-wrap:wrap;">
                      <p style="font-size:.85rem;font-weight:700;color:var(--text-1);margin:0 0 .25rem;">
                        {{ $curso->nome }}
                      </p>
                      <div style="display:flex;gap:.35rem;flex-wrap:wrap;flex-shrink:0;">
                        <span class="course-badge" style="background:#eff6ff;color:var(--blue-vivid);">
                          <svg width="10" height="10" fill="none" viewBox="0 0 24 24"
                               stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                          </svg>
                          {{ $curso->sala }}
                        </span>
                        @if($cheio)
                          <span class="course-badge" style="background:var(--danger-bg);color:var(--danger);">
                            Esgotado
                          </span>
                        @elseif($curso->vagas)
                          <span class="course-badge" style="background:#ecfdf5;color:var(--success);">
                            {{ $curso->vagas - $inscritos }} vagas
                          </span>
                        @endif
                      </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:.625rem;flex-wrap:wrap;margin-bottom:.35rem;">
                      <span style="font-size:.72rem;color:var(--text-3);display:flex;align-items:center;gap:3px;">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $curso->dia->isoFormat('ddd, DD/MM/YYYY') }}
                      </span>
                      <span style="font-size:.72rem;color:var(--text-3);display:flex;align-items:center;gap:3px;">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/>
                        </svg>
                        {{ substr($curso->hora_inicio,0,5) }} – {{ substr($curso->hora_fim,0,5) }}
                      </span>
                    </div>
                    @if($curso->descricao)
                      <p style="font-size:.73rem;color:var(--text-3);margin:0;line-height:1.5;">
                        {{ Str::limit($curso->descricao, 120) }}
                      </p>
                    @endif
                    @if($curso->speakers->isNotEmpty())
                      <div style="display:flex;align-items:center;gap:.375rem;margin-top:.5rem;flex-wrap:wrap;">
                        <span style="font-size:.65rem;font-weight:600;text-transform:uppercase;
                                     letter-spacing:.07em;color:var(--text-4);">Palestrante(s):</span>
                        @foreach($curso->speakers as $sp)
                          <span style="font-size:.7rem;font-weight:600;color:var(--text-2);">
                            {{ $sp->nome }}{{ !$loop->last ? ' ·' : '' }}
                          </span>
                        @endforeach
                      </div>
                    @endif
                  </div>
                </label>
              @endforeach
            </div>
          @endif
        </div>

        {{-- ── 5. Observações ───────────────── --}}
        <div class="form-section">
          <h2 class="form-section-title">
            <span class="form-section-num">5</span>
            Observações
          </h2>
          <textarea name="observations" rows="3"
                    class="form-input"
                    style="resize:vertical;"
                    placeholder="Informações adicionais relevantes (opcional)...">{{ old('observations') }}</textarea>
          @error('observations')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        {{-- ── 6. Comprovativo ──────────────── --}}
        <div class="form-section" style="margin-bottom:0;">
          <h2 class="form-section-title">
            <span class="form-section-num">6</span>
            Comprovativo de Pagamento
          </h2>
          <div class="upload-zone" id="drop-zone"
               onclick="document.getElementById('comprovativo-input').click()">
            <div id="upload-idle">
              <div style="width:44px;height:44px;border-radius:var(--r-md);background:var(--surface);
                          display:flex;align-items:center;justify-content:center;margin:0 auto .875rem;
                          border:1px solid var(--divider);">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                     stroke="var(--text-3)" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
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
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                     stroke="var(--success)" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <p id="upload-name" style="font-size:.83rem;font-weight:600;color:var(--success);margin:0 0 .2rem;"></p>
              <p id="upload-size" style="font-size:.72rem;color:var(--text-3);margin:0;"></p>
            </div>
            <input type="file" id="comprovativo-input" name="comprovativo"
                   accept=".pdf,.jpg,.jpeg,.png" style="display:none;"
                   onchange="handleFile(this)">
          </div>
          @error('comprovativo')
            <p class="form-error" style="margin-top:.5rem;">{{ $message }}</p>
          @enderror
        </div>

      </div>

      {{-- Footer --}}
      <div style="padding:1.25rem 2rem;border-top:1px solid var(--divider);
                  background:var(--surface);display:flex;align-items:center;
                  justify-content:space-between;gap:1rem;flex-wrap:wrap;">
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
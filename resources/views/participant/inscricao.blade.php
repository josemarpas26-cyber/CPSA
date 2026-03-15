@extends('layouts.app')
@section('title', 'Inscrição')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Cabeçalho --}}
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Formulário de Inscrição</h1>
        <p class="text-sm text-gray-500 mt-1">
            1º Congresso de Psiquiatria e Saúde Mental em Angola · 2025
        </p>
    </div>

    {{-- Progresso visual --}}
    <div class="flex items-center gap-2 mb-8">
        @foreach(['Dados Pessoais', 'Participação', 'Comprovativo'] as $i => $step)
            <div class="flex-1 text-center">
                <div class="w-7 h-7 rounded-full flex items-center justify-center mx-auto text-xs font-bold
                            {{ $i === 0 ? 'bg-blue-800 text-white' : 'bg-gray-200 text-gray-500' }}">
                    {{ $i + 1 }}
                </div>
                <p class="text-xs mt-1 {{ $i === 0 ? 'text-blue-800 font-medium' : 'text-gray-400' }}">
                    {{ $step }}
                </p>
            </div>
            @if($i < 2)
                <div class="flex-1 h-px bg-gray-200 mb-4"></div>
            @endif
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('inscricao.store') }}"
              enctype="multipart/form-data" class="space-y-6" id="form-inscricao">
            @csrf

            {{-- SECÇÃO 1: Dados pessoais --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4
                           pb-2 border-b border-gray-100">
                    Dados Pessoais
                </h3>
                <div class="grid grid-cols-1 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Nome completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nome_completo"
                               value="{{ old('nome_completo') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500
                                      @error('nome_completo') border-red-400 bg-red-50 @enderror">
                        @error('nome_completo')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email"
                                   value="{{ old('email') }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500
                                          @error('email') border-red-400 bg-red-50 @enderror">
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Telefone <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="telefone"
                                   value="{{ old('telefone') }}"
                                   placeholder="+244 9XX XXX XXX"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500
                                          @error('telefone') border-red-400 bg-red-50 @enderror">
                            @error('telefone')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Instituição <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="instituicao"
                                   value="{{ old('instituicao') }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500
                                          @error('instituicao') border-red-400 bg-red-50 @enderror">
                            @error('instituicao')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Cargo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cargo"
                                   value="{{ old('cargo') }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500
                                          @error('cargo') border-red-400 bg-red-50 @enderror">
                            @error('cargo')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECÇÃO 2: Participação --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4
                           pb-2 border-b border-gray-100">
                    Tipo de Participação
                </h3>
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Categoria <span class="text-red-500">*</span>
                        </label>
                        <select name="categoria"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500
                                       @error('categoria') border-red-400 bg-red-50 @enderror">
                            <option value="">Seleccionar...</option>
                            @foreach([
                                'medico'     => 'Médico(a)',
                                'enfermeiro' => 'Enfermeiro(a)',
                                'psicologo'  => 'Psicólogo(a)',
                                'estudante'  => 'Estudante',
                                'outro'      => 'Outro',
                            ] as $val => $label)
                                <option value="{{ $val }}" {{ old('categoria') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Modalidade <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            @foreach(['presencial' => 'Presencial', 'online' => 'Online'] as $val => $label)
                                <label class="flex items-center gap-2 border rounded-lg px-3 py-2.5
                                              cursor-pointer transition
                                              {{ old('tipo_participacao') === $val
                                                 ? 'border-blue-500 bg-blue-50'
                                                 : 'border-gray-200 hover:border-blue-300' }}">
                                    <input type="radio" name="tipo_participacao" value="{{ $val }}"
                                           {{ old('tipo_participacao') === $val ? 'checked' : '' }}
                                           class="text-blue-700">
                                    <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('tipo_participacao')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SECÇÃO 3: Comprovativo --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4
                           pb-2 border-b border-gray-100">
                    Comprovativo de Pagamento
                </h3>

                <div id="drop-zone"
                     class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center
                            hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer
                            @error('comprovativo') border-red-400 bg-red-50 @enderror">
                    <div id="drop-idle">
                        <div class="text-3xl mb-2">📎</div>
                        <p class="text-sm font-medium text-gray-700">
                            Arraste o ficheiro ou
                            <label class="text-blue-700 cursor-pointer hover:underline">
                                clique para seleccionar
                                <input type="file" name="comprovativo" id="comprovativo"
                                       accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                                       onchange="mostrarFicheiro(this)">
                            </label>
                        </p>
                        <p class="text-xs text-gray-400 mt-1">PDF, JPG, JPEG, PNG — máx. 5MB</p>
                    </div>
                    <div id="drop-selected" class="hidden">
                        <div class="text-3xl mb-2">✅</div>
                        <p class="text-sm font-medium text-gray-700" id="drop-filename"></p>
                        <p class="text-xs text-gray-400 mt-1" id="drop-filesize"></p>
                    </div>
                </div>
                @error('comprovativo')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-blue-800 hover:bg-blue-900 text-white font-semibold
                           py-3 rounded-xl transition text-sm flex items-center justify-center gap-2">
                <span>Submeter Inscrição</span>
                <span>→</span>
            </button>

        </form>
    </div>
</div>

<script>
function mostrarFicheiro(input) {
    if (!input.files.length) return;
    const f = input.files[0];
    document.getElementById('drop-idle').classList.add('hidden');
    document.getElementById('drop-selected').classList.remove('hidden');
    document.getElementById('drop-filename').textContent = f.name;
    document.getElementById('drop-filesize').textContent =
        (f.size / 1048576).toFixed(2) + ' MB';
}

// Drag & drop
const zone = document.getElementById('drop-zone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('border-blue-500'); });
zone.addEventListener('dragleave', () => zone.classList.remove('border-blue-500'));
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('border-blue-500');
    const input = document.getElementById('comprovativo');
    input.files = e.dataTransfer.files;
    mostrarFicheiro(input);
});
</script>
@endsection
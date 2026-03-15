@extends('layouts.app')
@section('title', 'Início')

@section('content')

{{-- ── HERO ── --}}
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-violet-900
                rounded-3xl overflow-hidden mb-12 px-8 py-16 text-center">

    {{-- Círculos decorativos --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full
                translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-violet-400 opacity-10 rounded-full
                -translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

    <div class="relative z-10 max-w-3xl mx-auto">
        <span class="inline-block bg-white/10 text-blue-100 text-xs font-semibold
                     px-4 py-1.5 rounded-full mb-6 tracking-widest uppercase">
            Luanda · Angola · 2025
        </span>

        <h1 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
            1º Congresso de Psiquiatria<br>
            e Saúde Mental em Angola
        </h1>

        <p class="text-blue-200 text-base mb-8 max-w-xl mx-auto leading-relaxed">
            O maior evento de psiquiatria e saúde mental de Angola.
            Junte-se a especialistas, investigadores e profissionais de saúde
            de todo o país.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('inscricao.create') }}"
               class="bg-white text-blue-900 font-bold px-8 py-3 rounded-xl
                      hover:bg-blue-50 transition text-sm shadow-lg">
                Inscrever-me Agora →
            </a>
            @auth
                <a href="{{ route('participant.minha-inscricao') }}"
                   class="bg-white/10 text-white font-semibold px-8 py-3 rounded-xl
                          hover:bg-white/20 transition text-sm border border-white/20">
                    Ver Minha Inscrição
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-white/10 text-white font-semibold px-8 py-3 rounded-xl
                          hover:bg-white/20 transition text-sm border border-white/20">
                    Já estou inscrito
                </a>
            @endauth
        </div>
    </div>
</section>

{{-- ── COUNTERS ── --}}
<section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
    @foreach([
        ['🎤', '20+',  'Oradores Nacionais'],
        ['🏛️', '2',    'Dias de Congresso'],
        ['📚', '15+',  'Sessões Científicas'],
        ['🤝', '500+', 'Participantes Esperados'],
    ] as [$icon, $val, $label])
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center shadow-sm">
            <div class="text-2xl mb-2">{{ $icon }}</div>
            <div class="text-2xl font-bold text-blue-800">{{ $val }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $label }}</div>
        </div>
    @endforeach
</section>

{{-- ── SOBRE ── --}}
<section class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Sobre o Congresso</h2>
        <p class="text-sm text-gray-600 leading-relaxed mb-4">
            O <strong>1º Congresso de Psiquiatria e Saúde Mental em Angola (CPSA 2025)</strong>
            é um evento científico de referência que reúne profissionais de saúde,
            investigadores, académicos e estudantes para debater os avanços e
            desafios na área da saúde mental em Angola e em África.
        </p>
        <p class="text-sm text-gray-600 leading-relaxed">
            O evento contará com conferências plenárias, mesas redondas,
            apresentação de casos clínicos e workshops práticos.
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Informações</h2>
        <div class="space-y-4">
            @foreach([
                ['📍', 'Local',        'Luanda, República de Angola'],
                ['📅', 'Data',         '2025 — Em breve'],
                ['🌍', 'Idioma',       'Português'],
                ['💳', 'Inscrição',    'Presencial e Online'],
            ] as [$icon, $label, $value])
                <div class="flex items-start gap-3">
                    <span class="text-xl flex-shrink-0">{{ $icon }}</span>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            {{ $label }}
                        </p>
                        <p class="text-sm text-gray-800 font-medium">{{ $value }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CATEGORIAS / VALORES ── --}}
<section class="mb-12">
    <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">Categorias de Inscrição</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach([
            ['👨‍⚕️', 'Médico(a)',       'Especialistas e clínicos gerais'],
            ['🩺', 'Enfermeiro(a)',   'Profissionais de enfermagem'],
            ['🧠', 'Psicólogo(a)',    'Psicólogos clínicos e investigadores'],
            ['🎓', 'Estudante',       'Estudantes de ciências da saúde'],
            ['🏥', 'Outro',           'Outros profissionais de saúde'],
        ] as [$icon, $label, $desc])
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm
                        hover:border-blue-200 hover:shadow-md transition group">
                <span class="text-2xl block mb-3">{{ $icon }}</span>
                <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $label }}</h3>
                <p class="text-xs text-gray-500">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ── COMO FUNCIONA ── --}}
<section class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm mb-12">
    <h2 class="text-xl font-bold text-gray-900 mb-8 text-center">
        Como funciona a inscrição?
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['1', '📝', 'Preencher',   'Complete o formulário com os seus dados'],
            ['2', '📎', 'Comprovativo','Faça upload do comprovativo de pagamento'],
            ['3', '🔍', 'Análise',     'A comissão valida a sua inscrição'],
            ['4', '🏅', 'Certificado', 'Receba o certificado por email'],
        ] as [$num, $icon, $titulo, $desc])
            <div class="text-center">
                <div class="w-10 h-10 bg-blue-800 text-white rounded-full flex items-center
                            justify-center text-sm font-bold mx-auto mb-3">
                    {{ $num }}
                </div>
                <div class="text-2xl mb-2">{{ $icon }}</div>
                <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $titulo }}</h4>
                <p class="text-xs text-gray-500">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ── CTA FINAL ── --}}
<section class="bg-blue-800 rounded-2xl p-10 text-center mb-4">
    <h2 class="text-2xl font-bold text-white mb-3">
        Garanta a sua participação
    </h2>
    <p class="text-blue-200 text-sm mb-6 max-w-md mx-auto">
        As vagas são limitadas. Inscreva-se agora e faça parte deste
        marco histórico para a saúde mental em Angola.
    </p>
    <a href="{{ route('inscricao.create') }}"
       class="inline-block bg-white text-blue-900 font-bold px-10 py-3
              rounded-xl hover:bg-blue-50 transition text-sm shadow-lg">
        Inscrever-me Agora →
    </a>
</section>

@endsection
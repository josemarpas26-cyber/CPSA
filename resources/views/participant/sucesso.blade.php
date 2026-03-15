@extends('layouts.app')
@section('title', 'Inscrição Submetida')

@section('content')
<div class="max-w-lg mx-auto text-center py-16">
    <div class="text-6xl mb-6">🎉</div>
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Inscrição Submetida!</h1>
    <p class="text-gray-500 text-sm mb-8">
        A sua inscrição está em análise pela comissão organizadora.
        Receberá um email de confirmação em breve.
    </p>

    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8 text-left">
        <p class="text-xs text-blue-600 font-medium uppercase tracking-wide mb-1">
            Número de Inscrição
        </p>
        <p class="text-2xl font-bold text-blue-800 tracking-widest">
            {{ session('inscricao_numero') }}
        </p>
        <p class="text-xs text-gray-500 mt-2">
            Email de confirmação enviado para
            <strong>{{ session('inscricao_email') }}</strong>
        </p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5 text-left mb-8">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Próximos passos</h3>
        @foreach([
            ['⏳', 'A comissão irá analisar o seu comprovativo'],
            ['📧', 'Receberá um email quando a inscrição for avaliada'],
            ['🏅', 'Após aprovação, o certificado ficará disponível'],
        ] as [$icon, $text])
            <div class="flex items-start gap-3 mb-3 last:mb-0">
                <span class="text-lg">{{ $icon }}</span>
                <p class="text-sm text-gray-600">{{ $text }}</p>
            </div>
        @endforeach
    </div>

    <div class="flex gap-3 justify-center">
        <a href="{{ route('home') }}"
           class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200
                  px-5 py-2.5 rounded-lg transition">
            Voltar ao início
        </a>
        @auth
            <a href="{{ route('participant.minha-inscricao') }}"
               class="text-sm bg-blue-800 text-white font-semibold
                      px-5 py-2.5 rounded-lg hover:bg-blue-900 transition">
                Ver minha inscrição
            </a>
        @else
            <a href="{{ route('login') }}"
               class="text-sm bg-blue-800 text-white font-semibold
                      px-5 py-2.5 rounded-lg hover:bg-blue-900 transition">
                Criar conta para acompanhar
            </a>
        @endauth
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Inscrição Recebida — CPSM 2026')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">

    {{-- Ícone de sucesso --}}
    <div class="mb-6 flex justify-center">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

    <div class="text-center mb-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Inscrição recebida!</h1>
        <p class="text-gray-600">
            Obrigado pela sua inscrição no CPSM 2026. A comissão irá analisar o seu pedido e
            receberá uma resposta por email em breve.
        </p>
    </div>

    {{-- Número da inscrição --}}
    @if(session('inscricao_numero'))
    <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 px-6 py-4 text-center">
        <p class="text-xs font-medium uppercase tracking-widest text-gray-400 mb-1">Número de inscrição</p>
        <p class="text-xl font-mono font-semibold text-gray-900">{{ session('inscricao_numero') }}</p>
        @if(session('inscricao_email'))
        <p class="mt-1 text-sm text-gray-500">
            Confirmação enviada para <strong>{{ session('inscricao_email') }}</strong>
        </p>
        @endif
    </div>
    @endif

    {{-- Próximos passos --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 mb-8">
        <h2 class="text-sm font-semibold text-gray-900 mb-3">O que acontece a seguir?</h2>
        <ol class="space-y-3">
            <li class="flex gap-3 text-sm text-gray-600">
                <span class="flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">1</span>
                A comissão irá analisar o seu comprovativo de pagamento.
            </li>
            <li class="flex gap-3 text-sm text-gray-600">
                <span class="flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">2</span>
                Receberá um email de confirmação de aprovação ou pedido de esclarecimento.
            </li>
            <li class="flex gap-3 text-sm text-gray-600">
                <span class="flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">3</span>
                Após o congresso, o certificado de participação será enviado para o seu email.
            </li>
        </ol>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 underline underline-offset-2">
            Voltar à página inicial
        </a>
    </div>

</div>
@endsection
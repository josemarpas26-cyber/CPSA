{{-- resources/views/participant/minha-inscricao.blade.php --}}
{{-- Acedida via /i/{token} — sem qualquer autenticação --}}
@extends('layouts.app')

@section('title', 'Minha Inscrição — CPSA 2025')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">

    {{-- Cabeçalho --}}
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-1">Área Pessoal</p>
        <h1 class="text-2xl font-bold text-gray-900">Minha Inscrição</h1>
        <p class="mt-1 text-sm text-gray-500">
            Número: <span class="font-mono font-medium text-gray-700">{{ $inscricao->numero }}</span>
        </p>
    </div>

    {{-- Nota sobre o link --}}
    <div class="mb-6 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>
            Guarde o link desta página. É o único modo de aceder à sua inscrição e certificado,
            sem precisar de criar conta.
        </span>
    </div>

    {{-- Flash messages --}}
    @if(session('error'))
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        {{ session('error') }}
    </div>
    @endif

    {{-- Estado da inscrição --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Estado da Inscrição</h2>

        <div class="flex items-center gap-3 mb-4">
            @php
                $statusConfig = [
                    'pendente'   => ['bg-yellow-100 text-yellow-800', 'Pendente — A aguardar análise'],
                    'em_analise' => ['bg-blue-100 text-blue-800',     'Em Análise — A ser verificada pela comissão'],
                    'aprovada'   => ['bg-green-100 text-green-800',   'Aprovada'],
                    'rejeitada'  => ['bg-red-100 text-red-800',       'Rejeitada'],
                ];
                [$badgeClass, $statusText] = $statusConfig[$inscricao->status] ?? ['bg-gray-100 text-gray-800', $inscricao->status];
            @endphp
            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $badgeClass }}">
                {{ $statusText }}
            </span>
        </div>

        @if($inscricao->status === 'aprovada' && $inscricao->avaliado_em)
        <p class="text-xs text-gray-500">Aprovada em {{ $inscricao->avaliado_em->format('d/m/Y \à\s H:i') }}</p>
        @endif

        @if($inscricao->status === 'rejeitada' && $inscricao->motivo_rejeicao)
        <div class="mt-3 rounded-lg bg-red-50 border border-red-200 p-3">
            <p class="text-xs font-semibold text-red-700 mb-1">Motivo:</p>
            <p class="text-sm text-red-800">{{ $inscricao->motivo_rejeicao }}</p>
        </div>
        @endif
    </div>

    {{-- Dados pessoais --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Dados Pessoais</h2>
        <dl class="grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-2 text-sm">
            <div>
                <dt class="text-gray-400">Nome completo</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->full_name }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Email</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->email }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Contacto</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->phone }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Profissão</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->profession }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Instituição</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->institution }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Categoria</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->category_label }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Modo de participação</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->participation_mode_label }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">Província</dt>
                <dd class="font-medium text-gray-900">{{ $inscricao->province }}</dd>
            </div>
        </dl>
    </div>

    {{-- Curso --}}
    @if($inscricao->inscricaoCurso?->curso)
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Curso / Workshop</h2>
        <p class="font-medium text-gray-900">{{ $inscricao->inscricaoCurso->curso->nome }}</p>
        @if($inscricao->inscricaoCurso->curso->descricao)
        <p class="mt-1 text-sm text-gray-500">{{ $inscricao->inscricaoCurso->curso->descricao }}</p>
        @endif
    </div>
    @endif

    {{-- Comprovativo de pagamento --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Comprovativo de Pagamento</h2>
        @if($inscricao->comprovativo)
            @php
                $compStatus = [
                    'pendente'  => 'A aguardar verificação',
                    'aceite'    => 'Aceite',
                    'rejeitado' => 'Rejeitado',
                ];
            @endphp
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm text-gray-700">{{ $inscricao->comprovativo->nome_original }}</span>
                <span class="text-xs text-gray-400">({{ $compStatus[$inscricao->comprovativo->status] ?? $inscricao->comprovativo->status }})</span>
            </div>
        @else
            <p class="text-sm text-gray-500">Nenhum comprovativo registado.</p>
        @endif
    </div>

    {{-- Certificado --}}
    @if($inscricao->status === 'aprovada')
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">Certificado de Participação</h2>

        @if($inscricao->certificado)
            <p class="text-sm text-gray-600 mb-4">O seu certificado está disponível para download.</p>
            <a
                href="{{ route('inscricao.certificado', $inscricao->access_token) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white
                       hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Descarregar Certificado (PDF)
            </a>
        @else
            <div class="flex items-start gap-3 rounded-lg bg-gray-50 border border-gray-200 px-4 py-3">
                <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-gray-600">
                    O certificado ainda não foi gerado. Estará disponível nesta página após a conclusão do congresso.
                </p>
            </div>
        @endif
    </div>
    @endif

</div>
@endsection
@extends('layouts.app')
@section('title', 'Minha Inscrição')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Minha Inscrição</h1>
        <p class="text-sm text-gray-500 mt-1">
            Acompanhe o estado da sua inscrição no CPSA 2025
        </p>
    </div>

    @if(! $inscricao)
        {{-- Sem inscrição --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-sm">
            <div class="text-5xl mb-4">📋</div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Nenhuma inscrição encontrada
            </h3>
            <p class="text-sm text-gray-500 mb-6">
                Não encontrámos nenhuma inscrição associada à sua conta.
            </p>
            <a href="{{ route('inscricao.create') }}"
               class="inline-block bg-blue-800 text-white font-semibold
                      px-6 py-2.5 rounded-lg hover:bg-blue-900 transition text-sm">
                Fazer Inscrição
            </a>
        </div>

    @else
        {{-- Número e estado --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <p class="text-xs text-gray-400 mb-1 uppercase tracking-wide">
                        Número de Inscrição
                    </p>
                    <p class="text-2xl font-bold font-mono text-blue-800 tracking-wider">
                        {{ $inscricao->numero }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1.5">
                        Submetida em {{ $inscricao->created_at->format('d/m/Y \à\s H:i') }}
                    </p>
                </div>
                @include('admin.partials.status-badge', ['status' => $inscricao->status])
            </div>
        </div>

        {{-- Timeline de estado --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-6">Estado da Inscrição</h3>

            @php
                $etapas = [
                    'pendente'   => ['⏳', 'Inscrição Recebida',  'A sua inscrição foi submetida com sucesso.'],
                    'em_analise' => ['🔍', 'Em Análise',          'A comissão está a analisar o seu comprovativo.'],
                    'aprovada'   => ['✅', 'Aprovada',             'Inscrição aprovada! Bem-vindo(a) ao CPSA 2025.'],
                    'rejeitada'  => ['❌', 'Não Aprovada',         'A sua inscrição não foi aprovada.'],
                ];

                $ordemNormal    = ['pendente', 'em_analise', 'aprovada'];
                $ordemRejeitada = ['pendente', 'em_analise', 'rejeitada'];
                $ordem = $inscricao->status === 'rejeitada' ? $ordemRejeitada : $ordemNormal;

                $statusAtual = $inscricao->status;
                $posAtual    = array_search($statusAtual, $ordem);
            @endphp

            <div class="relative">
                {{-- Linha vertical --}}
                <div class="absolute left-4 top-4 bottom-4 w-px bg-gray-200"></div>

                <div class="space-y-6">
                    @foreach($ordem as $idx => $etapa)
                        @php
                            $concluida = $idx <= $posAtual;
                            $atual     = $idx === $posAtual;
                            [$icon, $titulo, $descricao] = $etapas[$etapa];
                        @endphp
                        <div class="flex items-start gap-4 relative">
                            {{-- Ícone do passo --}}
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                        flex-shrink-0 z-10 text-sm
                                        @if($atual && $etapa === 'aprovada')
                                            bg-green-500 text-white shadow-md shadow-green-200
                                        @elseif($atual && $etapa === 'rejeitada')
                                            bg-red-500 text-white shadow-md shadow-red-200
                                        @elseif($atual)
                                            bg-blue-700 text-white shadow-md shadow-blue-200
                                        @elseif($concluida)
                                            bg-green-100 text-green-600
                                        @else
                                            bg-gray-100 text-gray-400
                                        @endif">
                                {{ $concluida ? $icon : $idx + 1 }}
                            </div>

                            {{-- Conteúdo --}}
                            <div class="flex-1 pt-0.5">
                                <p class="text-sm font-semibold
                                           {{ $atual ? 'text-gray-900' : ($concluida ? 'text-gray-700' : 'text-gray-400') }}">
                                    {{ $titulo }}
                                </p>
                                @if($atual)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $descricao }}</p>

                                    {{-- Motivo de rejeição --}}
                                    @if($etapa === 'rejeitada' && $inscricao->motivo_rejeicao)
                                        <div class="mt-2 p-3 bg-red-50 rounded-lg border border-red-100">
                                            <p class="text-xs text-red-600 font-semibold mb-1">
                                                Motivo indicado
                                            </p>
                                            <p class="text-sm text-red-800">
                                                {{ $inscricao->motivo_rejeicao }}
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Timestamp --}}
                            @if($atual && $inscricao->avaliado_em && $etapa !== 'pendente')
                                <span class="text-xs text-gray-400 flex-shrink-0 pt-1">
                                    {{ $inscricao->avaliado_em->format('d/m H:i') }}
                                </span>
                            @elseif($etapa === 'pendente' && $atual)
                                <span class="text-xs text-gray-400 flex-shrink-0 pt-1">
                                    {{ $inscricao->created_at->format('d/m H:i') }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Dados da inscrição --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                Dados Submetidos
            </h3>
            <dl class="grid grid-cols-2 gap-3">
                @foreach([
                    'Instituição'  => $inscricao->instituicao,
                    'Cargo'        => $inscricao->cargo,
                    'Categoria'    => $inscricao->categoria_label,
                    'Modalidade'   => ucfirst($inscricao->tipo_participacao),
                    'Email'        => $inscricao->email,
                    'Telefone'     => $inscricao->telefone,
                ] as $label => $value)
                    <div class="bg-gray-50 rounded-lg p-3">
                        <dt class="text-xs text-gray-400 font-medium mb-0.5">{{ $label }}</dt>
                        <dd class="text-sm text-gray-800 font-medium truncate">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        {{-- Comprovativo --}}
        @if($inscricao->comprovativo)
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                    Comprovativo de Pagamento
                </h3>
                <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
                    <span class="text-2xl">📎</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">
                            {{ $inscricao->comprovativo->nome_original }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $inscricao->comprovativo->tamanho_formatado }}
                        </p>
                    </div>
                    @php
                        $statusCores = [
                            'pendente'   => 'bg-yellow-100 text-yellow-700',
                            'aceite'     => 'bg-green-100 text-green-700',
                            'rejeitado'  => 'bg-red-100 text-red-700',
                        ];
                        $statusLabels = [
                            'pendente'  => '⏳ Em análise',
                            'aceite'    => '✅ Aceite',
                            'rejeitado' => '❌ Rejeitado',
                        ];
                    @endphp
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full flex-shrink-0
                                 {{ $statusCores[$inscricao->comprovativo->status] ?? '' }}">
                        {{ $statusLabels[$inscricao->comprovativo->status] ?? '' }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Certificado --}}
        @if($inscricaoComCertificado || $inscricao->status === 'aprovada')
            <div class="rounded-2xl border p-6 shadow-sm mb-5
                        {{ $inscricaoComCertificado
                           ? 'bg-gradient-to-br from-blue-50 to-violet-50 border-blue-200'
                           : 'bg-gray-50 border-gray-100' }}">
                <div class="flex items-center gap-4">
                    <span class="text-4xl">🏅</span>
                    <div class="flex-1">
                        @if($inscricaoComCertificado)
                            <h3 class="text-sm font-semibold text-blue-900 mb-0.5">
                                Certificado Disponível
                            </h3>
                            <p class="text-xs text-blue-700">
                                Gerado em
                                {{ $inscricaoComCertificado->certificado->gerado_em?->format('d/m/Y') }}
                                · Enviado para o seu email
                            </p>
                        @else
                            <h3 class="text-sm font-semibold text-gray-700 mb-0.5">
                                Certificado a ser preparado
                            </h3>
                            <p class="text-xs text-gray-500">
                                O seu certificado será enviado por email em breve.
                            </p>
                        @endif
                    </div>
                    @if($inscricaoComCertificado)
                        <a href="{{ route('participant.certificado.download') }}"
                           class="bg-blue-800 hover:bg-blue-900 text-white text-xs
                                  font-semibold px-4 py-2.5 rounded-lg transition flex-shrink-0">
                            ⬇ Descarregar
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- Acção para inscrição rejeitada --}}
        @if($inscricao->status === 'rejeitada')
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                <p class="text-sm text-red-700 mb-4">
                    Pode submeter uma nova inscrição com o comprovativo correcto.
                </p>
                <a href="{{ route('inscricao.create') }}"
                   class="inline-block bg-red-600 text-white font-semibold
                          px-6 py-2.5 rounded-lg hover:bg-red-700 transition text-sm">
                    Nova Inscrição
                </a>
            </div>
        @endif
    @endif
</div>
@endsection
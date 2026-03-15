@extends('layouts.admin')
@section('title', $inscricao->numero)
@section('page-title', 'Detalhe da Inscrição')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Cabeçalho com número e estado --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm
                flex items-center justify-between flex-wrap gap-4">
        <div>
            <p class="text-xs text-gray-400 mb-1">Número de Inscrição</p>
            <p class="text-2xl font-bold font-mono text-blue-800 tracking-wider">
                {{ $inscricao->numero }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Submetida em {{ $inscricao->created_at->format('d/m/Y \à\s H:i') }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            @include('admin.partials.status-badge', ['status' => $inscricao->status])

            <a href="{{ route('admin.inscricoes.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200
                      px-3 py-1.5 rounded-lg transition">
                ← Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Dados do participante --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                    Dados do Participante
                </h3>
                <dl class="space-y-3">
                    @foreach([
                        'Nome completo'  => $inscricao->nome_completo,
                        'Email'          => $inscricao->email,
                        'Telefone'       => $inscricao->telefone,
                        'Instituição'    => $inscricao->instituicao,
                        'Cargo'          => $inscricao->cargo,
                        'Categoria'      => $inscricao->categoria_label,
                        'Modalidade'     => ucfirst($inscricao->tipo_participacao),
                    ] as $label => $value)
                        <div class="flex justify-between text-sm border-b border-gray-50 pb-2">
                            <dt class="text-gray-500 font-medium">{{ $label }}</dt>
                            <dd class="text-gray-800 font-medium text-right">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Comprovativo --}}
            @if($inscricao->comprovativo)
                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                        Comprovativo de Pagamento
                    </h3>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg mb-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📎</span>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $inscricao->comprovativo->nome_original }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $inscricao->comprovativo->tamanho_formatado }}
                                    · {{ strtoupper(pathinfo($inscricao->comprovativo->nome_original, PATHINFO_EXTENSION)) }}
                                </p>
                            </div>
                        </div>
                        @if($urlComprovativo)
                            <a href="{{ $urlComprovativo }}" target="_blank"
                               class="text-xs bg-blue-800 text-white px-3 py-1.5
                                      rounded-lg hover:bg-blue-900 transition font-medium">
                                Visualizar
                            </a>
                        @endif
                    </div>

                    {{-- Preview se for imagem --}}
                    @if($urlComprovativo && str_contains($inscricao->comprovativo->mime_type, 'image'))
                        <img src="{{ $urlComprovativo }}"
                             alt="Comprovativo"
                             class="w-full rounded-lg border border-gray-100 max-h-64 object-contain">
                    @endif
                </div>
            @endif

            {{-- Histórico de avaliação --}}
            @if($inscricao->avaliado_em)
                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                        Avaliação
                    </h3>
                    <div class="text-sm space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Avaliado por</span>
                            <span class="font-medium">{{ $inscricao->avaliador?->name ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Em</span>
                            <span class="font-medium">
                                {{ $inscricao->avaliado_em->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        @if($inscricao->motivo_rejeicao)
                            <div class="mt-3 p-3 bg-red-50 rounded-lg border border-red-100">
                                <p class="text-xs text-red-600 font-semibold mb-1">Motivo da rejeição</p>
                                <p class="text-sm text-red-800">{{ $inscricao->motivo_rejeicao }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Painel de acções --}}
        <div class="space-y-4">
            @if(in_array($inscricao->status, ['pendente', 'em_analise']))
                {{-- Aprovar --}}
                <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                    <h4 class="text-sm font-semibold text-green-800 mb-3">✅ Aprovar Inscrição</h4>
                    <p class="text-xs text-green-700 mb-4">
                        O participante será notificado por email.
                    </p>
                    <form method="POST"
                          action="{{ route('admin.inscricoes.aprovar', $inscricao) }}"
                          onsubmit="return confirm('Confirmar aprovação de {{ $inscricao->numero }}?')">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white
                                       text-sm font-semibold py-2 rounded-lg transition">
                            Aprovar
                        </button>
                    </form>
                </div>

                {{-- Rejeitar --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-5">
                    <h4 class="text-sm font-semibold text-red-800 mb-3">❌ Rejeitar Inscrição</h4>
                    <form method="POST"
                          action="{{ route('admin.inscricoes.rejeitar', $inscricao) }}">
                        @csrf @method('PATCH')
                        <textarea name="motivo_rejeicao" rows="3"
                                  placeholder="Motivo da rejeição (obrigatório)..."
                                  required
                                  class="w-full border border-red-200 rounded-lg px-3 py-2 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-red-400
                                         bg-white mb-3 resize-none"></textarea>
                        <button type="submit"
                                onclick="return confirm('Confirmar rejeição?')"
                                class="w-full bg-red-600 hover:bg-red-700 text-white
                                       text-sm font-semibold py-2 rounded-lg transition">
                            Rejeitar
                        </button>
                    </form>
                </div>
            @endif

            @if($inscricao->status === 'aprovada' && ! $inscricao->certificado)
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
                    <h4 class="text-sm font-semibold text-blue-800 mb-3">🏅 Certificado</h4>
                    <form method="POST"
                          action="{{ route('admin.certificados.gerar', $inscricao) }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-blue-700 hover:bg-blue-800 text-white
                                       text-sm font-semibold py-2 rounded-lg transition">
                            Gerar Certificado
                        </button>
                    </form>
                </div>
            @endif

            @if($inscricao->certificado)
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                    <h4 class="text-sm font-semibold text-gray-700 mb-1">🏅 Certificado Gerado</h4>
                    <p class="text-xs text-gray-500 mb-3">
                        {{ $inscricao->certificado->gerado_em?->format('d/m/Y H:i') }}
                    </p>
                    <a href="{{ Storage::url($inscricao->certificado->path) }}" target="_blank"
                       class="block text-center text-sm text-blue-700 hover:underline font-medium">
                        Descarregar PDF
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
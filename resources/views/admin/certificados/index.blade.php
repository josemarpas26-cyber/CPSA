@extends('layouts.admin')
@section('title', 'Certificados')
@section('page-title', 'Gestão de Certificados')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Aprovadas',     $stats['aprovadas'],  'blue',   '✅'],
        ['Com certificado',$stats['com_cert'],  'green',  '🏅'],
        ['Sem certificado',$stats['sem_cert'],  'yellow', '⏳'],
        ['Enviados',       $stats['enviados'],  'purple', '📧'],
    ] as [$label, $val, $cor, $icon])
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <span class="text-xl">{{ $icon }}</span>
                <span class="text-2xl font-bold text-gray-900">{{ $val }}</span>
            </div>
            <p class="text-xs text-gray-500 font-medium">{{ $label }}</p>
        </div>
    @endforeach
</div>

{{-- Acção em lote --}}
@if($stats['sem_cert'] > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-6
                flex items-center justify-between flex-wrap gap-4">
        <div>
            <p class="text-sm font-semibold text-yellow-800">
                {{ $stats['sem_cert'] }} inscrição(ões) sem certificado
            </p>
            <p class="text-xs text-yellow-600 mt-0.5">
                Gere todos de uma vez e envie por email automaticamente.
            </p>
        </div>
        <form method="POST" action="{{ route('admin.certificados.gerar-todos') }}"
              onsubmit="return confirm('Gerar {{ $stats['sem_cert'] }} certificado(s)?')">
            @csrf
            <button type="submit"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white
                           text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                🏅 Gerar Todos
            </button>
        </form>
    </div>
@endif

{{-- Tabela --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide border-b border-gray-100">
                    <th class="px-6 py-3 text-left font-medium">Número</th>
                    <th class="px-6 py-3 text-left font-medium">Participante</th>
                    <th class="px-6 py-3 text-left font-medium">Categoria</th>
                    <th class="px-6 py-3 text-left font-medium">Certificado</th>
                    <th class="px-6 py-3 text-left font-medium">Enviado</th>
                    <th class="px-6 py-3 text-left font-medium">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($aprovadas as $inscricao)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-mono text-xs text-blue-700 font-semibold">
                            {{ $inscricao->numero }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $inscricao->nome_completo }}</p>
                            <p class="text-xs text-gray-400">{{ $inscricao->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $inscricao->categoria_label }}</td>
                        <td class="px-6 py-4">
                            @if($inscricao->certificado)
                                <span class="inline-flex items-center gap-1 text-xs
                                             text-green-700 bg-green-50 px-2 py-1 rounded-full font-medium">
                                    ✅ Gerado
                                </span>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $inscricao->certificado->gerado_em?->format('d/m/Y H:i') }}
                                </p>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs
                                             text-yellow-700 bg-yellow-50 px-2 py-1 rounded-full font-medium">
                                    ⏳ Pendente
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($inscricao->certificado?->enviado_em)
                                <span class="text-xs text-purple-700">
                                    📧 {{ $inscricao->certificado->enviado_em->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($inscricao->certificado)
                                <a href="{{ route('admin.certificados.download',
                                              $inscricao->certificado) }}"
                                   class="text-xs text-blue-700 hover:underline font-medium">
                                    ⬇ Descarregar
                                </a>
                            @else
                                <form method="POST"
                                      action="{{ route('admin.certificados.gerar', $inscricao) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs text-green-700 hover:underline font-medium">
                                        🏅 Gerar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <p class="text-2xl mb-2">🏅</p>
                            <p class="text-sm">Nenhuma inscrição aprovada ainda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($aprovadas->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $aprovadas->links() }}
        </div>
    @endif
</div>
@endsection
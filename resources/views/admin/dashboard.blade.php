@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Cards de estatísticas --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @foreach([
        ['label' => 'Total',       'value' => $stats['total'],      'color' => 'blue',   'icon' => '📋'],
        ['label' => 'Pendentes',   'value' => $stats['pendentes'],  'color' => 'yellow', 'icon' => '⏳'],
        ['label' => 'Em Análise',  'value' => $stats['em_analise'], 'color' => 'purple', 'icon' => '🔍'],
        ['label' => 'Aprovadas',   'value' => $stats['aprovadas'],  'color' => 'green',  'icon' => '✅'],
        ['label' => 'Rejeitadas',  'value' => $stats['rejeitadas'], 'color' => 'red',    'icon' => '❌'],
    ] as $card)
    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-2xl">{{ $card['icon'] }}</span>
            <span class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</span>
        </div>
        <p class="text-xs font-medium text-gray-500">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Distribuição por categoria --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Por Categoria</h3>
        @php
            $categorias = [
                'medico'     => 'Médico(a)',
                'enfermeiro' => 'Enfermeiro(a)',
                'psicologo'  => 'Psicólogo(a)',
                'estudante'  => 'Estudante',
                'outro'      => 'Outro',
            ];
            $total = $stats['total'] ?: 1;
        @endphp
        <div class="space-y-3">
            @foreach($categorias as $key => $label)
                @php $val = $porCategoria[$key] ?? 0; @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600">{{ $label }}</span>
                        <span class="font-semibold">{{ $val }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        @php
                            $largura = round(($val/$total)*100);
                        @endphp
                        <div class="bg-blue-600 h-1.5 rounded-full transition-all"
                            style="width: {{ $largura }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Distribuição por tipo --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Por Modalidade</h3>
        <div class="space-y-4">
            @foreach(['presencial' => ['🏛️', 'Presencial', 'blue'], 'online' => ['💻', 'Online', 'purple']] as $tipo => [$icon, $label, $cor])
                @php $val = $porTipo[$tipo] ?? 0; @endphp
                <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50">
                    <span class="text-2xl">{{ $icon }}</span>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700">{{ $label }}</p>
                        <p class="text-xs text-gray-400">{{ round(($val/$total)*100) }}% do total</p>
                    </div>
                    <span class="text-xl font-bold text-gray-800">{{ $val }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Acções rápidas --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Acções Rápidas</h3>
        <div class="space-y-2">
            <a href="{{ route('admin.inscricoes.index', ['status' => 'pendente']) }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-yellow-50
                      hover:bg-yellow-100 transition group">
                <span class="text-lg">⏳</span>
                <div>
                    <p class="text-sm font-medium text-yellow-800">Pendentes</p>
                    <p class="text-xs text-yellow-600">{{ $stats['pendentes'] }} a aguardar análise</p>
                </div>
            </a>
            <a href="{{ route('admin.exportar.excel') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-green-50
                      hover:bg-green-100 transition">
                <span class="text-lg">📥</span>
                <div>
                    <p class="text-sm font-medium text-green-800">Exportar Excel</p>
                    <p class="text-xs text-green-600">Todas as inscrições</p>
                </div>
            </a>
            <a href="{{ route('admin.certificados.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg bg-blue-50
                      hover:bg-blue-100 transition">
                <span class="text-lg">🏅</span>
                <div>
                    <p class="text-sm font-medium text-blue-800">Certificados</p>
                    <p class="text-xs text-blue-600">Gerar e enviar</p>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Últimas inscrições --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700">Últimas Inscrições</h3>
        <a href="{{ route('admin.inscricoes.index') }}"
           class="text-xs text-blue-700 hover:underline font-medium">Ver todas →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3 text-left font-medium">Número</th>
                    <th class="px-6 py-3 text-left font-medium">Nome</th>
                    <th class="px-6 py-3 text-left font-medium">Categoria</th>
                    <th class="px-6 py-3 text-left font-medium">Estado</th>
                    <th class="px-6 py-3 text-left font-medium">Data</th>
                    <th class="px-6 py-3 text-left font-medium"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($ultimas as $i)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 font-mono text-xs text-blue-700 font-semibold">
                            {{ $i->numero }}
                        </td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $i->nome_completo }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $i->categoria_label }}</td>
                        <td class="px-6 py-3">
                            @include('admin.partials.status-badge', ['status' => $i->status])
                        </td>
                        <td class="px-6 py-3 text-gray-400 text-xs">
                            {{ $i->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.inscricoes.show', $i) }}"
                               class="text-xs text-blue-700 hover:underline">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">
                            Nenhuma inscrição ainda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
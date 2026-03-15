@extends('layouts.admin')
@section('title', 'Inscrições')
@section('page-title', 'Gestão de Inscrições')

@section('content')

{{-- Filtros de status --}}
<div class="flex flex-wrap gap-2 mb-5">
    @foreach([
        null        => ['Todas',      $contadores['total']],
        'pendente'  => ['Pendentes',  $contadores['pendente']],
        'em_analise'=> ['Em Análise', $contadores['em_analise']],
        'aprovada'  => ['Aprovadas',  $contadores['aprovada']],
        'rejeitada' => ['Rejeitadas', $contadores['rejeitada']],
    ] as $val => [$label, $count])
        <a href="{{ route('admin.inscricoes.index', array_merge(request()->except('status','page'), $val ? ['status' => $val] : [])) }}"
           class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-medium transition
                  {{ request('status') === $val
                     ? 'bg-blue-800 text-white'
                     : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-300' }}">
            {{ $label }}
            <span class="text-xs {{ request('status') === $val ? 'opacity-70' : 'text-gray-400' }}">
                {{ $count }}
            </span>
        </a>
    @endforeach
</div>

{{-- Barra de busca e filtros avançados --}}
<div class="bg-white rounded-xl border border-gray-100 p-4 mb-5 shadow-sm">
    <form method="GET" action="{{ route('admin.inscricoes.index') }}"
          class="flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-48">
            <label class="block text-xs text-gray-500 mb-1">Buscar</label>
            <input type="text" name="busca" value="{{ request('busca') }}"
                   placeholder="Nome, email, número ou instituição..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-xs text-gray-500 mb-1">Categoria</label>
            <select name="categoria"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todas</option>
                @foreach(['medico'=>'Médico','enfermeiro'=>'Enfermeiro','psicologo'=>'Psicólogo','estudante'=>'Estudante','outro'=>'Outro'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('categoria')===$v ? 'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs text-gray-500 mb-1">Modalidade</label>
            <select name="tipo"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todas</option>
                <option value="presencial" {{ request('tipo')==='presencial' ? 'selected':'' }}>Presencial</option>
                <option value="online"     {{ request('tipo')==='online'     ? 'selected':'' }}>Online</option>
            </select>
        </div>

        <button type="submit"
                class="bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium
                       px-4 py-2 rounded-lg transition">
            Filtrar
        </button>

        @if(request()->hasAny(['busca','categoria','tipo','status']))
            <a href="{{ route('admin.inscricoes.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2 rounded-lg
                      border border-gray-200 hover:border-gray-300 transition">
                Limpar
            </a>
        @endif
    </form>
</div>

{{-- Tabela --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide
                           border-b border-gray-100">
                    <th class="px-6 py-3 text-left font-medium">Número</th>
                    <th class="px-6 py-3 text-left font-medium">Participante</th>
                    <th class="px-6 py-3 text-left font-medium">Categoria</th>
                    <th class="px-6 py-3 text-left font-medium">Modalidade</th>
                    <th class="px-6 py-3 text-left font-medium">Estado</th>
                    <th class="px-6 py-3 text-left font-medium">Comprovativo</th>
                    <th class="px-6 py-3 text-left font-medium">Data</th>
                    <th class="px-6 py-3 text-left font-medium"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($inscricoes as $i)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-mono text-xs text-blue-700 font-semibold whitespace-nowrap">
                            {{ $i->numero }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $i->nome_completo }}</p>
                            <p class="text-xs text-gray-400">{{ $i->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $i->categoria_label }}</td>
                        <td class="px-6 py-4 text-gray-600 capitalize">{{ $i->tipo_participacao }}</td>
                        <td class="px-6 py-4">
                            @include('admin.partials.status-badge', ['status' => $i->status])
                        </td>
                        <td class="px-6 py-4">
                            @if($i->comprovativo)
                                <span class="inline-flex items-center gap-1 text-xs
                                             text-green-700 bg-green-50 px-2 py-1 rounded-full">
                                    📎 Enviado
                                </span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                            {{ $i->created_at->format('d/m/Y') }}<br>
                            <span class="text-gray-300">{{ $i->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.inscricoes.show', $i) }}"
                               class="text-xs text-blue-700 hover:underline font-medium whitespace-nowrap">
                                Ver detalhe →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            <p class="text-2xl mb-2">📭</p>
                            <p class="text-sm">Nenhuma inscrição encontrada.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if($inscricoes->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $inscricoes->links() }}
        </div>
    @endif
</div>
@endsection
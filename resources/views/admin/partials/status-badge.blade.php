@php
    $config = [
        'pendente'   => ['bg-yellow-100 text-yellow-700', '⏳ Pendente'],
        'em_analise' => ['bg-purple-100 text-purple-700', '🔍 Em Análise'],
        'aprovada'   => ['bg-green-100  text-green-700',  '✅ Aprovada'],
        'rejeitada'  => ['bg-red-100    text-red-700',    '❌ Rejeitada'],
    ];
    [$classes, $label] = $config[$status] ?? ['bg-gray-100 text-gray-500', $status];
@endphp
<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ $label }}
</span>
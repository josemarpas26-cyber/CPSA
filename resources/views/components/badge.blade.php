@props([
    'type'  => 'default',  // success | warning | danger | info | default
    'size'  => 'md',       // sm | md
])

@php
    $styles = [
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger'  => 'bg-red-100 text-red-700',
        'info'    => 'bg-blue-100 text-blue-700',
        'purple'  => 'bg-purple-100 text-purple-700',
        'default' => 'bg-gray-100 text-gray-600',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
    ];

    $classes = ($styles[$type] ?? $styles['default'])
             . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center gap-1 rounded-full font-medium {$classes}"
]) }}>
    {{ $slot }}
</span>
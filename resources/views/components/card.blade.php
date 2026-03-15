@props([
    'padding' => 'p-6',
    'class'   => '',
])

<div {{ $attributes->merge([
    'class' => "bg-white rounded-2xl border border-gray-100 shadow-sm {$padding} {$class}"
]) }}>
    {{ $slot }}
</div>
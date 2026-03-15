@props([
    'type'        => 'info',    // success | warning | danger | info
    'dismissible' => false,
    'title'       => null,
])

@php
    $styles = [
        'success' => ['bg-green-50 border-green-200', 'text-green-800', 'text-green-700', '✅'],
        'warning' => ['bg-yellow-50 border-yellow-200', 'text-yellow-800', 'text-yellow-700', '⚠️'],
        'danger'  => ['bg-red-50 border-red-200',    'text-red-800',   'text-red-700',   '❌'],
        'info'    => ['bg-blue-50 border-blue-200',  'text-blue-800',  'text-blue-700',  'ℹ️'],
    ];

    [$bg, $titleColor, $textColor, $icon] = $styles[$type] ?? $styles['info'];
@endphp

<div {{ $attributes->merge([
    'class' => "rounded-xl border p-4 {$bg}"
]) }}
    @if($dismissible) x-data="{ show: true }" x-show="show" @endif
>
    <div class="flex items-start gap-3">
        <span class="text-lg flex-shrink-0">{{ $icon }}</span>
        <div class="flex-1 min-w-0">
            @if($title)
                <p class="text-sm font-semibold {{ $titleColor }} mb-0.5">{{ $title }}</p>
            @endif
            <div class="text-sm {{ $textColor }}">{{ $slot }}</div>
        </div>
        @if($dismissible)
            <button @click="show = false"
                    class="text-gray-400 hover:text-gray-600 transition flex-shrink-0 text-lg leading-none">
                ×
            </button>
        @endif
    </div>
</div>
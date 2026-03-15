{{-- resources/views/components/card.blade.php --}}
@props([
  'padding' => '1.5rem',
])
<div {{ $attributes->merge([]) }}
     style="background:#ffffff;border:1px solid rgba(26,58,143,.09);border-radius:16px;
            box-shadow:0 1px 4px rgba(11,31,74,.07),0 0 0 1px rgba(11,31,74,.04);
            padding:{{ $padding }};">
  {{ $slot }}
</div>
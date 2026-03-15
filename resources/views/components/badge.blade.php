{{-- resources/views/components/badge.blade.php --}}
@props([
  'type'  => 'default',
  'size'  => 'md',
])
@php
  $styles = [
    'success' => 'color:#059669;background:#ecfdf5;border-color:#a7f3d0;',
    'warning' => 'color:#b45309;background:#fffbeb;border-color:#fde68a;',
    'danger'  => 'color:#be123c;background:#fff1f2;border-color:#fecdd3;',
    'info'    => 'color:#1d4ed8;background:#eff6ff;border-color:#bfdbfe;',
    'purple'  => 'color:#6d28d9;background:#f5f3ff;border-color:#ddd6fe;',
    'default' => 'color:#475569;background:#f8faff;border-color:#e2e8f0;',
  ];
  $pad = $size==='sm' ? 'padding:2px 8px;' : 'padding:3px 10px;';
  $st  = $styles[$type] ?? $styles['default'];
@endphp
<span {{ $attributes->merge([]) }}
      style="display:inline-flex;align-items:center;gap:4px;border-radius:99px;
             font-size:.7rem;font-weight:600;letter-spacing:.02em;border:1px solid;
             {{ $st }}{{ $pad }}">
  {{ $slot }}
</span>
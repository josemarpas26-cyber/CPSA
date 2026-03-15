{{-- resources/views/components/alert.blade.php --}}
@props([
  'type'        => 'info',
  'title'       => null,
  'dismissible' => false,
])
@php
  $styles = [
    'success' => ['background:#f0fdf4;border-color:#bbf7d0;','color:#166534;','background:#16a34a;'],
    'warning' => ['background:#fffbeb;border-color:#fde68a;','color:#92400e;','background:#d97706;'],
    'danger'  => ['background:#fff1f2;border-color:#fecdd3;','color:#9f1239;','background:#e11d48;'],
    'info'    => ['background:#eff6ff;border-color:#bfdbfe;','color:#1e40af;','background:#2563eb;'],
  ];
  [$bg,$tc,$dc] = $styles[$type] ?? $styles['info'];
@endphp
<div {{ $attributes->merge([]) }}
     style="display:flex;align-items:flex-start;gap:.75rem;padding:.875rem 1rem;
            border-radius:10px;border:1px solid;{{ $bg }}">
  <span style="width:7px;height:7px;border-radius:50%;flex-shrink:0;margin-top:4px;{{ $dc }}"></span>
  <div style="flex:1;">
    @if($title)
      <p style="font-size:.78rem;font-weight:700;{{ $tc }}margin:0 0 .25rem;">{{ $title }}</p>
    @endif
    <div style="font-size:.78rem;{{ $tc }}line-height:1.5;">{{ $slot }}</div>
  </div>
</div>
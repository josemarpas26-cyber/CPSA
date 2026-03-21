@extends('layouts.admin')
@section('title','Galeria')
@section('page-title','Galeria')
@section('content')
<style>
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}
  .gallery-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:1rem;
  }
  .gallery-item{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);overflow:hidden;
    box-shadow:var(--shadow-sm);
    transition:transform .2s,box-shadow .2s;
  }
  .gallery-item:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);}
  .gallery-thumb{
    height:160px;overflow:hidden;background:var(--surface);
    position:relative;
  }
  .gallery-thumb img{
    width:100%;height:100%;object-fit:cover;
    transition:transform .4s ease;
  }
  .gallery-item:hover .gallery-thumb img{transform:scale(1.05);}
  .gallery-body{padding:.875rem;}
  .gallery-actions{
    display:flex;gap:.375rem;padding:.625rem .875rem;
    border-top:1px solid var(--divider);
    background:var(--surface);
  }
  .btn-xs{
    display:inline-flex;align-items:center;gap:.25rem;
    font-size:.7rem;font-weight:600;padding:.3rem .6rem;
    border-radius:6px;border:none;cursor:pointer;
    text-decoration:none;transition:all .15s;
    font-family:var(--font-body);
  }
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;">

  {{-- Header --}}
  <div class="a1" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
      <p class="section-label" style="margin-bottom:.2rem;">Gestão</p>
      <h1 class="heading" style="font-size:1.5rem;margin:0;">Galeria</h1>
    </div>
    <a href="{{ route('admin.galeria.create') }}" class="btn-primary">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
      </svg>
      Adicionar Foto
    </a>
  </div>

{{-- Stats --}}
<div class="a2" style="display:grid;grid-template-columns:repeat(4,1fr);gap:.875rem;">
  @foreach([
    ['Total',      $stats['total'],                      'var(--blue-vivid)'],
    ['Publicados', $stats['activos'],                    'var(--success)'],
    ['Ocultos',    $stats['total'] - $stats['activos'],  'var(--text-3)'],
    ['Categorias', $stats['categorias'],                 'var(--purple)'],
  ] as [$lbl, $val, $col])
    <div style="background:var(--card);border:1px solid var(--card-border);border-radius:var(--r-lg);
                padding:1.25rem;box-shadow:var(--shadow-sm);">
      <div style="font-family:var(--font-mono);font-size:1.75rem;font-weight:600;color:{{ $col }};margin-bottom:.25rem;">{{ $val }}</div>
      <div style="font-size:.73rem;color:var(--text-3);font-weight:500;">{{ $lbl }}</div>
    </div>
  @endforeach
    </div>
</div>

<br>

  {{-- Grid de fotos --}}
  @if($items->isEmpty())
    <div class="a3" style="background:var(--card);border:1px solid var(--card-border);border-radius:var(--r-lg);
                            padding:4rem;text-align:center;box-shadow:var(--shadow-sm);">
      <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--text-4)" stroke-width="1.5"
           style="margin:0 auto 1rem;display:block;">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
      </svg>
      <p style="font-size:.88rem;font-weight:600;color:var(--text-2);">A galeria está vazia</p>
      <p style="font-size:.78rem;color:var(--text-3);margin:.375rem 0 1.25rem;">Adicione a primeira foto para começar.</p>
      <a href="{{ route('admin.galeria.create') }}" class="btn-primary">Adicionar Foto</a>
    </div>
  @else
    <div class="a3 gallery-grid">
      @foreach($items as $item)
        <div class="gallery-item">
          <div class="gallery-thumb">
            <img src="{{ $item->foto_url }}" alt="{{ $item->foto_alt ?? $item->titulo }}" loading="lazy">
            {{-- badge categoria --}}
            <div style="position:absolute;top:.5rem;left:.5rem;">
              <span style="display:inline-block;font-size:.6rem;font-weight:700;letter-spacing:.06em;
                           text-transform:uppercase;padding:.2rem .55rem;border-radius:99px;
                           background:rgba(11,31,74,.75);color:rgba(255,255,255,.9);
                           backdrop-filter:blur(6px);">
                {{ $item->categoria_label }}
              </span>
            </div>
            {{-- badge estado --}}
            @if(!$item->ativo)
              <div style="position:absolute;top:.5rem;right:.5rem;">
                <span style="display:inline-block;font-size:.6rem;font-weight:700;padding:.2rem .55rem;
                             border-radius:99px;background:rgba(190,18,60,.85);color:white;">
                  Oculto
                </span>
              </div>
            @endif
          </div>
          <div class="gallery-body">
            <p style="font-size:.82rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;
                       overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
              {{ $item->titulo }}
            </p>
            <p style="font-size:.68rem;color:var(--text-3);margin:0;">
              {{ $item->data_publicacao->format('d/m/Y') }}
            </p>
          </div>
          <div class="gallery-actions">
            <a href="{{ route('admin.galeria.edit', $item) }}"
               class="btn-xs" style="background:#eff6ff;color:var(--blue-vivid);">
              Editar
            </a>
            <form method="POST" action="{{ route('admin.galeria.toggle-ativo', $item) }}"
                  style="display:contents;">
              @csrf @method('PATCH')
              <button type="submit" class="btn-xs"
                      style="background:{{ $item->ativo ? '#f0fdf4' : '#f5f3ff' }};
                             color:{{ $item->ativo ? '#166534' : 'var(--purple)' }};">
                {{ $item->ativo ? 'Ocultar' : 'Publicar' }}
              </button>
            </form>
            <form method="POST" action="{{ route('admin.galeria.destroy', $item) }}"
                  style="display:contents;margin-left:auto;"
                  onsubmit="return confirm('Eliminar «{{ addslashes($item->titulo) }}»?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-xs"
                      style="background:#fff1f2;color:#be123c;margin-left:auto;">
                Eliminar
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    @if($items->hasPages())
      <div style="padding:.875rem 0;">{{ $items->links() }}</div>
    @endif
  @endif

</div>
@endsection
@extends('layouts.app')
@section('title','Galeria — CPSM 2026')
@section('meta-description','Galeria fotográfica do I Congresso de Psiquiatria e Saúde Mental de Angola 2026.')

@section('content')
<style>
  /* ── Galeria pública ─────────────────────── */
  .galeria-hero{
    background:linear-gradient(135deg, var(--navy) 0%, #1e3a7a 60%, #0f2d6b 100%);
    padding:5rem 0 4rem;position:relative;overflow:hidden;
  }
  .galeria-hero::before{
    content:'';position:absolute;inset:0;
    background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }
  .galeria-hero .container{position:relative;z-index:1;text-align:center;}
  .galeria-hero-label{
    display:inline-block;font-size:.65rem;font-weight:700;letter-spacing:.16em;
    text-transform:uppercase;color:rgba(180,210,255,.8);margin-bottom:1rem;
  }
  .galeria-hero h1{
    font-family:var(--font-heading);font-size:clamp(2.2rem,5vw,3.25rem);
    color:#fff;margin:0 0 1rem;line-height:1.1;
  }
  .galeria-hero p{
    font-size:1.05rem;color:rgba(210,225,255,.75);max-width:520px;margin:0 auto;
  }

  /* ── Filtros ─────────────────────────────── */
  .galeria-filters{
    display:flex;flex-wrap:wrap;gap:.5rem;
    justify-content:center;padding:2.5rem 0 2rem;
  }
  .galeria-filter-btn{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.75rem;font-weight:600;padding:.45rem 1rem;border-radius:99px;
    border:1.5px solid var(--card-border);background:var(--card);
    color:var(--text-2);cursor:pointer;text-decoration:none;
    transition:all .18s;
  }
  .galeria-filter-btn:hover,
  .galeria-filter-btn.active{
    border-color:var(--blue-vivid);background:var(--blue-vivid);color:#fff;
  }

  /* ── Grid ────────────────────────────────── */
  .galeria-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:1.25rem;
    padding-bottom:4rem;
  }
  .galeria-card{
    border-radius:var(--r-lg);overflow:hidden;
    background:var(--card);border:1px solid var(--card-border);
    box-shadow:var(--shadow-sm);
    cursor:pointer;
    transition:transform .25s,box-shadow .25s;
  }
  .galeria-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 32px rgba(11,31,74,.12);
  }
  .galeria-card-img{
    height:200px;overflow:hidden;position:relative;
  }
  .galeria-card-img img{
    width:100%;height:100%;object-fit:cover;
    transition:transform .5s ease;
  }
  .galeria-card:hover .galeria-card-img img{
    transform:scale(1.07);
  }
  .galeria-card-overlay{
    position:absolute;inset:0;
    background:linear-gradient(to top, rgba(11,31,74,.6) 0%, transparent 50%);
    opacity:0;transition:opacity .3s;
    display:flex;align-items:flex-end;padding:1rem;
  }
  .galeria-card:hover .galeria-card-overlay{opacity:1;}
  .galeria-card-overlay span{
    color:white;font-size:.72rem;font-weight:600;letter-spacing:.05em;
    display:flex;align-items:center;gap:.3rem;
  }
  .galeria-card-body{padding:1rem 1.125rem;}
  .galeria-cat-badge{
    display:inline-block;font-size:.6rem;font-weight:700;letter-spacing:.08em;
    text-transform:uppercase;padding:.2rem .55rem;border-radius:99px;
    background:rgba(37,99,235,.08);color:var(--blue-vivid);
    margin-bottom:.5rem;
  }
  .galeria-card-title{
    font-size:.88rem;font-weight:700;color:var(--text-1);
    margin:0 0 .25rem;line-height:1.35;
  }
  .galeria-card-date{font-size:.7rem;color:var(--text-3);}

  /* ── Lightbox ────────────────────────────── */
  .lightbox-overlay{
    position:fixed;inset:0;z-index:9999;
    background:rgba(7,15,36,.95);
    display:flex;align-items:center;justify-content:center;
    padding:1.5rem;
    opacity:0;pointer-events:none;
    transition:opacity .3s;
  }
  .lightbox-overlay.open{opacity:1;pointer-events:all;}
  .lightbox-inner{
    position:relative;max-width:880px;width:100%;
    display:flex;flex-direction:column;align-items:center;gap:1rem;
  }
  .lightbox-close{
    position:absolute;top:-2.5rem;right:0;
    background:none;border:none;cursor:pointer;
    color:rgba(255,255,255,.7);transition:color .18s;
  }
  .lightbox-close:hover{color:white;}
  .lightbox-img{
    max-height:75vh;max-width:100%;border-radius:var(--r-lg);
    box-shadow:0 24px 64px rgba(0,0,0,.5);
  }
  .lightbox-caption{
    text-align:center;color:rgba(210,225,255,.8);font-size:.85rem;
    max-width:600px;
  }
  .lightbox-caption strong{
    display:block;font-size:1rem;color:#fff;
    margin-bottom:.25rem;
  }

  /* ── Vazio ───────────────────────────────── */
  .galeria-empty{
    padding:5rem 1.5rem;text-align:center;
    color:var(--text-3);
  }

  /* ── Scroll reveal ───────────────────────── */
  .reveal{opacity:0;transform:translateY(20px);transition:opacity .5s,transform .5s;}
  .reveal.visible{opacity:1;transform:translateY(0);}

  @media(max-width:640px){
    .galeria-grid{grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;}
  }
</style>

{{-- Hero --}}
<section class="galeria-hero">
  <div class="container">
    <span class="galeria-hero-label">CPSM 2026 · Luanda, Angola</span>
    <h1>Galeria</h1>
    <p>Momentos registados durante o I Congresso de Psiquiatria e Saúde Mental de Angola.</p>
  </div>
</section>

{{-- Filtros --}}
<div class="container">
  <div class="galeria-filters">
    <a href="{{ route('galeria.index') }}"
       class="galeria-filter-btn {{ !$categoria ? 'active' : '' }}">
      Todas
    </a>
    @foreach($categorias as $val => $lbl)
      <a href="{{ route('galeria.index', ['categoria' => $val]) }}"
         class="galeria-filter-btn {{ $categoria === $val ? 'active' : '' }}">
        {{ $lbl }}
      </a>
    @endforeach
  </div>

  {{-- Grid --}}
  @if($items->isEmpty())
    <div class="galeria-empty">
      <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"
           style="margin:0 auto 1rem;display:block;color:var(--text-4);">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
      </svg>
      <p style="font-size:.95rem;font-weight:600;color:var(--text-2);">Nenhuma fotografia disponível.</p>
      @if($categoria)
        <a href="{{ route('galeria.index') }}"
           style="font-size:.8rem;color:var(--blue-vivid);text-decoration:underline;">
          Ver todas as categorias
        </a>
      @endif
    </div>
  @else
    <div class="galeria-grid" id="galeriaGrid">
      @foreach($items as $item)
        <div class="galeria-card reveal"
             onclick="openLightbox('{{ $item->foto_url }}','{{ addslashes($item->titulo) }}','{{ addslashes($item->descricao ?? '') }}')">
          <div class="galeria-card-img">
            <img src="{{ $item->foto_url }}"
                 alt="{{ $item->foto_alt ?? $item->titulo }}"
                 loading="lazy">
            <div class="galeria-card-overlay">
              <span>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/>
                </svg>
                Ver imagem
              </span>
            </div>
          </div>
          <div class="galeria-card-body">
            <span class="galeria-cat-badge">{{ $item->categoria_label }}</span>
            <p class="galeria-card-title">{{ $item->titulo }}</p>
            <p class="galeria-card-date">{{ $item->data_publicacao->format('d/m/Y') }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Paginação --}}
    @if($items->hasPages())
      <div style="padding:2rem 0 4rem;display:flex;justify-content:center;">
        {{ $items->links() }}
      </div>
    @endif
  @endif
</div>

{{-- Lightbox --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
  <div class="lightbox-inner">
    <button class="lightbox-close" onclick="closeLightbox()" aria-label="Fechar">
      <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
    <img class="lightbox-img" id="lightboxImg" src="" alt="">
    <div class="lightbox-caption">
      <strong id="lightboxTitle"></strong>
      <span id="lightboxDesc"></span>
    </div>
  </div>
</div>

<script>
  // Scroll reveal
  const revealEls = document.querySelectorAll('.reveal');
  const observer  = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('visible'), i * 60);
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  revealEls.forEach(el => observer.observe(el));

  // Lightbox
  function openLightbox(src, title, desc) {
    document.getElementById('lightboxImg').src   = src;
    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDesc').textContent  = desc;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }
    function closeLightbox(e) {
        // Sem evento = chamada directa (tecla Escape ou botão via onclick)
        if (!e) {
            document.getElementById('lightbox').classList.remove('open');
            document.body.style.overflow = '';
            return;
        }
        // Clique no overlay de fundo ou em qualquer filho do botão fechar
        const isOverlay = e.target === document.getElementById('lightbox');
        const isClose   = !!e.target.closest('.lightbox-close');
        if (!isOverlay && !isClose) return;

        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
  });
</script>
@endsection
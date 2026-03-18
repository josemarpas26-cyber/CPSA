@extends('layouts.app')
@section('title','Palestrantes')
@section('content')
<style>
  /* ── Hero pequeno ────────────────────────────────── */
  .speakers-hero{
    background:var(--navy);
    padding:3.5rem 2rem 3rem;
    position:relative;overflow:hidden;
    text-align:center;
  }
  .speakers-hero::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse 70% 80% at 50% 0%,rgba(37,99,235,.18),transparent 70%);
  }
  .speakers-hero-content{position:relative;z-index:1;}

  /* ── Grid & Cards ────────────────────────────────── */
  .speakers-section{max-width:1100px;margin:0 auto;padding:4rem 2rem;}
  .speakers-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
    gap:1.25rem;
  }
  .speaker-card{
    background:var(--card);
    border:1px solid var(--card-border);
    border-radius:var(--r-lg);
    overflow:hidden;
    box-shadow:var(--shadow-sm);
    transition:transform .25s cubic-bezier(.34,1.56,.64,1),box-shadow .25s;
    text-decoration:none;
    display:flex;flex-direction:column;
  }
  .speaker-card:hover{
    transform:translateY(-5px);
    box-shadow:var(--shadow-lg);
  }
  .speaker-card-img{
    height:200px;overflow:hidden;
    background:linear-gradient(135deg,var(--navy) 0%,#1e3a8a 50%,#6d28d9 100%);
    display:flex;align-items:center;justify-content:center;
    position:relative;
  }
  .speaker-card-img img{
    width:100%;height:100%;object-fit:cover;
    transition:transform .4s ease;
  }
  .speaker-card:hover .speaker-card-img img{transform:scale(1.05);}
  .speaker-avatar-lg{
    font-family:var(--font-display);font-style:italic;
    font-size:3rem;color:rgba(255,255,255,.85);font-weight:700;
  }
  .speaker-card-body{padding:1.25rem;flex:1;}
  .speaker-country-badge{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.62rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;
    color:var(--blue-vivid);background:rgba(37,99,235,.08);
    padding:.2rem .6rem;border-radius:99px;margin-bottom:.6rem;
  }
  .speaker-name{
    font-size:.95rem;font-weight:700;color:var(--text-1);
    margin:0 0 .2rem;line-height:1.3;
  }
  .speaker-esp{
    font-size:.75rem;color:var(--text-3);font-weight:500;
    margin:0 0 .5rem;
  }
  .speaker-inst{
    font-size:.73rem;color:var(--text-2);
    display:flex;align-items:center;gap:.35rem;margin:0;
  }
  .speaker-card-footer{
    padding:.875rem 1.25rem;
    border-top:1px solid var(--divider);
    display:flex;align-items:center;justify-content:space-between;
  }
  .speaker-socials{display:flex;gap:.5rem;}
  .speaker-social-link{
    width:28px;height:28px;border-radius:6px;
    background:var(--surface);border:1px solid var(--card-border);
    display:flex;align-items:center;justify-content:center;
    transition:background .18s,border-color .18s;
    color:var(--text-3);
  }
  .speaker-social-link:hover{
    background:rgba(37,99,235,.08);
    border-color:rgba(37,99,235,.2);
    color:var(--blue-vivid);
  }
  .speaker-ver-mais{
    font-size:.73rem;font-weight:600;
    color:var(--blue-vivid);
    display:flex;align-items:center;gap:.25rem;
    transition:gap .2s;
  }
  .speaker-card:hover .speaker-ver-mais{gap:.5rem;}

  /* ── Filtro / busca ──────────────────────────────── */
  .speakers-filter{
    display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;
    margin-bottom:2rem;
  }
  .filter-input{
    flex:1;min-width:220px;
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-sm);padding:.55rem .875rem;
    font-size:.83rem;font-family:var(--font-body);color:var(--text-1);
    outline:none;transition:border-color .18s,box-shadow .18s;
  }
  .filter-input:focus{
    border-color:var(--blue-vivid);
    box-shadow:0 0 0 3px rgba(37,99,235,.1);
  }
  .filter-input::placeholder{color:var(--text-4);}
  .filter-count{
    font-size:.75rem;color:var(--text-3);font-weight:500;white-space:nowrap;
  }

  /* ── Vazio ───────────────────────────────────────── */
  .speakers-empty{
    text-align:center;padding:4rem 2rem;
    grid-column:1/-1;
  }
  .speakers-empty p{font-size:.85rem;color:var(--text-3);margin:.5rem 0 0;}

  /* ── Animações ───────────────────────────────────── */
  @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .4s ease forwards;}
  .speaker-card{opacity:0;animation:fadeUp .45s ease forwards;}

  @media(max-width:640px){
    .speakers-grid{grid-template-columns:1fr 1fr;}
    .speaker-card-img{height:150px;}
  }
  @media(max-width:420px){
    .speakers-grid{grid-template-columns:1fr;}
  }
</style>

{{-- Hero --}}
<div class="speakers-hero">
  <div class="speakers-hero-content animate-in">
    <p class="section-label" style="color:rgba(255,255,255,.4);margin-bottom:.5rem;">
      CPSA 2026
    </p>
    <h1 style="font-family:var(--font-display);font-style:italic;
               font-size:clamp(1.75rem,4vw,2.5rem);color:white;margin:0 0 .75rem;">
      Palestrantes
    </h1>
    <p style="font-size:.88rem;color:rgba(255,255,255,.5);max-width:480px;
              margin:0 auto;line-height:1.7;">
      Conheça os especialistas nacionais e internacionais que irão partilhar
      o seu conhecimento no Iº Congresso de Psiquiatria e Saúde Mental em Angola.
    </p>
  </div>
</div>

{{-- Listagem --}}
<div class="speakers-section">

  {{-- Filtro --}}
  <div class="speakers-filter animate-in" style="animation-delay:.1s;">
    <input
      type="text"
      id="filterInput"
      class="filter-input"
      placeholder="Pesquisar por nome, especialidade ou país..."
      autocomplete="off"
    >
    <span class="filter-count" id="filterCount">
      {{ $speakers->count() }} palestrante{{ $speakers->count() != 1 ? 's' : '' }}
    </span>
  </div>

  {{-- Grid --}}
  <div class="speakers-grid" id="speakersGrid">
    @forelse($speakers as $i => $speaker)
      <a href="{{ route('speakers.show', $speaker) }}"
         class="speaker-card"
         style="animation-delay:{{ ($i % 8) * 0.06 }}s;"
         data-nome="{{ strtolower($speaker->nome) }}"
         data-esp="{{ strtolower($speaker->especialidade) }}"
         data-pais="{{ strtolower($speaker->pais) }}">

        {{-- Imagem / Avatar --}}
        <div class="speaker-card-img">
          @if($speaker->foto_url)
            <img src="{{ $speaker->foto_url }}" alt="{{ $speaker->nome }}" loading="lazy">
          @else
            <span class="speaker-avatar-lg">{{ $speaker->inicial }}</span>
          @endif
        </div>

        {{-- Body --}}
        <div class="speaker-card-body">
          <div class="speaker-country-badge">
            <svg width="10" height="10" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            {{ $speaker->pais }}
          </div>
          <p class="speaker-name">{{ $speaker->nome }}</p>
          <p class="speaker-esp">{{ $speaker->especialidade }}</p>
          @if($speaker->instituicao)
            <p class="speaker-inst">
              <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                   stroke="var(--text-4)" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
              {{ $speaker->instituicao }}
            </p>
          @endif
        </div>

        {{-- Footer --}}
        <div class="speaker-card-footer">
          <div class="speaker-socials">
            @if($speaker->linkedin)
              <span class="speaker-social-link" title="LinkedIn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </span>
            @endif
            @if($speaker->twitter)
              <span class="speaker-social-link" title="Twitter/X">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
              </span>
            @endif
          </div>
          <span class="speaker-ver-mais">
            Ver perfil
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </span>
        </div>
      </a>
    @empty
      <div class="speakers-empty">
        <svg width="40" height="40" fill="none" viewBox="0 0 24 24"
             stroke="var(--text-4)" stroke-width="1.5" style="margin:0 auto 1rem;display:block;">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p style="font-size:.88rem;font-weight:600;color:var(--text-2);">
          Palestrantes em breve
        </p>
        <p>A lista de palestrantes será divulgada em breve.</p>
      </div>
    @endforelse
  </div>

  {{-- Mensagem sem resultados (filtro JS) --}}
  <div id="noResults" style="display:none;text-align:center;padding:3rem 0;">
    <p style="font-size:.85rem;color:var(--text-3);">Nenhum palestrante encontrado.</p>
  </div>
</div>

<script>
  const input   = document.getElementById('filterInput');
  const grid    = document.getElementById('speakersGrid');
  const counter = document.getElementById('filterCount');
  const noRes   = document.getElementById('noResults');
  const cards   = grid ? Array.from(grid.querySelectorAll('.speaker-card')) : [];

  if (input) {
    input.addEventListener('input', function () {
      const q = this.value.toLowerCase().trim();
      let visible = 0;
      cards.forEach(function (card) {
        const match = !q
          || card.dataset.nome.includes(q)
          || card.dataset.esp.includes(q)
          || card.dataset.pais.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
      });
      counter.textContent = visible + ' palestrante' + (visible !== 1 ? 's' : '');
      noRes.style.display = visible === 0 ? 'block' : 'none';
    });
  }
</script>
@endsection
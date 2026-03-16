@extends('layouts.app')
@section('title', $speaker->nome)
@section('content')
<style>
  .speaker-detail-hero{
    background:var(--navy);
    padding:3rem 2rem;
    position:relative;overflow:hidden;
  }
  .speaker-detail-hero::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse 60% 80% at 20% 50%,rgba(37,99,235,.15),transparent 65%);
  }
  .speaker-detail-inner{
    max-width:900px;margin:0 auto;
    display:flex;gap:2.5rem;align-items:flex-start;
    position:relative;z-index:1;
  }
  .speaker-detail-avatar{
    width:140px;height:140px;border-radius:var(--r-lg);
    background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;overflow:hidden;
    box-shadow:0 8px 32px rgba(0,0,0,.25);
  }
  .speaker-detail-avatar img{
    width:140px;height:140px;object-fit:cover;
  }
  .speaker-detail-avatar-text{
    font-family:var(--font-display);font-style:italic;
    font-size:3.5rem;color:rgba(255,255,255,.85);font-weight:700;
  }
  .speaker-detail-meta{flex:1;}
  .speaker-detail-badge{
    display:inline-flex;align-items:center;gap:.35rem;
    font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
    color:rgba(255,255,255,.5);background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.1);
    padding:.25rem .75rem;border-radius:99px;margin-bottom:.875rem;
  }
  .speaker-detail-nome{
    font-family:var(--font-display);font-style:italic;
    font-size:clamp(1.6rem,3vw,2.25rem);
    color:white;margin:0 0 .35rem;line-height:1.2;
  }
  .speaker-detail-esp{
    font-size:.9rem;color:rgba(255,255,255,.6);
    font-weight:500;margin:0 0 1rem;
  }
  .speaker-detail-inst{
    display:flex;align-items:center;gap:.5rem;
    font-size:.8rem;color:rgba(255,255,255,.45);
  }
  .speaker-detail-socials{
    display:flex;gap:.5rem;margin-top:1.25rem;
  }
  .detail-social-btn{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.75rem;font-weight:600;
    padding:.4rem .875rem;border-radius:var(--r-sm);
    text-decoration:none;transition:all .2s;
    border:1px solid rgba(255,255,255,.15);
    color:rgba(255,255,255,.7);
  }
  .detail-social-btn:hover{
    background:rgba(255,255,255,.08);
    border-color:rgba(255,255,255,.3);
    color:white;
  }

  /* Body */
  .speaker-detail-body{max-width:900px;margin:3rem auto;padding:0 2rem;}
  .speaker-bio-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:2rem;box-shadow:var(--shadow-sm);
    margin-bottom:1.5rem;
  }
  .speaker-bio-text{
    font-size:.88rem;color:var(--text-2);line-height:1.85;
    white-space:pre-line;margin:0;
  }
  .speaker-contact-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.5rem;box-shadow:var(--shadow-sm);
  }
  .contact-item{
    display:flex;align-items:center;gap:.75rem;
    font-size:.83rem;color:var(--text-2);
    padding:.5rem 0;border-bottom:1px solid var(--divider);
  }
  .contact-item:last-child{border-bottom:none;}
  .contact-icon{
    width:32px;height:32px;border-radius:var(--r-sm);
    background:rgba(37,99,235,.07);
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
  }
  .contact-item a{color:var(--blue-vivid);text-decoration:none;}
  .contact-item a:hover{text-decoration:underline;}

  /* Voltar */
  .back-link{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.78rem;font-weight:600;
    color:rgba(255,255,255,.5);text-decoration:none;
    transition:color .18s;margin-bottom:1.5rem;
    position:relative;z-index:1;
  }
  .back-link:hover{color:rgba(255,255,255,.85);}

  @media(max-width:640px){
    .speaker-detail-inner{flex-direction:column;gap:1.25rem;align-items:center;text-align:center;}
    .speaker-detail-socials{justify-content:center;}
    .speaker-detail-inst{justify-content:center;}
  }
</style>

<div class="speaker-detail-hero">
  <div style="max-width:900px;margin:0 auto;position:relative;z-index:1;">
    <a href="{{ route('speakers.index') }}" class="back-link">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
           stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
      </svg>
      Todos os palestrantes
    </a>
  </div>
  <div class="speaker-detail-inner">
    {{-- Avatar --}}
    <div class="speaker-detail-avatar">
      @if($speaker->foto_url)
        <img src="{{ $speaker->foto_url }}" alt="{{ $speaker->nome }}">
      @else
        <span class="speaker-detail-avatar-text">{{ $speaker->inicial }}</span>
      @endif
    </div>

    {{-- Meta --}}
    <div class="speaker-detail-meta">
      <div class="speaker-detail-badge">
        <svg width="10" height="10" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
        </svg>
        {{ $speaker->pais }}
      </div>
      <h1 class="speaker-detail-nome">{{ $speaker->nome }}</h1>
      <p class="speaker-detail-esp">{{ $speaker->especialidade }}</p>
      @if($speaker->instituicao)
        <div class="speaker-detail-inst">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
          {{ $speaker->instituicao }}
        </div>
      @endif
      @if($speaker->linkedin || $speaker->twitter || $speaker->email)
        <div class="speaker-detail-socials">
          @if($speaker->linkedin)
            <a href="{{ $speaker->linkedin }}" target="_blank" rel="noopener"
               class="detail-social-btn">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
              LinkedIn
            </a>
          @endif
          @if($speaker->twitter)
            <a href="{{ $speaker->twitter }}" target="_blank" rel="noopener"
               class="detail-social-btn">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
              </svg>
              Twitter / X
            </a>
          @endif
        </div>
      @endif
    </div>
  </div>
</div>

<div class="speaker-detail-body">
  <div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start;">

    {{-- Biografia --}}
    @if($speaker->biografia)
      <div class="speaker-bio-card">
        <p class="section-label" style="margin-bottom:.75rem;">Biografia</p>
        <p class="speaker-bio-text">{{ $speaker->biografia }}</p>
      </div>
    @else
      <div class="speaker-bio-card" style="text-align:center;padding:3rem;">
        <p style="font-size:.85rem;color:var(--text-3);">Biografia em breve.</p>
      </div>
    @endif

    {{-- Contacto --}}
    <div class="speaker-contact-card">
      <p class="section-label" style="margin-bottom:.75rem;">Contacto & Redes</p>
      @if($speaker->email)
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                 stroke="var(--blue-brand)" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
          </div>
          <a href="mailto:{{ $speaker->email }}">{{ $speaker->email }}</a>
        </div>
      @endif
      @if($speaker->linkedin)
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="var(--blue-brand)">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </div>
          <a href="{{ $speaker->linkedin }}" target="_blank" rel="noopener">
            LinkedIn
          </a>
        </div>
      @endif
      @if($speaker->twitter)
        <div class="contact-item">
          <div class="contact-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="var(--blue-brand)">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </div>
          <a href="{{ $speaker->twitter }}" target="_blank" rel="noopener">
            Twitter / X
          </a>
        </div>
      @endif
      @if(! $speaker->email && ! $speaker->linkedin && ! $speaker->twitter)
        <p style="font-size:.78rem;color:var(--text-4);margin:0;">
          Sem contactos públicos.
        </p>
      @endif
    </div>

  </div>
</div>
@endsection
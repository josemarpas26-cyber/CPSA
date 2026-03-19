<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <style>
    @font-face {
      font-family: 'Lora';
      src: url('/fonts/Lora/static/Lora-Regular.ttf') format('truetype');
      font-weight: 400;
      font-style: normal;
    }
    @font-face {
      font-family: 'Lora';
      src: url('/fonts/Lora/static/Lora-Italic.ttf') format('truetype');
      font-weight: 400;
      font-style: italic;
    }
    @font-face {
      font-family: 'Lora';
      src: url('/fonts/Lora/static/Lora-Bold.ttf') format('truetype');
      font-weight: 700;
      font-style: normal;
    }
    @font-face {
      font-family: 'WorkSans';
      src: url('/fonts/WorkSans/static/WorkSans-Regular.ttf') format('truetype');
      font-weight: 400;
      font-style: normal;
    }
    @font-face {
      font-family: 'WorkSans';
      src: url('/fonts/WorkSans/static/WorkSans-Bold.ttf') format('truetype');
      font-weight: 700;
      font-style: normal;
    }
    @font-face {
      font-family: 'NothingYouCouldDo';
      src: url('/fonts/NothingYouCouldDo/static/NothingYouCouldDo-Regular.ttf') format('truetype');
      font-weight: 400;
      font-style: normal;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    @page {
      size: A4 landscape;
      margin: 0;
    }

    body {
      width: 297mm;
      height: 210mm;
      font-family: 'Lora', Georgia, serif;
      background: #f7f3ea;
      overflow: hidden;
      position: relative;
    }

    /* ── Background watercolor blobs ─────────────────── */
    /* Top-left pink blob */
    .blob-tl {
      position: absolute;
      top: -10mm;
      left: -8mm;
      width: 90mm;
      height: 70mm;
      background: radial-gradient(ellipse at 40% 40%,
        rgba(240, 170, 160, 0.45) 0%,
        rgba(230, 140, 130, 0.25) 40%,
        transparent 70%);
      border-radius: 50% 60% 55% 45% / 55% 45% 60% 50%;
      transform: rotate(-15deg);
      pointer-events: none;
    }

    /* Top-right pink blob */
    .blob-tr {
      position: absolute;
      top: -5mm;
      right: -5mm;
      width: 70mm;
      height: 55mm;
      background: radial-gradient(ellipse at 55% 35%,
        rgba(240, 170, 160, 0.40) 0%,
        rgba(235, 155, 145, 0.20) 45%,
        transparent 70%);
      border-radius: 45% 55% 60% 40% / 60% 40% 55% 45%;
      transform: rotate(10deg);
      pointer-events: none;
    }

    /* Bottom-left faint blob */
    .blob-bl {
      position: absolute;
      bottom: 0mm;
      left: 5mm;
      width: 65mm;
      height: 45mm;
      background: radial-gradient(ellipse at 40% 60%,
        rgba(240, 170, 160, 0.28) 0%,
        rgba(235, 155, 145, 0.12) 50%,
        transparent 75%);
      border-radius: 55% 45% 40% 60% / 45% 60% 55% 40%;
      transform: rotate(5deg);
      pointer-events: none;
    }

    /* ── Logo area (top-left) ─────────────────────────── */
    .logo-area {
      position: absolute;
      top: 10mm;
      left: 10mm;
      display: flex;
      align-items: center;
      gap: 4mm;
      z-index: 5;
    }
    .logo-img {
      width: 22mm;
      height: 22mm;
      object-fit: contain;
    }
    .logo-text-block {
      display: flex;
      flex-direction: column;
    }
    .logo-cpsm {
      font-family: 'WorkSans', sans-serif;
      font-weight: 700;
      font-size: 16pt;
      color: #1a2e5a;
      line-height: 1;
      letter-spacing: 0.04em;
    }
    .logo-angola {
      font-family: 'WorkSans', sans-serif;
      font-weight: 700;
      font-size: 10pt;
      color: #1a2e5a;
      letter-spacing: 0.15em;
      line-height: 1.2;
    }
    .logo-sub {
      font-family: 'WorkSans', sans-serif;
      font-weight: 700;
      font-size: 5pt;
      color: #1a2e5a;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      line-height: 1.3;
      max-width: 32mm;
    }

    /* ── Tagline (below logo) ─────────────────────────── */
    .tagline {
      position: absolute;
      top: 35mm;
      left: 10mm;
      font-family: 'WorkSans', sans-serif;
      font-size: 5.5pt;
      color: #4a4a4a;
      letter-spacing: 0.06em;
      z-index: 5;
    }

    /* ── Top-right gold ornament image ───────────────── */
    .ornament-tr {
      position: absolute;
      top: 3mm;
      right: 8mm;
      width: 22mm;
      height: 22mm;
      object-fit: contain;
      opacity: 0.85;
      z-index: 5;
    }

    /* ── Bottom-right animal illustration ────────────── */
    .animal-br {
      position: absolute;
      bottom: 0mm;
      right: 2mm;
      width: 48mm;
      height: 42mm;
      object-fit: contain;
      z-index: 5;
    }

    /* ── CERTIFICADO heading ──────────────────────────── */
    .cert-heading {
      position: absolute;
      top: 12mm;
      left: 0;
      right: 0;
      text-align: center;
      /* offset right slightly to avoid logo overlap */
      padding-left: 50mm;
      padding-right: 10mm;
      z-index: 3;
    }
    .cert-heading h1 {
      font-family: 'WorkSans', sans-serif;
      font-weight: 700;
      font-size: 34pt;
      color: #1a1a1a;
      letter-spacing: 0.10em;
      text-transform: uppercase;
      line-height: 1;
    }

    /* ── Body content (centered) ──────────────────────── */
    .cert-body {
      position: absolute;
      top: 50mm;
      left: 0;
      right: 0;
      text-align: center;
      padding: 0 28mm;
      z-index: 3;
    }

    .cert-concedido {
      font-family: 'Lora', serif;
      font-size: 10pt;
      color: #2a2a2a;
      letter-spacing: 0.04em;
      margin-bottom: 4mm;
      font-style: italic;
    }

    .cert-name {
      font-family: 'Lora', serif;
      font-weight: 400;
      font-size: 28pt;
      color: #1a1a1a;
      letter-spacing: 0.04em;
      line-height: 1.2;
      margin-bottom: 5mm;
      /* Small caps effect using font-variant */
      font-variant: small-caps;
    }

    .cert-course-line {
      font-family: 'Lora', serif;
      font-size: 10pt;
      color: #2a2a2a;
      font-style: italic;
      margin-bottom: 3mm;
    }

    .cert-course-title {
      font-family: 'Lora', serif;
      font-size: 10pt;
      color: #2a2a2a;
      font-style: italic;
      margin-bottom: 3mm;
      /* Underline simulating blanks */
    }

    .cert-course-blank {
      display: inline-block;
      min-width: 120mm;
      border-bottom: 1px solid #2a2a2a;
      vertical-align: bottom;
      /* blank area for course name */
    }

    .cert-hours-line {
      font-family: 'Lora', serif;
      font-size: 10pt;
      color: #2a2a2a;
      font-style: italic;
      margin-bottom: 2mm;
    }

    .cert-hours-blank {
      display: inline-block;
      width: 10mm;
      border-bottom: 1px solid #2a2a2a;
      vertical-align: bottom;
    }

    .cert-desc-line {
      font-family: 'Lora', serif;
      font-size: 10pt;
      color: #2a2a2a;
      font-style: italic;
      margin-bottom: 5mm;
    }

    /* ── Date line ────────────────────────────────────── */
    .cert-date {
      font-family: 'Lora', serif;
      font-size: 10pt;
      color: #2a2a2a;
      font-style: italic;
      margin-bottom: 3mm;
    }

    .cert-date-blank-day {
      display: inline-block;
      width: 8mm;
      border-bottom: 1px solid #2a2a2a;
      vertical-align: bottom;
    }
    .cert-date-blank-month {
      display: inline-block;
      width: 24mm;
      border-bottom: 1px solid #2a2a2a;
      vertical-align: bottom;
    }

    /* ── Script tagline ───────────────────────────────── */
    .cert-script {
      font-family: 'NothingYouCouldDo', cursive;
      font-size: 9pt;
      color: #3a3a3a;
      margin-bottom: 6mm;
      letter-spacing: 0.02em;
    }

    /* ── Signatures ───────────────────────────────────── */
    .signatures {
      position: absolute;
      bottom: 14mm;
      left: 28mm;
      right: 55mm; /* leave room for animal on right */
      display: flex;
      justify-content: space-between;
      z-index: 5;
    }
    .sig-item {
      width: 56mm;
      text-align: left;
    }
    .sig-line {
      width: 44mm;
      border-top: 1px solid #1a1a1a;
      margin-bottom: 2mm;
    }
    .sig-label {
      font-family: 'Lora', serif;
      font-size: 7pt;
      color: #2a2a2a;
      font-style: italic;
    }

    /* ── Horizontal divider under heading ────────────── */
    .divider {
      position: absolute;
      top: 46mm;
      left: 10mm;
      right: 10mm;
      border: none;
      border-top: 0.3px solid rgba(30, 30, 30, 0.15);
      z-index: 3;
    }
  </style>
</head>
<body>

  <!-- Watercolor background blobs -->
  <div class="blob-tl"></div>
  <div class="blob-tr"></div>
  <div class="blob-bl"></div>

  <!-- Logo top-left -->
  <div class="logo-area">
    {{-- Coloque o ficheiro do logótipo em: public/images/cpsm-logo.png --}}
    <img class="logo-img" src="{{ asset('images/cpsm-logo.png') }}" alt="CPSM Angola Logo">
    <div class="logo-text-block">
      <span class="logo-cpsm">CPSM</span>
      <span class="logo-angola">ANGOLA</span>
      <span class="logo-sub">I Congresso de Psiquiatria e<br>Saúde Mental em Angola</span>
    </div>
  </div>

  <!-- Tagline below logo -->
  <div class="tagline">Saúde Mental: Um Olhar &nbsp;Para o Futuro .</div>

  <!-- Gold ornament top-right -->
  {{-- Coloque o ficheiro do ornamento dourado em: public/images/ornamento-dourado.png --}}
  <img class="ornament-tr" src="{{ asset('images/ornamento-dourado.png') }}" alt="">

  <!-- Animal illustration bottom-right -->
  {{-- Coloque a ilustração do animal em: public/images/antilope-cpsm.png --}}
  <img class="animal-br" src="{{ asset('images/antilope-cpsm.png') }}" alt="">

  <!-- CERTIFICADO heading -->
  <div class="cert-heading">
    <h1>Certificado</h1>
  </div>

  <!-- Horizontal divider -->
  <hr class="divider">

  <!-- Certificate body -->
  <div class="cert-body">

    <div class="cert-concedido">Certificado concedido a</div>

    <div class="cert-name">{{ $inscricao->full_name }}</div>

    <div class="cert-course-line">
      <em>concluiu com aproveitamento o curso de</em>
    </div>

    <div class="cert-course-title">
      <em>"&nbsp;<span class="cert-course-blank">{{ $inscricao->curso_nome ?? '' }}</span>&nbsp;",</em>
    </div>

    <div class="cert-hours-line">
      <em>realizado no âmbito do Congresso, com carga horária de
      <span class="cert-hours-blank">{{ $inscricao->carga_horaria ?? '' }}</span>
      horas,</em>
    </div>

    <div class="cert-desc-line">
      <em>demonstrando elevado empenho e desempenho técnico-científico</em>
    </div>

    <div class="cert-date">
      <em>Luanda, <span class="cert-date-blank-day">{{ $inscricao->dia ?? '' }}</span>
      de <span class="cert-date-blank-month">{{ $inscricao->mes ?? '' }}</span>
      de 2026.</em>
    </div>

    <div class="cert-script">
      Psiquiatria e Saúde Mental: Uma Abordagem Integrada Para Uma Angola Mais Saudável
    </div>

  </div>

  <!-- Signatures -->
  <div class="signatures">
    <div class="sig-item">
      <div class="sig-line"></div>
      <div class="sig-label">Director</div>
    </div>
    <div class="sig-item">
      <div class="sig-line"></div>
      <div class="sig-label">Coordenador</div>
    </div>
  </div>

</body>
</html>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }

    @page {
      size: A4 landscape;
      margin: 0;
    }

    body {
      width: 297mm;
      height: 210mm;
      font-family: 'DejaVu Sans', sans-serif;
      background: #ffffff;
      overflow: hidden;
      position: relative;
    }

    /* ── Outer frame ──────────────────────────── */
    .frame-outer {
      position: absolute;
      top: 8mm; left: 8mm;
      right: 8mm; bottom: 8mm;
      border: 2px solid #0b1f4a;
      border-radius: 3px;
    }
    .frame-inner {
      position: absolute;
      top: 11mm; left: 11mm;
      right: 11mm; bottom: 11mm;
      border: 0.5px solid rgba(11,31,74,.18);
      border-radius: 2px;
    }

    /* ── Left accent bar ──────────────────────── */
    .accent-bar {
      position: absolute;
      top: 8mm; left: 8mm;
      bottom: 8mm;
      width: 14mm;
      background: linear-gradient(180deg, #0b1f4a 0%, #1a3a8f 60%, #1d4ed8 100%);
    }

    /* ── Corner ornaments ─────────────────────── */
    .corner {
      position: absolute;
      width: 12mm; height: 12mm;
      border-color: #1d4ed8;
      border-style: solid;
    }
    .corner-tl { top: 13mm; left: 25mm; border-width: 1.5px 0 0 1.5px; }
    .corner-tr { top: 13mm; right: 13mm; border-width: 1.5px 1.5px 0 0; }
    .corner-bl { bottom: 13mm; left: 25mm; border-width: 0 0 1.5px 1.5px; }
    .corner-br { bottom: 13mm; right: 13mm; border-width: 0 1.5px 1.5px 0; }

    /* ── Left bar content ─────────────────────── */
    .bar-content {
      position: absolute;
      top: 8mm; left: 8mm;
      width: 14mm;
      bottom: 8mm;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 2;
    }
    .bar-text {
      color: rgba(255,255,255,.5);
      font-size: 5pt;
      font-weight: 700;
      letter-spacing: .15em;
      text-transform: uppercase;
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      white-space: nowrap;
    }

    /* ── Main content ─────────────────────────── */
    .content {
      position: absolute;
      top: 18mm;
      left: 28mm;
      right: 16mm;
      bottom: 20mm;
    }

    /* Header row */
    .header-row {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 10mm;
      padding-bottom: 6mm;
      border-bottom: 0.5px solid rgba(11,31,74,.12);
    }
    .org-name {
      font-size: 7pt;
      font-weight: 700;
      color: #1d4ed8;
      letter-spacing: .12em;
      text-transform: uppercase;
      margin-bottom: 2mm;
    }
    .event-name {
      font-size: 11pt;
      font-weight: 700;
      color: #0b1f4a;
      line-height: 1.3;
    }
    .event-meta {
      font-size: 6.5pt;
      color: #7a8fb5;
      margin-top: 1.5mm;
    }
    .header-logo-area {
      text-align: right;
    }
    .logo-year {
      font-size: 22pt;
      font-weight: 700;
      color: rgba(11,31,74,.08);
      letter-spacing: -.02em;
      line-height: 1;
    }

    /* Certificate body */
    .cert-label {
      font-size: 7pt;
      font-weight: 700;
      color: #7a8fb5;
      letter-spacing: .18em;
      text-transform: uppercase;
      margin-bottom: 2.5mm;
    }
    .certifies-text {
      font-size: 8.5pt;
      color: #3d5080;
      margin-bottom: 3mm;
      font-style: italic;
    }
    .participant-name {
      font-size: 22pt;
      font-weight: 700;
      color: #0b1f4a;
      letter-spacing: -.02em;
      line-height: 1.1;
      margin-bottom: 4mm;
      padding-bottom: 3mm;
      border-bottom: 1.5px solid #1d4ed8;
    }
    .cert-desc {
      font-size: 8.5pt;
      color: #3d5080;
      line-height: 1.65;
      margin-bottom: 4mm;
      max-width: 180mm;
    }
    .cert-meta {
      font-size: 7pt;
      color: #7a8fb5;
    }

    /* Signatures */
    .signatures {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }
    .sig-item {
      width: 56mm;
      text-align: center;
    }
    .sig-line {
      border-top: 0.5px solid #0b1f4a;
      margin-bottom: 2mm;
    }
    .sig-name {
      font-size: 7pt;
      font-weight: 700;
      color: #0b1f4a;
    }
    .sig-role {
      font-size: 6pt;
      color: #7a8fb5;
      margin-top: 1mm;
    }

    /* Verification code */
    .verify-block {
      position: absolute;
      bottom: 14mm; right: 14mm;
      text-align: right;
    }
    .verify-label {
      font-size: 6pt;
      color: #b0bdd8;
      text-transform: uppercase;
      letter-spacing: .1em;
      margin-bottom: 1.5mm;
    }
    .verify-code {
      font-size: 7.5pt;
      font-weight: 700;
      color: #7a8fb5;
      font-family: 'Courier New', monospace;
      letter-spacing: .04em;
    }

    /* Decorative dots */
    .dot-grid {
      position: absolute;
      top: 8mm; right: 8mm;
      width: 18mm; height: 18mm;
      opacity: .07;
    }
  </style>
</head>
<body>

  <!-- Frames -->
  <div class="frame-outer"></div>
  <div class="frame-inner"></div>

  <!-- Accent bar -->
  <div class="accent-bar"></div>
  <div class="bar-content">
    <span class="bar-text">CPSA · 2025 · Angola</span>
  </div>

  <!-- Corner ornaments -->
  <div class="corner corner-tl"></div>
  <div class="corner corner-tr"></div>
  <div class="corner corner-bl"></div>
  <div class="corner corner-br"></div>

  <!-- Dot grid decoration -->
  <svg class="dot-grid" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
    @for($r=0;$r<5;$r++)
      @for($c=0;$c<5;$c++)
        <circle cx="{{ 6+$c*12 }}" cy="{{ 6+$r*12 }}" r="2" fill="#0b1f4a"/>
      @endfor
    @endfor
  </svg>

  <!-- Main content -->
  <div class="content">

    <!-- Header -->
    <div class="header-row">
      <div>
        <div class="org-name">República de Angola</div>
        <div class="event-name">
          Iº Congresso de Psiquiatria<br>e Saúde Mental em Angola
        </div>
        <div class="event-meta">Luanda, Angola · 2025 · CPSM 2026</div>
      </div>
      <div class="header-logo-area">
        <div class="logo-year">2025</div>
      </div>
    </div>

    <!-- Certificate body -->
    <div class="cert-label">Certificado de Participação</div>
    <div class="certifies-text">Certifica-se que</div>
    <div class="participant-name">{{ $inscricao->nome_completo }}</div>
    <div class="cert-desc">
      participou no <strong>Iº Congresso de Psiquiatria e Saúde Mental em Angola</strong>,
      realizado em Luanda, República de Angola, no ano de 2025, na modalidade de
      participante <strong>{{ ucfirst($inscricao->participation_mode) }}</strong>,
      na categoria de <strong>{{ $inscricao->categoria_label }}</strong>.
    </div>
    <div class="cert-meta">
      Inscrição {{ $inscricao->numero }}&nbsp;&nbsp;·&nbsp;&nbsp;Emitido em {{ now()->format('d \d\e F \d\e Y') }}
    </div>

    <!-- Signatures -->
    <div class="signatures">
      <div class="sig-item">
        <div class="sig-line"></div>
        <div class="sig-name">Presidente da Comissão Científica</div>
        <div class="sig-role">Iº Congresso de Psiquiatria e Saúde Mental em Angola</div>
      </div>
      <div class="sig-item">
        <div class="sig-line"></div>
        <div class="sig-name">Presidente da Comissão Organizadora</div>
        <div class="sig-role">Iº Congresso de Psiquiatria e Saúde Mental em Angola</div>
      </div>
    </div>
  </div>

  <!-- Verification -->
  <div class="verify-block">
    <div class="verify-label">Código de verificação</div>
    <div class="verify-code">{{ $certificado->codigo_verificacao }}</div>
  </div>

</body>
</html>
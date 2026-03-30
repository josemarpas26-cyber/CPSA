<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Inscrição Aprovada — CPSM 2026</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
         background:#f4f7ff;color:#0b1f4a;-webkit-font-smoothing:antialiased;}
    .wrapper{max-width:560px;margin:40px auto;padding:0 16px 40px;}
    .card{background:#ffffff;border-radius:16px;overflow:hidden;
          box-shadow:0 4px 24px rgba(11,31,74,.10);}
    .header{background:linear-gradient(135deg,#059669 0%,#10b981 100%);
            padding:36px 32px;text-align:center;}
    .header-mark{width:52px;height:52px;border-radius:14px;
                 background:rgba(255,255,255,.15);
                 display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;}
    .header-title{font-size:20px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px;}
    .header-sub{font-size:13px;color:rgba(255,255,255,.5);}
    .body{padding:32px;}
    .info-row{display:flex;justify-content:space-between;align-items:center;
              padding:10px 0;border-bottom:1px solid rgba(26,58,143,.06);font-size:13px;}
    .info-row:last-child{border-bottom:none;}
    .info-label{color:#7a8fb5;font-weight:500;}
    .info-val{color:#0b1f4a;font-weight:600;text-align:right;}
    .mono{font-family:'Courier New',monospace;color:#059669;font-weight:700;}
    .notice{background:#f0fdf4;border:1px solid #a7f3d0;border-radius:10px;
            padding:16px;margin-top:20px;font-size:13px;color:#047857;line-height:1.6;}
    .footer{text-align:center;padding:20px 32px 0;font-size:11.5px;color:#b0bdd8;line-height:1.7;}
  </style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <div class="header">
      <div class="header-mark">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="header-title">Inscrição Aprovada ✓</div>
      <div class="header-sub">Iº Congresso de Psiquiatria e Saúde Mental em Angola</div>
    </div>

    <div class="body">
      <p style="font-size:15px;color:#0b1f4a;margin-bottom:20px;line-height:1.6;">
        Caro(a) <strong>{{ $inscricao->full_name }}</strong>,
      </p>

      <div class="info-row">
        <span class="info-label">Número de inscrição</span>
        <span class="mono">{{ $inscricao->numero }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Categoria</span>
        <span class="info-val">{{ $inscricao->category_label }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Modalidade</span>
        <span class="info-val">{{ ucfirst($inscricao->participation_mode) }}</span>
      </div>
      @if($inscricao->inscricaoCurso?->curso)
      <div class="info-row">
        <span class="info-label">Curso inscrito</span>
        <span class="info-val">{{ $inscricao->inscricaoCurso->curso->nome }}</span>
      </div>
      @endif

      @if($inscricao->participation_mode === 'presencial')
      <div class="notice">
        <strong>Participação Presencial</strong><br>
        Por favor, apresente-se com documento de identificação no dia do evento para efectuar o check-in.
      </div>
      @else
      <div class="notice">
        <strong>Participação Online</strong><br>
        Receberá as instruções de acesso à plataforma alguns dias antes do evento.
      </div>
      @endif
    </div>

    <div class="footer">
      © {{ date('Y') }} CPSM 2026 · Luanda, Angola
    </div>
  </div>
</div>
</body>
</html>
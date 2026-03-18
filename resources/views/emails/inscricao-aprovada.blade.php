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
    .header{background:linear-gradient(135deg,#059669 0%,#0d9488 100%);
            padding:36px 32px;text-align:center;}
    .header-mark{width:48px;height:48px;border-radius:12px;
                 background:rgba(255,255,255,.15);
                 display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;}
    .header-title{font-size:20px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px;}
    .header-sub{font-size:13px;color:rgba(255,255,255,.55);}
    .body{padding:32px;}
    .numero-box{background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;
                padding:20px;text-align:center;margin:20px 0;}
    .numero-label{font-size:11px;font-weight:700;text-transform:uppercase;
                  letter-spacing:.1em;color:#059669;margin-bottom:6px;}
    .numero-val{font-family:'Courier New',monospace;font-size:22px;
                font-weight:700;color:#047857;letter-spacing:.04em;}
    .divider{height:1px;background:rgba(26,58,143,.07);margin:20px 0;}
    .info-row{display:flex;justify-content:space-between;padding:8px 0;
              border-bottom:1px solid rgba(26,58,143,.05);font-size:13px;}
    .info-row:last-child{border-bottom:none;}
    .info-label{color:#7a8fb5;font-weight:500;}
    .info-val{color:#0b1f4a;font-weight:600;}
    .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;
           border-radius:99px;font-size:11px;font-weight:700;}
    .highlight{background:#f0fdf4;border-left:3px solid #059669;border-radius:0 8px 8px 0;
               padding:14px 16px;margin-top:20px;font-size:13px;color:#166534;line-height:1.6;}
    .footer{text-align:center;padding:20px 32px 0;font-size:11.5px;color:#b0bdd8;line-height:1.7;}
  </style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <div class="header">
      <div class="header-mark">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="header-title">Inscrição Aprovada</div>
      <div class="header-sub">Iº Congresso de Psiquiatria e Saúde Mental em Angola</div>
    </div>

    <div class="body">
      <p style="font-size:15px;color:#0b1f4a;margin-bottom:14px;line-height:1.6;">
        Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,
      </p>
      <p style="font-size:14px;color:#3d5080;line-height:1.65;margin-bottom:0;">
        Temos o prazer de informar que a sua inscrição foi <strong>aprovada</strong>
        pela comissão organizadora. Bem-vindo(a) ao CPSM 2026!
      </p>

      <div class="numero-box">
        <div class="numero-label">Número de inscrição</div>
        <div class="numero-val">{{ $inscricao->numero }}</div>
      </div>

      <div class="divider"></div>

      <div class="info-row">
        <span class="info-label">Modalidade</span>
        <span class="info-val">{{ ucfirst($inscricao->participation_mode) }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Categoria</span>
        <span class="info-val">{{ $inscricao->categoria_label }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Estado</span>
        <span class="badge" style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;">
          <span style="width:5px;height:5px;border-radius:50%;background:#059669;"></span>
          Aprovada
        </span>
      </div>

      <div class="highlight">
        O certificado de participação será enviado por este email após o evento.
        Guarde o seu número de inscrição para acesso no dia do congresso.
      </div>
    </div>

    <div class="footer">
      © {{ date('Y') }} CPSM 2026 · Luanda, Angola
    </div>
  </div>
</div>
</body>
</html>
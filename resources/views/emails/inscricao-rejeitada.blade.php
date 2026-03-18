<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Inscrição Não Aprovada — CPSM 2026</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
         background:#f4f7ff;color:#0b1f4a;-webkit-font-smoothing:antialiased;}
    .wrapper{max-width:560px;margin:40px auto;padding:0 16px 40px;}
    .card{background:#ffffff;border-radius:16px;overflow:hidden;
          box-shadow:0 4px 24px rgba(11,31,74,.10);}
    .header{background:linear-gradient(135deg,#9f1239 0%,#be123c 100%);
            padding:36px 32px;text-align:center;}
    .header-mark{width:48px;height:48px;border-radius:12px;
                 background:rgba(255,255,255,.12);
                 display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;}
    .header-title{font-size:20px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px;}
    .header-sub{font-size:13px;color:rgba(255,255,255,.5);}
    .body{padding:32px;}
    .motivo-box{background:#fff1f2;border-left:3px solid #be123c;border-radius:0 8px 8px 0;
                padding:16px;margin:20px 0;}
    .motivo-label{font-size:11px;font-weight:700;text-transform:uppercase;
                  letter-spacing:.1em;color:#be123c;margin-bottom:8px;}
    .motivo-text{font-size:13.5px;color:#9f1239;line-height:1.65;}
    .footer{text-align:center;padding:20px 32px 0;font-size:11.5px;color:#b0bdd8;line-height:1.7;}
    .note{background:#f4f7ff;border-radius:8px;padding:14px 16px;
          font-size:12.5px;color:#7a8fb5;line-height:1.6;margin-top:16px;}
  </style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <div class="header">
      <div class="header-mark">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="header-title">Inscrição Não Aprovada</div>
      <div class="header-sub">Iº Congresso de Psiquiatria e Saúde Mental em Angola</div>
    </div>

    <div class="body">
      <p style="font-size:15px;color:#0b1f4a;margin-bottom:14px;line-height:1.6;">
        Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,
      </p>
      <p style="font-size:14px;color:#3d5080;line-height:1.65;margin-bottom:16px;">
        Lamentamos informar que a sua inscrição
        <strong style="font-family:'Courier New',monospace;">{{ $inscricao->numero }}</strong>
        não foi aprovada pela comissão organizadora.
      </p>

      @if($inscricao->motivo_rejeicao)
        <div class="motivo-box">
          <div class="motivo-label">Motivo indicado</div>
          <div class="motivo-text">{{ $inscricao->motivo_rejeicao }}</div>
        </div>
      @endif

      <div class="note">
        Se tiver dúvidas ou quiser submeter um novo comprovativo,
        entre em contacto com a organização do CPSM 2026.
      </div>
    </div>

    <div class="footer">
      © {{ date('Y') }} CPSM 2026 · Luanda, Angola
    </div>
  </div>
</div>
</body>
</html>
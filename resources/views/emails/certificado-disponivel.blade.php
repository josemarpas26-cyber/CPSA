<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Certificado Disponível — CPSM 2026</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
         background:#f4f7ff;color:#0b1f4a;-webkit-font-smoothing:antialiased;}
    .wrapper{max-width:560px;margin:40px auto;padding:0 16px 40px;}
    .card{background:#ffffff;border-radius:16px;overflow:hidden;
          box-shadow:0 4px 24px rgba(11,31,74,.10);}
    .header{background:linear-gradient(135deg,#1d4ed8 0%,#6d28d9 100%);
            padding:36px 32px;text-align:center;}
    .header-mark{width:56px;height:56px;border-radius:16px;
                 background:rgba(255,255,255,.15);
                 display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;}
    .header-title{font-size:20px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px;}
    .header-sub{font-size:13px;color:rgba(255,255,255,.5);}
    .body{padding:32px;}
    .cert-box{background:linear-gradient(135deg,#f0f6ff,#f5f3ff);
              border:1px solid #ddd6fe;border-radius:12px;
              padding:24px;text-align:center;margin:20px 0;}
    .cert-box-label{font-size:11px;font-weight:700;text-transform:uppercase;
                    letter-spacing:.1em;color:#6d28d9;margin-bottom:8px;}
    .cert-box-num{font-family:'Courier New',monospace;font-size:20px;
                  font-weight:700;color:#1d4ed8;letter-spacing:.06em;margin-bottom:6px;}
    .cert-box-sub{font-size:12px;color:#7a8fb5;}
    .code-box{background:#f4f7ff;border-radius:8px;padding:12px 16px;
              margin-top:16px;display:flex;align-items:center;justify-content:space-between;}
    .code-label{font-size:11px;color:#7a8fb5;font-weight:500;}
    .code-val{font-family:'Courier New',monospace;font-size:13px;
              font-weight:600;color:#0b1f4a;letter-spacing:.06em;}
    .footer{text-align:center;padding:20px 32px 0;font-size:11.5px;color:#b0bdd8;line-height:1.7;}
  </style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <div class="header">
      <div class="header-mark">
        <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
        </svg>
      </div>
      <div class="header-title">O seu Certificado está disponível</div>
      <div class="header-sub">1º Congresso de Psiquiatria e Saúde Mental em Angola</div>
    </div>

    <div class="body">
      <p style="font-size:15px;color:#0b1f4a;margin-bottom:14px;line-height:1.6;">
        Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,
      </p>
      <p style="font-size:14px;color:#3d5080;line-height:1.65;margin-bottom:0;">
        O seu certificado de participação no
        <strong>1º Congresso de Psiquiatria e Saúde Mental em Angola</strong>
        está em anexo neste email, em formato PDF.
      </p>

      <div class="cert-box">
        <div class="cert-box-label">Inscrição</div>
        <div class="cert-box-num">{{ $inscricao->numero }}</div>
        <div class="cert-box-sub">O certificado está em anexo a este email.</div>
      </div>

      <div class="code-box">
        <span class="code-label">Código de verificação</span>
        <span class="code-val">{{ $certificado->codigo_verificacao }}</span>
      </div>
    </div>

    <div class="footer">
      © {{ date('Y') }} CPSM 2026 · Luanda, Angola
    </div>
  </div>
</div>
</body>
</html>
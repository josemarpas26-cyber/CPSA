<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Inscrição Confirmada — CPSM 2026</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
         background:#f4f7ff;color:#0b1f4a;-webkit-font-smoothing:antialiased;}
    .wrapper{max-width:560px;margin:40px auto;padding:0 16px 40px;}
    .card{background:#ffffff;border-radius:16px;overflow:hidden;
          box-shadow:0 4px 24px rgba(11,31,74,.10);}
    .header{background:linear-gradient(135deg,#0b1f4a 0%,#1a3a8f 100%);
            padding:36px 32px;text-align:center;}
    .header-mark{width:52px;height:52px;border-radius:14px;
                 background:rgba(255,255,255,.12);
                 display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;}
    .header-title{font-size:20px;font-weight:700;color:#fff;line-height:1.2;margin-bottom:6px;}
    .header-sub{font-size:13px;color:rgba(255,255,255,.5);}
    .body{padding:32px;}
    .num-box{
      background:linear-gradient(135deg,#eff6ff,#f5f3ff);
      border:1px solid #bfdbfe;border-radius:12px;
      padding:20px 24px;text-align:center;margin:20px 0;
    }
    .num-label{font-size:11px;font-weight:700;text-transform:uppercase;
               letter-spacing:.1em;color:#1d4ed8;margin-bottom:8px;}
    .num-val{font-family:'Courier New',monospace;font-size:22px;
             font-weight:700;color:#0b1f4a;letter-spacing:.06em;}
    .info-row{display:flex;justify-content:space-between;align-items:center;
              padding:10px 0;border-bottom:1px solid rgba(26,58,143,.06);font-size:13px;}
    .info-row:last-child{border-bottom:none;}
    .info-label{color:#7a8fb5;font-weight:500;}
    .info-val{color:#0b1f4a;font-weight:600;text-align:right;}
    .notice{background:#fffbeb;border:1px solid #fde68a;border-radius:10px;
            padding:14px 16px;margin-top:20px;font-size:13px;color:#92400e;line-height:1.6;}
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
      <div class="header-title">Inscrição Recebida</div>
      <div class="header-sub">Iº Congresso de Psiquiatria e Saúde Mental em Angola</div>
    </div>

    <div class="body">
      <p style="font-size:15px;color:#0b1f4a;margin-bottom:14px;line-height:1.6;">
        Caro(a) <strong>{{ $inscricao->full_name }}</strong>,
      </p>
      <p style="font-size:14px;color:#3d5080;line-height:1.65;margin-bottom:0;">
        A sua inscrição no <strong>Iº Congresso de Psiquiatria e Saúde Mental em Angola</strong>
        foi recebida com sucesso. A comissão organizadora irá verificar o seu comprovativo
        de pagamento e receberá uma resposta por email em breve.
      </p>

      <div class="num-box">
        <div class="num-label">Número de inscrição</div>
        <div class="num-val">{{ $inscricao->numero }}</div>
      </div>

      <div class="info-row">
        <span class="info-label">Nome</span>
        <span class="info-val">{{ $inscricao->full_name }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-val">{{ $inscricao->email }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Categoria</span>
        <span class="info-val">{{ $inscricao->category_label }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Participação</span>
        <span class="info-val">{{ ucfirst($inscricao->participation_mode) }}</span>
      </div>
      @if($inscricao->inscricaoCurso?->curso)
      <div class="info-row">
        <span class="info-label">Curso</span>
        <span class="info-val">{{ $inscricao->inscricaoCurso->curso->nome }}</span>
      </div>
      @endif

      <div class="notice">
        Em caso de dúvida, responda a este email ou contacte-nos através de
        <strong>geral@cpsm2026.ao</strong>.
      </div>
    </div>

    <div class="footer">
      © {{ date('Y') }} CPSM 2026 · Luanda, Angola
    </div>
  </div>
</div>
</body>
</html>
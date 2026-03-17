<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nova Inscrição — CPSM 2026</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
         background:#f4f7ff;color:#0b1f4a;-webkit-font-smoothing:antialiased;}
    .wrapper{max-width:560px;margin:40px auto;padding:0 16px 40px;}
    .card{background:#ffffff;border-radius:16px;overflow:hidden;
          box-shadow:0 4px 24px rgba(11,31,74,.10);}
    .header{background:#0b1f4a;padding:28px 32px;display:flex;align-items:center;gap:14px;}
    .header-dot{width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;
                animation:pulse 2s infinite;}
    .header-title{font-size:16px;font-weight:700;color:#fff;}
    .header-sub{font-size:12px;color:rgba(255,255,255,.45);margin-top:2px;}
    .body{padding:28px 32px;}
    .info-row{display:flex;justify-content:space-between;align-items:center;
              padding:10px 0;border-bottom:1px solid rgba(26,58,143,.06);font-size:13px;}
    .info-row:last-child{border-bottom:none;}
    .info-label{color:#7a8fb5;font-weight:500;}
    .info-val{color:#0b1f4a;font-weight:600;text-align:right;max-width:300px;}
    .mono{font-family:'Courier New',monospace;color:#1d4ed8;font-weight:700;}
    .cta{display:block;text-align:center;background:#1d4ed8;color:#fff;
         font-size:13.5px;font-weight:700;padding:14px 24px;border-radius:8px;
         text-decoration:none;margin-top:20px;}
    .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;
           border-radius:99px;font-size:11px;font-weight:700;}
    .footer{text-align:center;padding:16px 32px 0;font-size:11px;color:#b0bdd8;}
  </style>
</head>
<body>
<div class="wrapper">
  <div class="card">
    <div class="header">
      <div class="header-dot"></div>
      <div>
        <div class="header-title">Nova inscrição recebida</div>
        <div class="header-sub">Requer análise pela comissão organizadora</div>
      </div>
    </div>

    <div class="body">
      <div class="info-row">
        <span class="info-label">Número</span>
        <span class="mono">{{ $inscricao->numero }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Nome</span>
        <span class="info-val">{{ $inscricao->nome_completo }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-val" style="color:#1d4ed8;">{{ $inscricao->email }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Instituição</span>
        <span class="info-val">{{ $inscricao->instituicao }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Categoria</span>
        <span class="info-val">{{ $inscricao->categoria_label }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Modalidade</span>
        <span class="info-val">{{ ucfirst($inscricao->tipo_participacao) }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Comprovativo</span>
        <span class="badge" style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;">
          <span style="width:5px;height:5px;border-radius:50%;background:#059669;"></span>
          Enviado
        </span>
      </div>

      <a href="{{ route('admin.inscricoes.show',$inscricao) }}" class="cta">
        Analisar inscrição no painel
      </a>
    </div>

    <div class="footer">CPSM 2026 — Sistema de Gestão de Inscrições</div>
  </div>
</div>
</body>
</html>
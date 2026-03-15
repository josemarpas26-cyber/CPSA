<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; background: #f9fafb; margin:0; padding:0; }
        .container { max-width:600px; margin:32px auto; background:#fff;
                     border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        .header { background: #10b981; padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:20px; }
        .header p  { color:#d1fae5; margin:8px 0 0; font-size:13px; }
        .body { padding:32px; }
        .numero { background:#d1fae5; border:2px dashed #10b981; border-radius:8px;
                  text-align:center; padding:16px; margin:24px 0; }
        .numero strong { font-size:22px; color:#059669; letter-spacing:2px; }
        .info-row { display:flex; justify-content:space-between;
                    border-bottom:1px solid #f3f4f6; padding:10px 0; font-size:14px; }
        .badge-success { display:inline-block; background:#d1fae5; color:#059669;
                         border-radius:999px; padding:2px 12px; font-size:12px; font-weight:600; }
        .footer { background:#f9fafb; padding:20px 32px; text-align:center;
                  font-size:12px; color:#9ca3af; }
        .btn { display:inline-block; background:#1e40af; color:#fff; padding:12px 28px;
               border-radius:8px; text-decoration:none; font-weight:600; font-size:14px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>✅ Inscrição Aprovada</h1>
        <p>1º Congresso de Psiquiatria e Saúde Mental em Angola</p>
    </div>
    <div class="body">
        <p>Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,</p>
        <p>
            Temos o prazer de informar que a sua inscrição foi
            <strong>aprovada</strong> pela comissão organizadora.
            Bem-vindo(a) ao CPSA 2025!
        </p>

        <div class="numero">
            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Número de inscrição</div>
            <strong>{{ $inscricao->numero }}</strong>
        </div>

        <div class="info-row">
            <span style="color:#6b7280;">Modalidade</span>
            <span>{{ ucfirst($inscricao->tipo_participacao) }}</span>
        </div>
        <div class="info-row">
            <span style="color:#6b7280;">Categoria</span>
            <span>{{ $inscricao->categoria_label }}</span>
        </div>
        <div class="info-row">
            <span style="color:#6b7280;">Estado</span>
            <span class="badge-success">Aprovada</span>
        </div>

        <div style="margin-top:28px;padding:16px;background:#eff6ff;border-radius:8px;">
            <p style="font-size:13px;color:#1e40af;margin:0;font-weight:600;">
                📅 Informações do evento
            </p>
            <p style="font-size:13px;color:#374151;margin:8px 0 0;">
                O certificado de participação será enviado por este email após o evento.
                Guarde o seu número de inscrição para acesso no dia do congresso.
            </p>
        </div>
    </div>
    <div class="footer">
        © {{ date('Y') }} CPSA 2025 — Luanda, Angola
    </div>
</div>
</body>
</html>
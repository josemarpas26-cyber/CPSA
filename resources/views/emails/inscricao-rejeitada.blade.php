<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family:Arial,sans-serif; color:#333; background:#f9fafb; margin:0; padding:0; }
        .container { max-width:600px; margin:32px auto; background:#fff;
                     border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        .header { background:#ef4444; padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:20px; }
        .header p  { color:#fecaca; margin:8px 0 0; font-size:13px; }
        .body { padding:32px; }
        .motivo { background:#fee2e2; border-left:4px solid #ef4444;
                  border-radius:0 8px 8px 0; padding:16px; margin:20px 0; }
        .footer { background:#f9fafb; padding:20px 32px; text-align:center;
                  font-size:12px; color:#9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Inscrição Não Aprovada</h1>
        <p>1º Congresso de Psiquiatria e Saúde Mental em Angola</p>
    </div>
    <div class="body">
        <p>Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,</p>
        <p>
            Lamentamos informar que a sua inscrição
            <strong>{{ $inscricao->numero }}</strong>
            não foi aprovada pela comissão organizadora.
        </p>

        @if($inscricao->motivo_rejeicao)
        <div class="motivo">
            <p style="font-size:12px;color:#b91c1c;font-weight:600;margin:0 0 6px;">
                Motivo indicado
            </p>
            <p style="font-size:14px;color:#374151;margin:0;">
                {{ $inscricao->motivo_rejeicao }}
            </p>
        </div>
        @endif

        <p style="font-size:13px;color:#6b7280;">
            Se tiver dúvidas ou quiser submeter um novo comprovativo,
            entre em contacto com a organização.
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} CPSA 2025 — Luanda, Angola
    </div>
</div>
</body>
</html>
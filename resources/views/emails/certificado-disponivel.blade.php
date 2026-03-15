<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family:Arial,sans-serif; color:#333; background:#f9fafb; margin:0; padding:0; }
        .container { max-width:600px; margin:32px auto; background:#fff;
                     border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        .header { background:linear-gradient(135deg,#1e40af,#7c3aed); padding:32px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:20px; }
        .header p  { color:#bfdbfe; margin:8px 0 0; font-size:13px; }
        .body { padding:32px; }
        .cert-box { background:#eff6ff; border:2px solid #bfdbfe; border-radius:10px;
                    padding:20px; text-align:center; margin:24px 0; }
        .footer { background:#f9fafb; padding:20px; text-align:center;
                  font-size:12px; color:#9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div style="font-size:36px;margin-bottom:8px;">🏅</div>
        <h1>O seu Certificado está pronto!</h1>
        <p>1º Congresso de Psiquiatria e Saúde Mental em Angola</p>
    </div>
    <div class="body">
        <p>Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,</p>
        <p>
            É com prazer que enviamos o seu certificado de participação no
            <strong>1º Congresso de Psiquiatria e Saúde Mental em Angola</strong>.
        </p>

        <div class="cert-box">
            <p style="font-size:12px;color:#6b7280;margin:0 0 4px;">Inscrição</p>
            <p style="font-size:20px;font-weight:bold;color:#1e40af;font-family:monospace;margin:0;">
                {{ $inscricao->numero }}
            </p>
            <p style="font-size:12px;color:#6b7280;margin:8px 0 0;">
                O certificado está anexado a este email em formato PDF.
            </p>
        </div>

        <p style="font-size:13px;color:#6b7280;">
            Código de verificação:
            <strong style="font-family:monospace;color:#374151;">
                {{ $certificado->codigo_verificacao }}
            </strong>
        </p>
    </div>
    <div class="footer">© {{ date('Y') }} CPSA 2025 — Luanda, Angola</div>
</div>
</body>
</html>
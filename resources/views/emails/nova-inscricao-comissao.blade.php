<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family:Arial,sans-serif; color:#333; background:#f9fafb; margin:0; }
        .container { max-width:600px; margin:32px auto; background:#fff;
                     border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        .header { background:#1e40af; padding:28px 32px; }
        .header h1 { color:#fff; margin:0; font-size:18px; }
        .header p  { color:#bfdbfe; margin:4px 0 0; font-size:12px; }
        .body { padding:28px 32px; }
        .info-row { display:flex; justify-content:space-between;
                    border-bottom:1px solid #f3f4f6; padding:9px 0; font-size:13px; }
        .label { color:#6b7280; }
        .btn { display:inline-block; background:#1e40af; color:#fff; padding:11px 24px;
               border-radius:8px; text-decoration:none; font-weight:bold; font-size:13px;
               margin-top:20px; }
        .footer { background:#f9fafb; padding:16px 32px; text-align:center;
                  font-size:11px; color:#9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🔔 Nova inscrição recebida</h1>
        <p>Requer análise pela comissão organizadora</p>
    </div>
    <div class="body">
        <div class="info-row">
            <span class="label">Número</span>
            <strong style="font-family:monospace;color:#1e40af;">
                {{ $inscricao->numero }}
            </strong>
        </div>
        <div class="info-row">
            <span class="label">Nome</span>
            <span>{{ $inscricao->nome_completo }}</span>
        </div>
        <div class="info-row">
            <span class="label">Email</span>
            <span>{{ $inscricao->email }}</span>
        </div>
        <div class="info-row">
            <span class="label">Categoria</span>
            <span>{{ $inscricao->categoria_label }}</span>
        </div>
        <div class="info-row">
            <span class="label">Modalidade</span>
            <span>{{ ucfirst($inscricao->tipo_participacao) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Comprovativo</span>
            <span style="color:#10b981;font-weight:600;">✅ Enviado</span>
        </div>

        <a href="{{ route('admin.inscricoes.show', $inscricao) }}" class="btn">
            Analisar Inscrição →
        </a>
    </div>
    <div class="footer">
        CPSA 2025 — Sistema de Gestão de Inscrições
    </div>
</div>
</body>
</html>
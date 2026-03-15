<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; background: #f9fafb; }
        .container { max-width: 600px; margin: 32px auto; background: #fff;
                     border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .header { background: #1e40af; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 20px; }
        .header p  { color: #bfdbfe; margin: 8px 0 0; font-size: 13px; }
        .body   { padding: 32px; }
        .numero { background: #dbeafe; border: 2px dashed #1e40af; border-radius: 8px;
                  text-align: center; padding: 16px; margin: 24px 0; }
        .numero strong { font-size: 22px; color: #1e40af; letter-spacing: 2px; }
        .info-row { display: flex; justify-content: space-between;
                    border-bottom: 1px solid #f3f4f6; padding: 10px 0; font-size: 14px; }
        .label { color: #6b7280; }
        .badge { display: inline-block; background: #fef3c7; color: #d97706;
                 border-radius: 999px; padding: 2px 12px; font-size: 12px; font-weight: 600; }
        .footer { background: #f9fafb; padding: 20px 32px; text-align: center;
                  font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>1º Congresso de Psiquiatria e Saúde Mental em Angola</h1>
        <p>Inscrição recebida com sucesso</p>
    </div>
    <div class="body">
        <p>Caro(a) <strong>{{ $inscricao->nome_completo }}</strong>,</p>
        <p>A sua inscrição foi recebida e encontra-se em análise pela comissão organizadora.
           Receberá uma notificação assim que for avaliada.</p>

        <div class="numero">
            <div style="font-size:12px;color:#6b7280;margin-bottom:4px;">Número de inscrição</div>
            <strong>{{ $inscricao->numero }}</strong>
        </div>

        <div class="info-row">
            <span class="label">Nome</span>
            <span>{{ $inscricao->nome_completo }}</span>
        </div>
        <div class="info-row">
            <span class="label">Categoria</span>
            <span>{{ $inscricao->categoria_label }}</span>
        </div>
        <div class="info-row">
            <span class="label">Participação</span>
            <span>{{ ucfirst($inscricao->tipo_participacao) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Estado</span>
            <span class="badge">Pendente</span>
        </div>

        <p style="margin-top:24px;font-size:13px;color:#6b7280;">
            Guarde este email. O número de inscrição será necessário para aceder
            à sua área de participante.
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} CPSA 2025 — Luanda, Angola<br>
        Este é um email automático, não responda directamente.
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9pt; color: #333; }

        .header {
            background: #1e40af;
            color: #fff;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 4px;
        }
        .header h1 { font-size: 13pt; font-weight: bold; }
        .header p  { font-size: 8pt; color: #bfdbfe; margin-top: 2px; }

        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 8pt;
            color: #6b7280;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #1e40af;
            color: #fff;
        }

        thead th {
            padding: 7px 8px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
        }

        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:nth-child(odd)  { background: #ffffff; }

        tbody td {
            padding: 7px 8px;
            font-size: 8pt;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .assinatura-col {
            width: 40mm;
            border-bottom: 1px dashed #9ca3af !important;
            height: 12px;
        }

        .footer {
            margin-top: 16px;
            text-align: center;
            font-size: 7pt;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Lista de Presença — CPSA 2025</h1>
        <p>1º Congresso de Psiquiatria e Saúde Mental em Angola · Luanda, Angola</p>
    </div>

    <div class="meta">
        <span>Total de participantes aprovados: <strong>{{ $inscricoes->count() }}</strong></span>
        <span>Gerada em: {{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:6mm">#</th>
                <th style="width:18mm">Nº Inscrição</th>
                <th>Nome Completo</th>
                <th style="width:22mm">Instituição</th>
                <th style="width:16mm">Categoria</th>
                <th style="width:18mm">Modalidade</th>
                <th style="width:40mm">Assinatura</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscricoes as $index => $inscricao)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-family: monospace; color: #1e40af; font-weight: bold;">
                        {{ $inscricao->numero }}
                    </td>
                    <td>
                        <strong>{{ $inscricao->nome_completo }}</strong><br>
                        <span style="color:#9ca3af; font-size:7pt;">{{ $inscricao->cargo }}</span>
                    </td>
                    <td>{{ Str::limit($inscricao->instituicao, 22) }}</td>
                    <td>{{ $inscricao->categoria_label }}</td>
                    <td>{{ ucfirst($inscricao->tipo_participacao) }}</td>
                    <td class="assinatura-col"></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        CPSA 2025 — Documento gerado automaticamente pelo sistema de gestão de inscrições.
    </div>

</body>
</html>
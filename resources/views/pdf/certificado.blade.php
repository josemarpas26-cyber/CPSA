<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            width: 297mm;
            height: 210mm;
            font-family: 'DejaVu Sans', sans-serif;
            background: #fff;
            overflow: hidden;
        }

        /* ── Bordas decorativas ── */
        .border-outer {
            position: absolute;
            top: 6mm; left: 6mm;
            right: 6mm; bottom: 6mm;
            border: 3px solid #1e40af;
            border-radius: 4px;
        }

        .border-inner {
            position: absolute;
            top: 9mm; left: 9mm;
            right: 9mm; bottom: 9mm;
            border: 1px solid #93c5fd;
            border-radius: 3px;
        }

        /* ── Faixa superior ── */
        .header-band {
            position: absolute;
            top: 12mm; left: 12mm; right: 12mm;
            height: 28mm;
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-band h1 {
            color: #ffffff;
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
        }

        .header-band p {
            color: #bfdbfe;
            font-size: 8pt;
            text-align: center;
            margin-top: 3px;
        }

        /* ── Corpo ── */
        .body {
            position: absolute;
            top: 46mm; left: 20mm; right: 20mm;
            text-align: center;
        }

        .certifica-text {
            font-size: 10pt;
            color: #6b7280;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 6mm;
        }

        .nome {
            font-size: 26pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 6mm;
            letter-spacing: 1px;
            border-bottom: 2px solid #dbeafe;
            padding-bottom: 4mm;
        }

        .descricao {
            font-size: 10pt;
            color: #374151;
            line-height: 1.7;
            margin-bottom: 8mm;
        }

        .descricao strong {
            color: #1e40af;
        }

        .meta {
            font-size: 8pt;
            color: #9ca3af;
            margin-bottom: 8mm;
        }

        /* ── Assinaturas ── */
        .assinaturas {
            position: absolute;
            bottom: 20mm;
            left: 20mm; right: 20mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .assinatura {
            text-align: center;
            width: 55mm;
        }

        .assinatura .linha {
            border-top: 1px solid #374151;
            margin-bottom: 2mm;
        }

        .assinatura .cargo {
            font-size: 7pt;
            color: #6b7280;
        }

        .assinatura .nome-ass {
            font-size: 8pt;
            font-weight: bold;
            color: #374151;
        }

        /* ── Código de verificação ── */
        .codigo {
            position: absolute;
            bottom: 14mm;
            right: 14mm;
            text-align: right;
        }

        .codigo p {
            font-size: 6pt;
            color: #9ca3af;
        }

        .codigo strong {
            font-size: 7pt;
            color: #6b7280;
            font-family: monospace;
        }

        /* ── Ornamentos ── */
        .ornamento-esq {
            position: absolute;
            top: 12mm; left: 12mm;
            width: 12mm; height: 28mm; /* igual à altura da faixa */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .medalha {
            position: absolute;
            top: 48mm;
            left: 50%;
            margin-left: -8mm;
            font-size: 18pt;
        }
    </style>
</head>
<body>

    {{-- Bordas --}}
    <div class="border-outer"></div>
    <div class="border-inner"></div>

    {{-- Faixa superior --}}
    <div class="header-band">
        <div>
            <h1>1º CONGRESSO DE PSIQUIATRIA E SAÚDE MENTAL EM ANGOLA</h1>
            <p>Luanda, Angola · 2025 · CPSA 2025</p>
        </div>
    </div>

    {{-- Medalha central --}}
    <div class="medalha">🏅</div>

    {{-- Corpo do certificado --}}
    <div class="body" style="top: 56mm;">
        <p class="certifica-text">Certifica-se que</p>

        <p class="nome">{{ $inscricao->nome_completo }}</p>

        <p class="descricao">
            participou do <strong>1º Congresso de Psiquiatria e Saúde Mental em Angola</strong>,
            realizado em Luanda, República de Angola, no ano de 2025,<br>
            na modalidade de participante <strong>{{ ucfirst($inscricao->tipo_participacao) }}</strong>,
            na categoria de <strong>{{ $inscricao->categoria_label }}</strong>.
        </p>

        <p class="meta">
            Inscrição Nº {{ $inscricao->numero }}
            &nbsp;·&nbsp;
            Emitido em {{ now()->format('d \d\e F \d\e Y') }}
        </p>
    </div>

    {{-- Assinaturas --}}
    <div class="assinaturas">
        <div class="assinatura">
            <div class="linha"></div>
            <p class="nome-ass">Presidente da Comissão Científica</p>
            <p class="cargo">1º Congresso de Psiquiatria e Saúde Mental em Angola</p>
        </div>

        <div class="assinatura">
            <div class="linha"></div>
            <p class="nome-ass">Presidente da Comissão Organizadora</p>
            <p class="cargo">1º Congresso de Psiquiatria e Saúde Mental em Angola</p>
        </div>
    </div>

    {{-- Código de verificação --}}
    <div class="codigo">
        <p>Código de verificação</p>
        <strong>{{ $certificado->codigo_verificacao }}</strong>
    </div>

</body>
</html>
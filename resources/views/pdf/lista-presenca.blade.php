<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 8.5pt;
      color: #0b1f4a;
    }

    /* ── Header ──────────────────────────────── */
    .doc-header {
      background: #0b1f4a;
      color: white;
      padding: 12px 16px;
      margin-bottom: 14px;
      border-radius: 4px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }
    .doc-title { font-size: 13pt; font-weight: 700; margin-bottom: 2px; }
    .doc-sub   { font-size: 7pt; color: rgba(255,255,255,.5); }
    .doc-meta  { font-size: 7pt; color: rgba(255,255,255,.4); text-align: right; }

    /* ── Info bar ─────────────────────────────── */
    .info-bar {
      display: flex;
      justify-content: space-between;
      font-size: 7.5pt;
      color: #7a8fb5;
      margin-bottom: 12px;
      padding-bottom: 8px;
      border-bottom: 0.5px solid rgba(11,31,74,.12);
    }

    /* ── Table ───────────────────────────────── */
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead tr {
      background: #0b1f4a;
    }
    thead th {
      padding: 7px 8px;
      text-align: left;
      font-size: 6.5pt;
      font-weight: 700;
      color: rgba(255,255,255,.65);
      text-transform: uppercase;
      letter-spacing: .08em;
    }
    tbody tr:nth-child(even) { background: #f8faff; }
    tbody tr:nth-child(odd)  { background: #ffffff; }
    tbody td {
      padding: 7px 8px;
      font-size: 8pt;
      border-bottom: 0.5px solid rgba(11,31,74,.06);
      vertical-align: middle;
    }
    .num-cell {
      font-size: 7pt;
      color: #7a8fb5;
      text-align: center;
      width: 8mm;
    }
    .insc-cell {
      font-family: 'Courier New', monospace;
      font-size: 7.5pt;
      font-weight: 700;
      color: #1d4ed8;
      width: 22mm;
    }
    .name-cell { font-weight: 600; }
    .name-sub  { font-size: 6.5pt; color: #7a8fb5; margin-top: 1px; }
    .sig-cell  {
      width: 42mm;
      border-bottom: 0.5px dashed #b0bdd8 !important;
      height: 10px;
    }

    /* ── Footer ──────────────────────────────── */
    .doc-footer {
      margin-top: 16px;
      text-align: center;
      font-size: 7pt;
      color: #b0bdd8;
    }

    /* ── Badge ───────────────────────────────── */
    .badge {
      display: inline-block;
      padding: 1px 6px;
      border-radius: 99px;
      font-size: 6.5pt;
      font-weight: 700;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="doc-header">
    <div>
      <div class="doc-title">Lista de Presença</div>
      <div class="doc-sub">Iº Congresso de Psiquiatria e Saúde Mental em Angola · CPSM 2026</div>
    </div>
    <div class="doc-meta">
      Gerada em {{ now()->format('d/m/Y H:i') }}<br>
      Luanda, República de Angola
    </div>
  </div>

  <!-- Info bar -->
  <div class="info-bar">
    <span>Total de participantes aprovados: <strong>{{ $inscricoes->count() }}</strong></span>
    <span>Documento oficial — uso exclusivo da organização</span>
  </div>

  <!-- Table -->
  <table>
    <thead>
      <tr>
        <th class="num-cell">#</th>
        <th style="width:22mm;">Nº Inscrição</th>
        <th>Nome Completo</th>
        <th style="width:28mm;">Instituição</th>
        <th style="width:18mm;">Categoria</th>
        <th style="width:16mm;">Modalidade</th>
        <th style="width:42mm;">Assinatura</th>
      </tr>
    </thead>
    <tbody>
      @foreach($inscricoes as $idx => $inscricao)
        <tr>
          <td class="num-cell">{{ $idx+1 }}</td>
          <td class="insc-cell">{{ $inscricao->numero }}</td>
          <td>
            <div class="name-cell">{{ $inscricao->nome_completo }}</div>
            <div class="name-sub">{{ $inscricao->cargo }}</div>
          </td>
          <td style="font-size:7.5pt;">{{ Str::limit($inscricao->instituicao, 24) }}</td>
          <td style="font-size:7.5pt;">{{ $inscricao->categoria_label }}</td>
          <td>
            <span class="badge"
                  style="{{ $inscricao->tipo_participacao==='presencial'
                    ? 'background:#eff6ff;color:#1d4ed8;'
                    : 'background:#f5f3ff;color:#6d28d9;' }}">
              {{ ucfirst($inscricao->tipo_participacao) }}
            </span>
          </td>
          <td class="sig-cell"></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Footer -->
  <div class="doc-footer">
    CPSM 2026 — Lista de presença gerada automaticamente pelo sistema de gestão de inscrições.<br>
    Documento confidencial — não reproduzir sem autorização.
  </div>

</body>
</html>
@extends('layouts.admin')
@section('title','Certificados')
@section('page-title','Certificados')
@section('content')
<style>
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}

  /* Checkbox customizado */
  .cert-check{
    width:16px;height:16px;accent-color:var(--blue-vivid);cursor:pointer;
    flex-shrink:0;
  }
  .row-selected td{ background:rgba(37,99,235,.04) !important; }

  /* Barra de acções em massa */
  #bulk-bar{
    display:none;
    position:sticky;bottom:1rem;z-index:50;
    background:var(--navy);color:white;
    border-radius:var(--r-lg);padding:.875rem 1.25rem;
    box-shadow:0 8px 32px rgba(11,31,74,.35);
    align-items:center;gap:1rem;flex-wrap:wrap;
    margin-top:1rem;
    animation:fadeUp .25s ease;
  }
  #bulk-bar.visible{ display:flex; }
  #bulk-count{
    font-size:.82rem;font-weight:700;
    background:rgba(255,255,255,.15);padding:.25rem .75rem;
    border-radius:99px;white-space:nowrap;
  }
  .bulk-btn{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.78rem;font-weight:700;
    padding:.5rem 1rem;border-radius:var(--r-sm);
    border:none;cursor:pointer;transition:all .18s;
    font-family:var(--font-body);white-space:nowrap;
  }
  .bulk-btn-primary{background:var(--blue-vivid);color:white;}
  .bulk-btn-primary:hover{background:#1d4ed8;}
  .bulk-btn-cancel{background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);}
  .bulk-btn-cancel:hover{background:rgba(255,255,255,.18);color:white;}

  /* Estado do botão gerar — bloqueado se não aprovada */
  .btn-gerar-bloqueado{
    font-size:.73rem;font-weight:600;color:var(--text-4);
    cursor:not-allowed;
    display:inline-flex;align-items:center;gap:.3rem;
  }
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;">

  {{-- Header --}}
  <div class="a1" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
      <p class="section-label" style="margin-bottom:.2rem;">Gestão</p>
      <h1 class="heading" style="font-size:1.5rem;margin:0;">Certificados</h1>
    </div>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
      {{-- Gerar todos pendentes --}}
      @if($stats['sem_cert'] > 0)
        <form method="POST" action="{{ route('admin.certificados.gerar-todos') }}"
              onsubmit="return confirm('Gerar {{ $stats['sem_cert'] }} certificado(s) em lote?')">
          @csrf
          <button type="submit" class="btn-secondary" style="font-size:.75rem;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Gerar todos pendentes ({{ $stats['sem_cert'] }})
          </button>
        </form>
      @endif

      {{-- Descarregar todos --}}
      @if($stats['com_cert'] > 0)
        <a href="{{ route('admin.certificados.download-todos') }}"
           class="btn-primary" style="font-size:.75rem;">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
          </svg>
          Descarregar todos ({{ $stats['com_cert'] }})
        </a>
      @endif
    </div>
  </div>

  {{-- Stats --}}
  <div class="a2" style="display:grid;grid-template-columns:repeat(4,1fr);gap:.875rem;">
    @php
      $cs = [
        ['Aprovadas',       $stats['aprovadas'], '#1d4ed8', '#eff6ff'],
        ['Com Certificado', $stats['com_cert'],  '#059669', '#ecfdf5'],
        ['Sem Certificado', $stats['sem_cert'],  '#b45309', '#fffbeb'],
        ['Enviados',        $stats['enviados'],  '#6d28d9', '#f5f3ff'],
      ];
    @endphp
    @foreach($cs as [$lbl,$val,$col,$bg])
      <div style="background:var(--card);border:1px solid var(--card-border);border-radius:var(--r-lg);
                  padding:1.25rem;box-shadow:var(--shadow-sm);">
        <div style="font-family:var(--font-mono);font-size:1.75rem;font-weight:600;
                    color:{{ $col }};margin-bottom:.25rem;">{{ $val }}</div>
        <div style="font-size:.73rem;color:var(--text-3);font-weight:500;">{{ $lbl }}</div>
      </div>
    @endforeach
  </div>

  {{-- Alerta pendentes --}}
  @if($stats['sem_cert'] > 0)
    <div class="a2" style="background:var(--warning-bg);border:1px solid #fde68a;
                            border-radius:var(--r-md);padding:1rem 1.25rem;
                            display:flex;align-items:center;gap:.875rem;">
      <div style="width:8px;height:8px;border-radius:50%;background:var(--warning);
                  flex-shrink:0;animation:pulseRing 2s infinite;"></div>
      <div>
        <p style="font-size:.8rem;font-weight:600;color:var(--warning);margin:0 0 .2rem;">
          {{ $stats['sem_cert'] }} inscrição(ões) aprovada(s) ainda sem certificado
        </p>
        <p style="font-size:.72rem;color:#92400e;margin:0;">
          Utilize o botão "Gerar todos" para processar em lote.
        </p>
      </div>
    </div>
  @endif

  {{-- Tabela com checkboxes --}}
  <form id="bulk-form" method="POST" action="{{ route('admin.certificados.download-massa') }}">
    @csrf
    <div class="a3" style="background:var(--card);border:1px solid var(--card-border);
                            border-radius:var(--r-lg);box-shadow:var(--shadow-sm);overflow:hidden;">
      <div style="overflow-x:auto;">
        <table class="data-table" style="width:100%;">
          <thead>
            <tr>
              {{-- Checkbox seleccionar todos --}}
              <th style="width:40px;padding-left:1.25rem;">
                <input type="checkbox" class="cert-check" id="check-all"
                       title="Seleccionar todos"
                       onchange="toggleAll(this)">
              </th>
              <th><span class="section-label">Número</span></th>
              <th><span class="section-label">Participante</span></th>
              <th><span class="section-label">Categoria</span></th>
              <th><span class="section-label">Certificado</span></th>
              <th><span class="section-label">Estado</span></th>
              <th><span class="section-label">Acção</span></th>
            </tr>
          </thead>
          <tbody>
            @forelse($aprovadas as $insc)
              <tr id="row-{{ $insc->id }}" class="{{ $insc->certificado ? '' : '' }}">

                {{-- Checkbox — só activo se tiver certificado --}}
                <td style="padding-left:1.25rem;width:40px;">
                  @if($insc->certificado)
                    <input type="checkbox"
                           name="certificado_ids[]"
                           value="{{ $insc->certificado->id }}"
                           class="cert-check row-check"
                           onchange="updateBulkBar()">
                  @else
                    <input type="checkbox" class="cert-check" disabled
                           title="Gere o certificado primeiro"
                           style="opacity:.3;">
                  @endif
                </td>

                <td>
                  <span class="mono" style="font-size:.71rem;font-weight:600;color:var(--blue-vivid);">
                    {{ $insc->numero }}
                  </span>
                </td>

                <td>
                  <div style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $insc->full_name }}</div>
                  <div style="font-size:.7rem;color:var(--text-3);">{{ $insc->email }}</div>
                </td>

                <td>
                  <span style="font-size:.75rem;color:var(--text-2);">{{ $insc->category_label }}</span>
                </td>

                <td>
                  @if($insc->certificado)
                    <div>
                      <span class="status-badge" style="color:var(--success);background:var(--success-bg);border-color:#a7f3d0;">
                        <span class="status-dot" style="background:var(--success);"></span>Gerado
                      </span>
                      <div style="font-size:.68rem;color:var(--text-3);margin-top:.2rem;">
                        {{ $insc->certificado->gerado_em?->format('d/m/Y H:i') }}
                      </div>
                    </div>
                  @else
                    <span class="status-badge" style="color:var(--warning);background:var(--warning-bg);border-color:#fde68a;">
                      <span class="status-dot" style="background:var(--warning);"></span>Pendente
                    </span>
                  @endif
                </td>

                {{-- Enviado por email? --}}
                <td>
                  @if($insc->certificado?->enviado_em)
                    <span style="font-size:.72rem;color:var(--purple);font-weight:500;">
                      Enviado {{ $insc->certificado->enviado_em->format('d/m/Y') }}
                    </span>
                  @else
                    <span style="font-size:.72rem;color:var(--text-4);">—</span>
                  @endif
                </td>

                {{-- Acções --}}
                <td>
                  <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;">
                    @if($insc->certificado)
                      {{-- Descarregar — abre em nova aba --}}
                      <a href="{{ route('admin.certificados.download', $insc->certificado) }}"
                         target="_blank"
                         rel="noopener"
                         style="font-size:.73rem;font-weight:600;color:var(--blue-vivid);
                                text-decoration:none;display:inline-flex;align-items:center;gap:.25rem;">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Ver PDF
                      </a>
                    @else
                      {{-- Gerar --}}
                      <form method="POST"
                            action="{{ route('admin.certificados.gerar', $insc) }}"
                            style="display:inline;">
                        @csrf
                        <button type="submit"
                                style="background:none;border:none;cursor:pointer;
                                       font-size:.73rem;font-weight:600;color:var(--success);
                                       padding:0;display:inline-flex;align-items:center;gap:.25rem;
                                       font-family:var(--font-body);">
                          <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                               stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                          </svg>
                          Gerar
                        </button>
                      </form>
                    @endif
                  </div>
                </td>

              </tr>
            @empty
              <tr>
                <td colspan="7" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">
                  Nenhuma inscrição aprovada.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($aprovadas->hasPages())
        <div style="padding:.875rem 1.25rem;border-top:1px solid var(--divider);">
          {{ $aprovadas->links() }}
        </div>
      @endif
    </div>

    {{-- Barra de acções em massa (aparece ao seleccionar) --}}
    <div id="bulk-bar">
      <span id="bulk-count">0 seleccionados</span>
      <button type="submit" class="bulk-btn bulk-btn-primary">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Descarregar seleccionados (ZIP)
      </button>
      <button type="button" class="bulk-btn bulk-btn-cancel" onclick="clearSelection()">
        Cancelar selecção
      </button>
    </div>
  </form>

</div>

<script>
  function getChecked() {
    return document.querySelectorAll('.row-check:checked');
  }

  function updateBulkBar() {
    const checked = getChecked();
    const bar     = document.getElementById('bulk-bar');
    const count   = document.getElementById('bulk-count');
    const total   = checked.length;

    count.textContent = total + (total === 1 ? ' seleccionado' : ' seleccionados');
    bar.classList.toggle('visible', total > 0);

    /* Destacar linha seleccionada */
    document.querySelectorAll('.row-check').forEach(function(cb) {
      const row = cb.closest('tr');
      if (row) row.classList.toggle('row-selected', cb.checked);
    });

    /* Estado do "seleccionar todos" */
    const all   = document.querySelectorAll('.row-check:not(:disabled)');
    const check = document.getElementById('check-all');
    if (check) {
      check.indeterminate = total > 0 && total < all.length;
      check.checked = total > 0 && total === all.length;
    }
  }

  function toggleAll(master) {
    document.querySelectorAll('.row-check:not(:disabled)').forEach(function(cb) {
      cb.checked = master.checked;
    });
    updateBulkBar();
  }

  function clearSelection() {
    document.querySelectorAll('.row-check').forEach(function(cb) { cb.checked = false; });
    const check = document.getElementById('check-all');
    if (check) { check.checked = false; check.indeterminate = false; }
    updateBulkBar();
  }
</script>
@endsection
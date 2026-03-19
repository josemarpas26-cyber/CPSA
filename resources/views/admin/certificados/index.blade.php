@extends('layouts.admin')
@section('title','Certificados')
@section('page-title','Certificados')
@section('content')
<style>
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;">

  {{-- Header --}}
  <div class="a1" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
      <p class="section-label" style="margin-bottom:.2rem;">Gestão</p>
      <h1 class="heading" style="font-size:1.5rem;margin:0;">Certificados</h1>
    </div>
    @if($stats['sem_cert']>0)
      <form method="POST" action="{{ route('admin.certificados.gerar-todos') }}"
            onsubmit="return confirm('Gerar {{ $stats['sem_cert'] }} certificado(s)?')"
        @csrf
        <button type="submit" class="btn-primary">
          Gerar todos pendentes ({{ $stats['sem_cert'] }})
        </button>
      </form>
    @endif
  </div>

  {{-- Stats row --}}
  <div class="a2" style="display:grid;grid-template-columns:repeat(4,1fr);gap:.875rem;">
    @php
      $cs=[
        ['Aprovadas',$stats['aprovadas'],'#1d4ed8','#eff6ff'],
        ['Com Certificado',$stats['com_cert'],'#059669','#ecfdf5'],
        ['Sem Certificado',$stats['sem_cert'],'#b45309','#fffbeb'],
        ['Enviados',$stats['enviados'],'#6d28d9','#f5f3ff'],
      ];
    @endphp
    @foreach($cs as [$lbl,$val,$col,$bg])
      <div style="background:var(--card);border:1px solid var(--card-border);border-radius:var(--r-lg);
                  padding:1.25rem;box-shadow:var(--shadow-sm);">
        <div style="font-family:var(--font-mono);font-size:1.75rem;font-weight:600;color:{{ $col }};margin-bottom:.25rem;">
          {{ $val }}
        </div>
        <div style="font-size:.73rem;color:var(--text-3);font-weight:500;">{{ $lbl }}</div>
      </div>
    @endforeach
  </div>

  {{-- Alert if pending --}}
  @if($stats['sem_cert']>0)
    <div class="a2" style="background:var(--warning-bg);border:1px solid #fde68a;
                            border-radius:var(--r-md);padding:1rem 1.25rem;
                            display:flex;align-items:center;gap:.875rem;">
      <div style="width:8px;height:8px;border-radius:50%;background:var(--warning);flex-shrink:0;
                  animation:pulseRing 2s infinite;"></div>
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

  {{-- Table --}}
  <div class="a3" style="background:var(--card);border:1px solid var(--card-border);
                          border-radius:var(--r-lg);box-shadow:var(--shadow-sm);overflow:hidden;">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th><span class="section-label">Número</span></th>
            <th><span class="section-label">Participante</span></th>
            <th><span class="section-label">Categoria</span></th>
            <th><span class="section-label">Certificado</span></th>
            <th><span class="section-label">Enviado</span></th>
            <th><span class="section-label">Acção</span></th>
          </tr>
        </thead>
        <tbody>
          @forelse($aprovadas as $insc)
            <tr>
              <td><span class="mono" style="font-size:.71rem;font-weight:600;color:var(--blue-vivid);">{{ $insc->numero }}</span></td>
              <td>
                <div style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $insc->full_name }}</div>
                <div style="font-size:.7rem;color:var(--text-3);">{{ $insc->email }}</div>
              </td>
              <td><span style="font-size:.75rem;color:var(--text-2);">{{ $insc->category_label }}</span></td>
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
              <td>
                @if($insc->certificado?->enviado_em)
                  <span style="font-size:.72rem;color:var(--purple);font-weight:500;">
                    {{ $insc->certificado->enviado_em->format('d/m/Y') }}
                  </span>
                @else
                  <span style="font-size:.72rem;color:var(--text-4);">—</span>
                @endif
              </td>
              <td>
                @if($insc->certificado)
                  <a href="{{ route('admin.certificados.download',$insc->certificado) }}"
                     style="font-size:.73rem;font-weight:600;color:var(--blue-vivid);text-decoration:none;">
                    Descarregar
                  </a>
                @else
                  <form method="POST" action="{{ route('admin.certificados.gerar',$insc) }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                            style="background:none;border:none;cursor:pointer;font-size:.73rem;
                                   font-weight:600;color:var(--success);padding:0;">
                      Gerar
                    </button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="6" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">Nenhuma inscrição aprovada.</td></tr>
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

</div>
@endsection
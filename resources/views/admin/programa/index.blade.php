@extends('layouts.admin')
@section('title','Programa')
@section('page-title','Programa do Congresso')
@section('content')
<style>
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .a1{opacity:0;animation:fadeUp .4s ease .04s forwards;}
  .a2{opacity:0;animation:fadeUp .4s ease .10s forwards;}
  .a3{opacity:0;animation:fadeUp .4s ease .16s forwards;}
  .tipo-badge{
    display:inline-flex;align-items:center;padding:.2rem .6rem;
    border-radius:99px;font-size:.65rem;font-weight:700;letter-spacing:.03em;
    white-space:nowrap;
  }
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;">

  {{-- Header --}}
  <div class="a1" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
      <p class="section-label" style="margin-bottom:.2rem;">Gestão</p>
      <h1 class="heading" style="font-size:1.5rem;margin:0;">Programa do Congresso</h1>
    </div>
    <a href="{{ route('admin.programa.create') }}" class="btn-primary">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
      </svg>
      Nova Actividade
    </a>
  </div>

  {{-- Stats por dia --}}
  <div class="a2" style="display:grid;grid-template-columns:repeat(3,1fr);gap:.875rem;">
    @foreach([
      ['2026-08-13', 'Dia 1', 'Quarta, 13 Ago', '#1d4ed8', '#eff6ff'],
      ['2026-08-14', 'Dia 2', 'Quinta, 14 Ago', '#059669', '#ecfdf5'],
      ['2026-08-15', 'Dia 3', 'Sexta, 15 Ago',  '#6d28d9', '#f5f3ff'],
    ] as [$d,$label,$sublabel,$col,$bg])
      <div style="background:{{ $bg }};border:1px solid transparent;border-radius:var(--r-lg);padding:1.25rem;box-shadow:var(--shadow-sm);">
        <div style="font-family:var(--font-mono);font-size:2rem;font-weight:700;color:{{ $col }};margin-bottom:.25rem;">
          {{ $statsDias[$d] ?? 0 }}
        </div>
        <div style="font-size:.82rem;font-weight:700;color:{{ $col }};margin-bottom:.1rem;">{{ $label }}</div>
        <div style="font-size:.7rem;color:{{ $col }};opacity:.7;">{{ $sublabel }}</div>
      </div>
    @endforeach
  </div>

  {{-- Tabela --}}
  <div class="a3" style="background:var(--card);border:1px solid var(--card-border);
                          border-radius:var(--r-lg);box-shadow:var(--shadow-sm);overflow:hidden;">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th><span class="section-label">Dia</span></th>
            <th><span class="section-label">Horário</span></th>
            <th><span class="section-label">Actividade</span></th>
            <th><span class="section-label">Tipo</span></th>
            <th><span class="section-label">Sala</span></th>
            <th><span class="section-label">Palestrantes</span></th>
            <th><span class="section-label">Estado</span></th>
            <th><span class="section-label">Acções</span></th>
          </tr>
        </thead>
        <tbody>
          @forelse($actividades as $act)
            <tr>
              <td>
                <div style="font-size:.75rem;font-weight:700;color:var(--text-1);">
                  {{ $act->dia->format('d/m') }}
                </div>
                <div style="font-size:.65rem;color:var(--text-3);">
                  {{ ['2026-08-13'=>'Dia 1','2026-08-14'=>'Dia 2','2026-08-15'=>'Dia 3'][$act->dia->format('Y-m-d')] ?? '' }}
                </div>
              </td>
              <td>
                <span style="font-family:var(--font-mono);font-size:.75rem;color:var(--text-2);font-weight:600;white-space:nowrap;">
                  {{ $act->horario_label }}
                </span>
              </td>
              <td>
                <div style="font-size:.8rem;font-weight:600;color:var(--text-1);max-width:220px;">{{ $act->nome }}</div>
                @if($act->descricao)
                  <div style="font-size:.68rem;color:var(--text-3);max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ $act->descricao }}
                  </div>
                @endif
              </td>
              <td>
                <span class="tipo-badge"
                      style="color:{{ $act->tipo_color }};background:{{ $act->tipo_bg }};">
                  {{ $act->tipo_label }}
                </span>
              </td>
              <td>
                <span style="font-size:.75rem;color:var(--text-2);">{{ $act->sala ?: '—' }}</span>
              </td>
              <td>
                @if($act->speakers->isEmpty())
                  <span style="font-size:.72rem;color:var(--text-4);">—</span>
                @else
                  <div style="display:flex;flex-wrap:wrap;gap:.2rem;">
                    @foreach($act->speakers->take(2) as $sp)
                      <span style="font-size:.63rem;font-weight:600;padding:2px 6px;border-radius:99px;
                                   background:rgba(37,99,235,.07);color:var(--blue-vivid);">
                        {{ \Str::words($sp->nome, 2, '') }}
                      </span>
                    @endforeach
                    @if($act->speakers->count() > 2)
                      <span style="font-size:.63rem;color:var(--text-3);">+{{ $act->speakers->count()-2 }}</span>
                    @endif
                  </div>
                @endif
              </td>
              <td>
                @if($act->ativo)
                  <span class="status-badge" style="color:var(--success);background:var(--success-bg);border-color:#a7f3d0;">
                    <span class="status-dot" style="background:var(--success);"></span>Activo
                  </span>
                @else
                  <span class="status-badge" style="color:var(--text-3);background:var(--surface);border-color:var(--card-border);">
                    <span class="status-dot" style="background:var(--text-3);"></span>Oculto
                  </span>
                @endif
              </td>
              <td>
                <div style="display:flex;gap:.375rem;align-items:center;">
                  <a href="{{ route('admin.programa.edit', $act) }}"
                     style="font-size:.72rem;font-weight:600;padding:.3rem .6rem;border-radius:6px;
                            background:#eff6ff;color:var(--blue-vivid);text-decoration:none;">
                    Editar
                  </a>
                  <form method="POST" action="{{ route('admin.programa.toggle-ativo', $act) }}"
                        style="display:contents;">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="font-size:.72rem;font-weight:600;padding:.3rem .6rem;border-radius:6px;
                                   border:none;cursor:pointer;background:#f0fdf4;color:#166534;">
                      {{ $act->ativo ? 'Ocultar' : 'Activar' }}
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.programa.destroy', $act) }}"
                        style="display:contents;"
                        onsubmit="return confirm('Eliminar «{{ addslashes($act->nome) }}»?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="font-size:.72rem;font-weight:600;padding:.3rem .6rem;border-radius:6px;
                                   border:none;cursor:pointer;background:#fff1f2;color:#be123c;">
                      Eliminar
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">
                Nenhuma actividade criada.
                <a href="{{ route('admin.programa.create') }}" style="color:var(--blue-vivid);font-weight:600;">
                  Criar a primeira actividade
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($actividades->hasPages())
      <div style="padding:.875rem 1.25rem;border-top:1px solid var(--divider);">
        {{ $actividades->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
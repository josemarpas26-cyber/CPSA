@extends('layouts.admin')
@section('title','Cursos')
@section('page-title','Cursos')
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
      <h1 class="heading" style="font-size:1.5rem;margin:0;">Cursos</h1>
    </div>
    <a href="{{ route('admin.cursos.create') }}" class="btn-primary">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
      </svg>
      Novo Curso
    </a>
  </div>

  {{-- Table --}}
  <div class="card a2" style="overflow:hidden;">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th><span class="section-label">Curso</span></th>
            <th><span class="section-label">Sala</span></th>
            <th><span class="section-label">Dia & Horário</span></th>
            <th><span class="section-label">Palestrantes</span></th>
            <th><span class="section-label">Inscritos</span></th>
            <th><span class="section-label">Estado</span></th>
            <th><span class="section-label">Acções</span></th>
          </tr>
        </thead>
        <tbody>
          @forelse($cursos as $curso)
            <tr>
              <td>
                <div style="font-size:.8rem;font-weight:600;color:var(--text-1);max-width:240px;">
                  {{ $curso->nome }}
                </div>
                @if($curso->descricao)
                  <div style="font-size:.7rem;color:var(--text-3);margin-top:.1rem;
                               max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ $curso->descricao }}
                  </div>
                @endif
              </td>
              <td>
                <span style="display:inline-flex;align-items:center;gap:4px;
                             font-size:.73rem;color:var(--text-2);">
                  <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  </svg>
                  {{ $curso->sala }}
                </span>
              </td>
              <td>
                <div style="font-size:.75rem;font-weight:600;color:var(--text-1);">
                  {{ $curso->dia->format('d/m/Y') }}
                </div>
                <div style="font-size:.7rem;color:var(--text-3);">
                  {{ substr($curso->hora_inicio,0,5) }} – {{ substr($curso->hora_fim,0,5) }}
                </div>
              </td>
              <td>
                @if($curso->speakers->isEmpty())
                  <span style="font-size:.72rem;color:var(--text-4);">—</span>
                @else
                  <div style="display:flex;flex-wrap:wrap;gap:.25rem;">
                    @foreach($curso->speakers->take(3) as $sp)
                      <span style="display:inline-block;font-size:.65rem;font-weight:600;
                                   padding:2px 7px;border-radius:99px;
                                   background:rgba(37,99,235,.08);color:var(--blue-vivid);">
                        {{ $sp->nome }}
                      </span>
                    @endforeach
                    @if($curso->speakers->count() > 3)
                      <span style="font-size:.65rem;color:var(--text-3);">
                        +{{ $curso->speakers->count() - 3 }}
                      </span>
                    @endif
                  </div>
                @endif
              </td>
              <td>
                @php
                  $inscritos = $curso->inscricoes_count;
                  $vagas     = $curso->vagas;
                @endphp
                <span style="font-family:var(--font-mono);font-size:.78rem;font-weight:600;
                             color:var(--text-1);">
                  {{ $inscritos }}{{ $vagas ? '/'.$vagas : '' }}
                </span>
                @if($vagas && $inscritos >= $vagas)
                  <div style="font-size:.65rem;color:var(--danger);font-weight:600;">Esgotado</div>
                @endif
              </td>
              <td>
                @if($curso->ativo)
                  <span class="status-badge" style="color:var(--success);background:var(--success-bg);border-color:#a7f3d0;">
                    <span class="status-dot" style="background:var(--success);"></span>Activo
                  </span>
                @else
                  <span class="status-badge" style="color:var(--text-3);background:var(--surface);border-color:var(--card-border);">
                    <span class="status-dot" style="background:var(--text-3);"></span>Inactivo
                  </span>
                @endif
              </td>
              <td>
                <div style="display:flex;gap:.375rem;align-items:center;">
                  <a href="{{ route('admin.cursos.edit', $curso) }}"
                     style="font-size:.72rem;font-weight:600;padding:.3rem .6rem;
                            border-radius:6px;background:#eff6ff;color:var(--blue-vivid);
                            text-decoration:none;transition:background .15s;"
                     onmouseover="this.style.background='#dbeafe'"
                     onmouseout="this.style.background='#eff6ff'">
                    Editar
                  </a>

                  <form method="POST"
                        action="{{ route('admin.cursos.toggle-ativo', $curso) }}"
                        style="display:contents;">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="font-size:.72rem;font-weight:600;padding:.3rem .6rem;
                                   border-radius:6px;border:none;cursor:pointer;
                                   background:#f0fdf4;color:#166534;transition:background .15s;"
                            onmouseover="this.style.background='#dcfce7'"
                            onmouseout="this.style.background='#f0fdf4'">
                      {{ $curso->ativo ? 'Desactivar' : 'Activar' }}
                    </button>
                  </form>

                  <form method="POST"
                        action="{{ route('admin.cursos.destroy', $curso) }}"
                        style="display:contents;"
                        onsubmit="return confirm('Eliminar o curso «{{ addslashes($curso->nome) }}»?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="font-size:.72rem;font-weight:600;padding:.3rem .6rem;
                                   border-radius:6px;border:none;cursor:pointer;
                                   background:#fff1f2;color:#be123c;transition:background .15s;"
                            onmouseover="this.style.background='#ffe4e6'"
                            onmouseout="this.style.background='#fff1f2'">
                      Eliminar
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">
                Nenhum curso criado ainda.
                <a href="{{ route('admin.cursos.create') }}"
                   style="color:var(--blue-vivid);font-weight:600;">
                  Criar o primeiro curso
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($cursos->hasPages())
      <div style="padding:.875rem 1.25rem;border-top:1px solid var(--divider);">
        {{ $cursos->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
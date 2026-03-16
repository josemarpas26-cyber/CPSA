@extends('layouts.admin')
@section('title','Palestrantes')
@section('page-title','Palestrantes')
@section('content')
<style>
  .admin-toolbar{
    display:flex;align-items:center;justify-content:space-between;
    gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;
  }
  .admin-table-wrap{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);overflow:hidden;box-shadow:var(--shadow-sm);
  }
  .admin-table{width:100%;border-collapse:collapse;}
  .admin-table thead tr{
    background:#f8faff;border-bottom:1px solid var(--divider);
  }
  .admin-table th{
    padding:.75rem 1rem;text-align:left;
    font-size:.65rem;font-weight:700;letter-spacing:.1em;
    text-transform:uppercase;color:var(--text-3);
  }
  .admin-table td{
    padding:.875rem 1rem;
    font-size:.82rem;color:var(--text-1);
    border-bottom:1px solid var(--divider);
    vertical-align:middle;
  }
  .admin-table tr:last-child td{border-bottom:none;}
  .admin-table tr:hover td{background:#f8faff;}
  .speaker-thumb{
    width:40px;height:40px;border-radius:var(--r-sm);
    background:linear-gradient(135deg,var(--blue-vivid),#6d28d9);
    display:flex;align-items:center;justify-content:center;
    font-family:var(--font-display);font-style:italic;
    color:white;font-size:1rem;font-weight:700;
    flex-shrink:0;overflow:hidden;
  }
  .speaker-thumb img{width:40px;height:40px;object-fit:cover;}
  .speaker-info{display:flex;align-items:center;gap:.75rem;}
  .badge-sim{
    display:inline-block;font-size:.63rem;font-weight:700;
    padding:.2rem .55rem;border-radius:99px;
    background:#dcfce7;color:#166534;
  }
  .badge-nao{
    display:inline-block;font-size:.63rem;font-weight:700;
    padding:.2rem .55rem;border-radius:99px;
    background:#f1f5f9;color:#64748b;
  }
  .badge-destaque{
    display:inline-block;font-size:.63rem;font-weight:700;
    padding:.2rem .55rem;border-radius:99px;
    background:#fef3c7;color:#92400e;
  }
  .action-btns{display:flex;gap:.375rem;align-items:center;}
  .btn-sm{
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.72rem;font-weight:600;padding:.3rem .7rem;
    border-radius:6px;text-decoration:none;border:none;cursor:pointer;
    transition:all .18s;font-family:var(--font-body);
  }
  .btn-sm-edit{background:#eff6ff;color:var(--blue-vivid);}
  .btn-sm-edit:hover{background:#dbeafe;}
  .btn-sm-del{background:#fff1f2;color:#be123c;}
  .btn-sm-del:hover{background:#ffe4e6;}
  .btn-sm-toggle{background:#f0fdf4;color:#166534;}
  .btn-sm-toggle:hover{background:#dcfce7;}
  .btn-sm-toggle.inativo{background:#f1f5f9;color:#64748b;}
  .btn-sm-toggle.inativo:hover{background:#e2e8f0;}
</style>

<div class="admin-toolbar">
  <div>
    <p style="font-size:.75rem;color:var(--text-3);margin:0;">
      {{ $speakers->total() }} palestrante{{ $speakers->total() != 1 ? 's' : '' }} registado{{ $speakers->total() != 1 ? 's' : '' }}
    </p>
  </div>
  <a href="{{ route('admin.speakers.create') }}" class="btn-primary">
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="2.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Novo Palestrante
  </a>
</div>

<div class="admin-table-wrap">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Palestrante</th>
        <th>Especialidade</th>
        <th>País</th>
        <th>Destaque</th>
        <th>Estado</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($speakers as $speaker)
        <tr>
          <td>
            <div class="speaker-info">
              <div class="speaker-thumb">
                @if($speaker->foto_url)
                  <img src="{{ $speaker->foto_url }}" alt="{{ $speaker->nome }}">
                @else
                  {{ $speaker->inicial }}
                @endif
              </div>
              <div>
                <p style="font-weight:600;margin:0 0 .1rem;">{{ $speaker->nome }}</p>
                @if($speaker->instituicao)
                  <p style="font-size:.7rem;color:var(--text-3);margin:0;">
                    {{ $speaker->instituicao }}
                  </p>
                @endif
              </div>
            </div>
          </td>
          <td>{{ $speaker->especialidade }}</td>
          <td>{{ $speaker->pais }}</td>
          <td>
            @if($speaker->destaque)
              <span class="badge-destaque">⭐ Destaque</span>
            @else
              <span class="badge-nao">—</span>
            @endif
          </td>
          <td>
            @if($speaker->ativo)
              <span class="badge-sim">Ativo</span>
            @else
              <span class="badge-nao">Inativo</span>
            @endif
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.speakers.edit', $speaker) }}"
                 class="btn-sm btn-sm-edit">Editar</a>

              <form method="POST"
                    action="{{ route('admin.speakers.toggle-ativo', $speaker) }}"
                    style="display:contents;">
                @csrf @method('PATCH')
                <button type="submit"
                        class="btn-sm btn-sm-toggle {{ $speaker->ativo ? '' : 'inativo' }}">
                  {{ $speaker->ativo ? 'Desativar' : 'Ativar' }}
                </button>
              </form>

              <form method="POST"
                    action="{{ route('admin.speakers.destroy', $speaker) }}"
                    style="display:contents;"
                    onsubmit="return confirm('Eliminar {{ addslashes($speaker->nome) }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-sm-del">Eliminar</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:3rem;color:var(--text-3);">
            Nenhum palestrante registado ainda.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($speakers->hasPages())
  <div style="margin-top:1.5rem;">
    {{ $speakers->links() }}
  </div>
@endif
@endsection
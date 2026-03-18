@extends('layouts.admin')
@section('title','Inscrições')
@section('page-title','Inscrições')
@section('content')
<style>
  .filter-tab{display:inline-flex;align-items:center;gap:.5rem;padding:.4rem .875rem;
              border-radius:var(--r-sm);font-size:.75rem;font-weight:600;
              text-decoration:none;border:1px solid var(--card-border);
              background:var(--card);color:var(--text-2);transition:all .18s;}
  .filter-tab:hover{border-color:rgba(37,99,235,.25);color:var(--blue-brand);}
  .filter-tab.active{background:var(--navy);color:white;border-color:var(--navy);}
  .filter-tab-count{font-size:.65rem;font-weight:700;padding:1px 6px;border-radius:99px;}
  .filter-tab.active .filter-tab-count{background:rgba(255,255,255,.2);color:rgba(255,255,255,.8);}
  .filter-tab:not(.active) .filter-tab-count{background:var(--surface);color:var(--text-3);}

  .row-hover:hover{background:#f8faff;}
  .mono{font-family:var(--font-mono);}
  @keyframes fadeUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
  .animate-in{opacity:0;animation:fadeUp .4s ease forwards;}
</style>

<div style="display:flex;flex-direction:column;gap:1.25rem;">

  {{-- Header --}}
  <div class="animate-in" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
      <p class="section-label" style="margin-bottom:.2rem;">Gestão</p>
      <h1 class="heading" style="font-size:1.5rem;margin:0;">Inscrições</h1>
    </div>
    <div style="display:flex;gap:.5rem;">
      <a href="{{ route('admin.exportar.excel') }}" class="btn-secondary" style="font-size:.75rem;padding:.4rem .75rem;">Exportar Excel</a>
      <a href="{{ route('admin.exportar.csv') }}" class="btn-secondary" style="font-size:.75rem;padding:.4rem .75rem;">Exportar CSV</a>
    </div>
  </div>

  {{-- Status tabs --}}
  <div class="animate-in" style="animation-delay:.06s;display:flex;flex-wrap:wrap;gap:.375rem;">
    @foreach([null=>['Todas',$contadores['total']],'pendente'=>['Pendentes',$contadores['pendente']],'em_analise'=>['Em Análise',$contadores['em_analise']],'aprovada'=>['Aprovadas',$contadores['aprovada']],'rejeitada'=>['Rejeitadas',$contadores['rejeitada']]] as $v=>[$lbl,$cnt])
      <a href="{{ route('admin.inscricoes.index',array_merge(request()->except('status','page'),$v?['status'=>$v]:[])) }}"
         class="filter-tab {{ request('status')===$v?'active':'' }}">
        {{ $lbl }}
        <span class="filter-tab-count">{{ $cnt }}</span>
      </a>
    @endforeach
  </div>

  {{-- Search filters --}}
  <div class="card animate-in" style="animation-delay:.1s;padding:1rem 1.25rem;">
    <form method="GET" action="{{ route('admin.inscricoes.index') }}"
          style="display:flex;flex-wrap:wrap;gap:.75rem;align-items:flex-end;">
      <div style="flex:1;min-width:200px;">
        <label class="form-label">Pesquisar</label>
        <div style="position:relative;">
          <svg style="position:absolute;left:.625rem;top:50%;transform:translateY(-50%);pointer-events:none;"
               width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--text-3)" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
          </svg>
          <input type="text" name="busca" value="{{ request('busca') }}"
                 placeholder="Nome, email, número, instituição..."
                 class="form-input" style="padding-left:2rem;">
        </div>
      </div>
      <div style="min-width:140px;">
        <label class="form-label">Categoria</label>
        <select name="category" class="form-input">
          <option value="">Todas</option>
          @foreach(['medico'=>'Médico','enfermeiro'=>'Enfermeiro','psicologo'=>'Psicólogo','estudante'=>'Estudante','outro'=>'Outro'] as $v=>$l)
            <option value="{{ $v }}" {{ request('category')===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div style="min-width:120px;">
        <label class="form-label">Modalidade</label>
        <select name="tipo" class="form-input">
          <option value="">Todas</option>
          <option value="presencial" {{ request('tipo')==='presencial'?'selected':'' }}>Presencial</option>
          <option value="online" {{ request('tipo')==='online'?'selected':'' }}>Online</option>
        </select>
      </div>
      <div style="display:flex;gap:.375rem;">
        <button type="submit" class="btn-primary" style="font-size:.75rem;padding:.5rem .875rem;">Filtrar</button>
        @if(request()->hasAny(['busca','category','tipo','status']))
          <a href="{{ route('admin.inscricoes.index') }}" class="btn-secondary" style="font-size:.75rem;padding:.5rem .875rem;">Limpar</a>
        @endif
      </div>
    </form>
  </div>

  {{-- Table --}}
  <div class="card animate-in" style="animation-delay:.14s;overflow:hidden;">
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th><span class="section-label">Número</span></th>
            <th><span class="section-label">Participante</span></th>
            <th><span class="section-label">Categoria</span></th>
            <th><span class="section-label">Modalidade</span></th>
            <th><span class="section-label">Estado</span></th>
            <th><span class="section-label">Comprovativo</span></th>
            <th><span class="section-label">Data</span></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($inscricoes as $i)
            @php
              $sm=['pendente'=>['Pendente','#b45309','#fffbeb','#fde68a'],
                   'em_analise'=>['Em Análise','#6d28d9','#f5f3ff','#ddd6fe'],
                   'aprovada'=>['Aprovada','#059669','#ecfdf5','#a7f3d0'],
                   'rejeitada'=>['Rejeitada','#be123c','#fff1f2','#fecdd3']];
              [$sl,$sc,$sb,$sbd]=$sm[$i->status]??['—','#64748b','#f8faff','#e2e8f0'];
            @endphp
            <tr class="row-hover">
              <td><span class="mono" style="font-size:.71rem;font-weight:600;color:var(--blue-vivid);">{{ $i->numero }}</span></td>
              <td>
                <div style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $i->nome_completo }}</div>
                <div style="font-size:.7rem;color:var(--text-3);">{{ $i->email }}</div>
              </td>
              <td><span style="font-size:.75rem;color:var(--text-2);">{{ $i->category_label }}</span></td>
              <td><span style="font-size:.75rem;color:var(--text-2);text-transform:capitalize;">{{ $i->participation_mode }}</span></td>
              <td>
                <span class="status-badge" style="color:{{ $sc }};background:{{ $sb }};border-color:{{ $sbd }};">
                  <span class="status-dot" style="background:{{ $sc }};"></span>{{ $sl }}
                </span>
              </td>
              <td>
                @if($i->comprovativo)
                  <span style="display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:600;
                               color:var(--success);background:var(--success-bg);padding:2px 8px;
                               border-radius:99px;border:1px solid #a7f3d0;">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
                    </svg>
                    Enviado
                  </span>
                @else
                  <span style="font-size:.7rem;color:var(--text-4);">—</span>
                @endif
              </td>
              <td>
                <span style="font-size:.72rem;color:var(--text-3);">{{ $i->created_at->format('d/m/Y') }}</span><br>
                <span style="font-size:.68rem;color:var(--text-4);">{{ $i->created_at->format('H:i') }}</span>
              </td>
              <td>
                <a href="{{ route('admin.inscricoes.show',$i) }}"
                   style="font-size:.73rem;font-weight:600;color:var(--blue-vivid);text-decoration:none;
                          display:inline-flex;align-items:center;gap:3px;white-space:nowrap;
                          transition:gap .15s;">
                  Abrir
                  <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                  </svg>
                </a>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">Nenhuma inscrição encontrada.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($inscricoes->hasPages())
      <div style="padding:.875rem 1.25rem;border-top:1px solid var(--divider);
                  display:flex;align-items:center;justify-content:space-between;
                  font-size:.73rem;color:var(--text-3);">
        <span>A mostrar {{ $inscricoes->firstItem() }}–{{ $inscricoes->lastItem() }} de {{ $inscricoes->total() }} resultados</span>
        {{ $inscricoes->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')
<style>
  .stat-card{
    background:var(--card);border:1px solid var(--card-border);
    border-radius:var(--r-lg);padding:1.5rem;
    position:relative;overflow:hidden;
    box-shadow:var(--shadow-sm);
    transition:transform .22s cubic-bezier(.34,1.56,.64,1),box-shadow .22s ease;
    opacity:0;animation:fadeUp .45s ease forwards;
  }
  .stat-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);}
  .stat-stripe{position:absolute;top:0;left:0;right:0;height:3px;border-radius:var(--r-lg) var(--r-lg) 0 0;}
  .stat-num{font-family:var(--font-mono);font-size:2.1rem;font-weight:600;line-height:1;letter-spacing:-.03em;color:var(--text-1);}
  .stat-label{font-size:.73rem;color:var(--text-3);font-weight:500;margin-top:.375rem;}
  .stat-icon{width:38px;height:38px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;}

  .progress-track{height:5px;background:var(--surface);border-radius:99px;overflow:hidden;margin-top:.5rem;}
  .progress-fill{height:100%;border-radius:99px;width:0;transition:width 1.3s cubic-bezier(.4,0,.2,1) .4s;}

  .action-link{display:flex;align-items:center;gap:.75rem;padding:.7rem .875rem;
               border-radius:var(--r-sm);border:1px solid var(--card-border);
               text-decoration:none;transition:all .18s ease;background:var(--card);}
  .action-link:hover{border-color:rgba(37,99,235,.2);background:#f8faff;transform:translateX(3px);}
  .action-icon{width:34px;height:34px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
  .action-arrow{margin-left:auto;color:var(--text-4);transition:all .18s;flex-shrink:0;}
  .action-link:hover .action-arrow{color:var(--blue-vivid);transform:translateX(2px);}

  .row-link{font-size:.75rem;font-weight:600;color:var(--blue-vivid);text-decoration:none;
            display:inline-flex;align-items:center;gap:3px;transition:gap .15s;}
  .row-link:hover{gap:6px;}

  @keyframes fadeUp{from{opacity:0;transform:translateY(12px);}to{opacity:1;transform:translateY(0);}}
</style>

<div style="display:flex;flex-direction:column;gap:1.5rem;">

  {{-- Page header --}}
  <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;
              opacity:0;animation:fadeUp .35s ease .05s forwards;">
    <div>
      <p class="section-label" style="margin-bottom:.25rem;">Visão geral</p>
      <h1 class="heading" style="font-size:1.6rem;margin:0;">Centro de Controlo</h1>
    </div>
    <div style="display:flex;gap:.625rem;align-items:center;">
      @if($stats['pendentes'] > 0)
        <a href="{{ route('admin.inscricoes.index',['status'=>'pendente']) }}"
           style="display:inline-flex;align-items:center;gap:.5rem;font-size:.75rem;font-weight:600;
                  padding:.4rem .875rem;border-radius:var(--r-sm);
                  background:var(--warning-bg);color:var(--warning);
                  border:1px solid #fde68a;text-decoration:none;transition:all .18s;">
          <span style="width:6px;height:6px;border-radius:50%;background:var(--warning);
                       animation:pulseRing 2s infinite;"></span>
          {{ $stats['pendentes'] }} pendente{{ $stats['pendentes']!=1?'s':'' }}
        </a>
      @endif
      <a href="{{ route('admin.exportar.excel') }}" class="btn-primary" style="font-size:.75rem;padding:.4rem .875rem;">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Exportar
      </a>
    </div>
  </div>

  {{-- Stat cards --}}
  @php
    $cards=[
      ['label'=>'Total','value'=>$stats['total'],         'stripe'=>'linear-gradient(90deg,#1d4ed8,#2563eb)','icon_bg'=>'#eff6ff','icon_c'=>'#1d4ed8','delay'=>'.08s'],
      ['label'=>'Pendentes','value'=>$stats['pendentes'],  'stripe'=>'linear-gradient(90deg,#d97706,#f59e0b)','icon_bg'=>'#fffbeb','icon_c'=>'#b45309','delay'=>'.14s'],
      ['label'=>'Em Análise','value'=>$stats['em_analise'],'stripe'=>'linear-gradient(90deg,#6d28d9,#8b5cf6)','icon_bg'=>'#f5f3ff','icon_c'=>'#6d28d9','delay'=>'.20s'],
      ['label'=>'Aprovadas','value'=>$stats['aprovadas'],  'stripe'=>'linear-gradient(90deg,#059669,#10b981)','icon_bg'=>'#ecfdf5','icon_c'=>'#059669','delay'=>'.26s'],
      ['label'=>'Rejeitadas','value'=>$stats['rejeitadas'],'stripe'=>'linear-gradient(90deg,#be123c,#e11d48)','icon_bg'=>'#fff1f2','icon_c'=>'#be123c','delay'=>'.32s'],
    ];
  @endphp
  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:.875rem;"
       class="lg:grid-cols-5">
    @foreach($cards as $c)
      <div class="stat-card" style="animation-delay:{{ $c['delay'] }};">
        <div class="stat-stripe" style="background:{{ $c['stripe'] }};"></div>
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.875rem;margin-top:.25rem;">
          <div class="stat-icon" style="background:{{ $c['icon_bg'] }};">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="{{ $c['icon_c'] }}" stroke-width="2">
              @if($loop->index===0)
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
              @elseif($loop->index===1)
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
              @elseif($loop->index===2)
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
              @elseif($loop->index===3)
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              @else
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              @endif
            </svg>
          </div>
          @if($stats['total']>0 && $loop->index>0)
            <span style="font-size:.65rem;font-weight:600;color:var(--text-3);
                         background:var(--surface);padding:2px 7px;border-radius:99px;">
              {{ round(($c['value']/$stats['total'])*100) }}%
            </span>
          @endif
        </div>
        <div class="stat-num">{{ number_format($c['value']) }}</div>
        <div class="stat-label">{{ $c['label'] }}</div>
      </div>
    @endforeach
  </div>

  {{-- Middle row --}}
  <div style="display:grid;grid-template-columns:1fr;gap:1.25rem;" class="lg:grid-cols-3">

    {{-- Category distribution --}}
    <div class="card" style="padding:1.5rem;opacity:0;animation:fadeUp .45s ease .38s forwards;">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem;">
        <div>
          <p class="section-label" style="margin-bottom:.2rem;">Distribuição</p>
          <h3 class="heading" style="font-size:1rem;margin:0;">Por Categoria</h3>
        </div>
      </div>
      @php
        $cats=[
          'medico'    =>['Médico(a)',    '#1d4ed8'],
          'enfermeiro'=>['Enfermeiro(a)','#0f766e'],
          'psicologo' =>['Psicólogo(a)', '#6d28d9'],
          'estudante' =>['Estudante',    '#b45309'],
          'outro'     =>['Outro',        '#475569'],
        ];
        $total=$stats['total']?:1;
      @endphp
      <div style="display:flex;flex-direction:column;gap:.875rem;">
        @foreach($cats as $k=>[$lbl,$col])
          @php $v=$porCategoria[$k]??0; $p=round(($v/$total)*100); @endphp
          <div>
            <div style="display:flex;justify-content:space-between;margin-bottom:.3rem;">
              <div style="display:flex;align-items:center;gap:.5rem;">
                <span style="width:7px;height:7px;border-radius:50%;background:{{ $col }};flex-shrink:0;"></span>
                <span style="font-size:.75rem;font-weight:500;color:var(--text-2);">{{ $lbl }}</span>
              </div>
              <span style="font-size:.73rem;font-weight:600;color:var(--text-1);font-family:var(--font-mono);">{{ $v }}</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" data-w="{{ $p }}"
                   style="background:{{ $col }};"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Modality + approval rate --}}
    <div class="card" style="padding:1.5rem;opacity:0;animation:fadeUp .45s ease .44s forwards;">
      <div style="margin-bottom:1.25rem;">
        <p class="section-label" style="margin-bottom:.2rem;">Participação</p>
        <h3 class="heading" style="font-size:1rem;margin:0;">Por Modalidade</h3>
      </div>
      @php
        $mods=[
          'presencial'=>['Presencial','#1d4ed8','#eff6ff','#bfdbfe'],
          'online'    =>['Online',    '#6d28d9','#f5f3ff','#ddd6fe'],
        ];
      @endphp
      <div style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1.25rem;">
        @foreach($mods as $tipo=>[$lbl,$col,$bg,$bd])
          @php $v=$porTipo[$tipo]??0; $p=round(($v/$total)*100); @endphp
          <div style="display:flex;align-items:center;gap:.875rem;padding:.875rem 1rem;
                      border-radius:var(--r-sm);border:1px solid {{ $bd }};background:{{ $bg }};">
            <div>
              <p style="font-size:.8rem;font-weight:600;color:{{ $col }};margin:0 0 .1rem;">{{ $lbl }}</p>
              <p style="font-size:.68rem;color:var(--text-3);margin:0;">{{ $p }}% do total</p>
            </div>
            <div style="margin-left:auto;font-family:var(--font-mono);font-size:1.4rem;font-weight:600;color:{{ $col }};">{{ $v }}</div>
          </div>
        @endforeach
      </div>
      <div style="border-top:1px solid var(--divider);padding-top:1rem;">
        @php $rate=$total>0?round(($stats['aprovadas']/$total)*100):0; @endphp
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
          <span style="font-size:.73rem;color:var(--text-3);font-weight:500;">Taxa de aprovação</span>
          <span style="font-size:.73rem;font-weight:700;color:var(--success);font-family:var(--font-mono);">{{ $rate }}%</span>
        </div>
        <div class="progress-track">
          <div class="progress-fill" data-w="{{ $rate }}"
               style="background:linear-gradient(90deg,#059669,#10b981);"></div>
        </div>
      </div>
    </div>

    {{-- Quick actions --}}
    <div class="card" style="padding:1.5rem;opacity:0;animation:fadeUp .45s ease .50s forwards;">
      <div style="margin-bottom:1.25rem;">
        <p class="section-label" style="margin-bottom:.2rem;">Atalhos</p>
        <h3 class="heading" style="font-size:1rem;margin:0;">Acções Rápidas</h3>
      </div>
      @php
        $acts=[
          [route('admin.inscricoes.index',['status'=>'pendente']),'Inscrições Pendentes',$stats['pendentes'].' a aguardar','#b45309','#fffbeb','#fde68a'],
          [route('admin.exportar.excel'),  'Exportar para Excel',  'Todas as inscrições',   '#1d4ed8','#eff6ff','#bfdbfe'],
          [route('admin.certificados.index'),'Gestão de Certificados','Gerar e enviar',     '#6d28d9','#f5f3ff','#ddd6fe'],
          [route('admin.exportar.presenca'),'Lista de Presença',    'PDF do evento',         '#0f766e','#f0fdfa','#99f6e4'],
        ];
      @endphp
      <div style="display:flex;flex-direction:column;gap:.5rem;">
        @foreach($acts as [$href,$lbl,$sub,$col,$bg,$bd])
          <a href="{{ $href }}" class="action-link" style="border-color:{{ $bd }};background:{{ $bg }};">
            <div class="action-icon" style="background:white;box-shadow:var(--shadow-xs);">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="{{ $col }}" stroke-width="2">
                @if($loop->index===0)
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @elseif($loop->index===1)
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                @elseif($loop->index===2)
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                @else
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                @endif
              </svg>
            </div>
            <div>
              <p style="font-size:.78rem;font-weight:600;color:{{ $col }};margin:0 0 .1rem;">{{ $lbl }}</p>
              <p style="font-size:.68rem;color:var(--text-3);margin:0;">{{ $sub }}</p>
            </div>
            <svg class="action-arrow" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Recent registrations --}}
  <div class="card" style="overflow:hidden;opacity:0;animation:fadeUp .45s ease .56s forwards;">
    <div class="card-header">
      <div>
        <p class="section-label" style="margin-bottom:.2rem;">Actividade recente</p>
        <h3 class="heading" style="font-size:1rem;margin:0;">Últimas Inscrições</h3>
      </div>
      <a href="{{ route('admin.inscricoes.index') }}" class="row-link">
        Ver todas
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
    </div>
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th><span class="section-label">Número</span></th>
            <th><span class="section-label">Participante</span></th>
            <th class="hidden-sm"><span class="section-label">Categoria</span></th>
            <th><span class="section-label">Estado</span></th>
            <th class="hidden-md"><span class="section-label">Data</span></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($ultimas as $i)
            @php
              $sm=['pendente'=>['Pendente','#b45309','#fffbeb','#fde68a'],
                   'em_analise'=>['Em Análise','#6d28d9','#f5f3ff','#ddd6fe'],
                   'aprovada'=>['Aprovada','#059669','#ecfdf5','#a7f3d0'],
                   'rejeitada'=>['Rejeitada','#be123c','#fff1f2','#fecdd3']];
              [$sl,$sc,$sb,$sbd]=$sm[$i->status]??['—','#64748b','#f8faff','#e2e8f0'];
            @endphp
            <tr>
              <td><span class="mono" style="font-size:.72rem;font-weight:600;color:var(--blue-vivid);">{{ $i->numero }}</span></td>
              <td>
                <span style="font-size:.8rem;font-weight:600;color:var(--text-1);">{{ $i->nome_completo }}</span>
                <br><span style="font-size:.7rem;color:var(--text-3);">{{ $i->email }}</span>
              </td>
              <td class="hidden-sm"><span style="font-size:.75rem;color:var(--text-2);">{{ $i->categoria_label }}</span></td>
              <td>
                <span class="status-badge" style="color:{{ $sc }};background:{{ $sb }};border-color:{{ $sbd }};">
                  <span class="status-dot" style="background:{{ $sc }};"></span>
                  {{ $sl }}
                </span>
              </td>
              <td class="hidden-md"><span style="font-size:.72rem;color:var(--text-3);">{{ $i->created_at->format('d/m/Y') }}</span></td>
              <td>
                <a href="{{ route('admin.inscricoes.show',$i) }}" class="row-link">
                  Ver
                  <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                  </svg>
                </a>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" style="padding:3rem;text-align:center;color:var(--text-3);font-size:.8rem;">Nenhuma inscrição encontrada.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded',()=>{
  const io=new IntersectionObserver(entries=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        e.target.style.width=e.target.dataset.w+'%';
        io.unobserve(e.target);
      }
    });
  },{threshold:.1});
  document.querySelectorAll('.progress-fill[data-w]').forEach(f=>io.observe(f));
});
</script>
@endsection
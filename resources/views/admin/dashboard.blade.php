@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('content')

<style>
/* ── Reset & local tokens ────────────────────────────────────────────────── */
:root {
  --ease-spring: cubic-bezier(.34,1.56,.64,1);
  --ease-out:    cubic-bezier(.22,1,.36,1);
}

/* ── Keyframes ───────────────────────────────────────────────────────────── */
@keyframes fadeUp   { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
@keyframes scalePop { from{opacity:0;transform:scale(.94)}       to{opacity:1;transform:none} }
@keyframes barGrow  { from{width:0} }
@keyframes pulsate  { 0%,100%{box-shadow:0 0 0 0 rgba(245,158,11,.5)} 60%{box-shadow:0 0 0 6px rgba(245,158,11,0)} }

/* ── Stat cards ──────────────────────────────────────────────────────────── */
.sc {
  position: relative;
  background: var(--card);
  border: 1px solid var(--card-border);
  border-radius: var(--r-lg);
  padding: 1.25rem 1.375rem 1.375rem;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  opacity: 0;
  animation: fadeUp .5s var(--ease-out) both;
  transition: transform .22s var(--ease-spring), box-shadow .22s ease;
  cursor: default;
}
.sc:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
.sc::before {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--sc-tint, transparent);
  pointer-events: none;
  border-radius: inherit;
}
.sc-stripe {
  position: absolute; top:0; left:0; right:0; height:2px;
  background: var(--sc-grad);
  border-radius: var(--r-lg) var(--r-lg) 0 0;
}
.sc-icon {
  width:36px; height:36px; border-radius:10px;
  display:flex; align-items:center; justify-content:center;
  background: var(--sc-icon-bg);
  box-shadow: 0 1px 3px rgba(0,0,0,.06);
}
.sc-pct {
  font-size:.63rem; font-weight:700; letter-spacing:.03em;
  color: var(--sc-col); background: var(--sc-icon-bg);
  padding:2px 8px; border-radius:99px;
}
.sc-num {
  font-family: var(--font-mono);
  font-size: 2.2rem; font-weight:700; line-height:1;
  letter-spacing:-.04em; color: var(--text-1);
  margin-top:.75rem;
}
.sc-label {
  font-size:.68rem; font-weight:600;
  text-transform:uppercase; letter-spacing:.06em;
  color: var(--text-3); margin-top:.3rem;
}
.sc-bar-track {
  height:2px; background:var(--surface); border-radius:99px;
  overflow:hidden; margin-top:.875rem;
}
.sc-bar-fill {
  height:100%; border-radius:99px;
  background: var(--sc-grad);
}

/* ── Card shell ──────────────────────────────────────────────────────────── */
.panel {
  background: var(--card);
  border: 1px solid var(--card-border);
  border-radius: var(--r-lg);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  opacity: 0;
  animation: fadeUp .5s var(--ease-out) both;
}
.panel-body { padding:1.5rem; }
.panel-hd {
  display:flex; align-items:flex-start; justify-content:space-between;
  margin-bottom:1.25rem;
}
.panel-pretitle {
  font-size:.63rem; font-weight:700; letter-spacing:.09em;
  text-transform:uppercase; color:var(--text-4);
  margin-bottom:.2rem;
}
.panel-title {
  font-size:.95rem; font-weight:700; color:var(--text-1); margin:0;
}

/* ── Progress bars ───────────────────────────────────────────────────────── */
.prog-track { height:4px; background:var(--surface); border-radius:99px; overflow:hidden; margin-top:.45rem; }
.prog-fill  { height:100%; border-radius:99px; width:0; transition:width 1.2s var(--ease-out) .5s; }

/* ── Modality card ───────────────────────────────────────────────────────── */
.mod-card {
  display:flex; align-items:center; gap:1rem;
  padding:.875rem 1rem; border-radius:var(--r-sm);
  border:1px solid var(--mc-bd);
  background: var(--mc-bg);
  transition: transform .18s var(--ease-spring), box-shadow .18s ease;
}
.mod-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-sm); }
.mod-icon {
  width:40px; height:40px; flex-shrink:0; border-radius:10px;
  background:white; display:flex; align-items:center; justify-content:center;
  box-shadow:0 1px 4px rgba(0,0,0,.08);
}

/* ── Action links ────────────────────────────────────────────────────────── */
.act {
  display:flex; align-items:center; gap:.875rem;
  padding:.75rem .875rem; border-radius:var(--r-sm);
  border:1px solid var(--act-bd); background:var(--act-bg);
  text-decoration:none;
  transition:transform .18s var(--ease-spring), box-shadow .18s ease, border-color .18s;
}
.act:hover { transform:translateX(4px); box-shadow:var(--shadow-sm); border-color:var(--act-col); }
.act-icon {
  width:36px; height:36px; flex-shrink:0; border-radius:9px;
  background:white; display:flex; align-items:center; justify-content:center;
  box-shadow:0 1px 3px rgba(0,0,0,.08);
}
.act-chevron { margin-left:auto; flex-shrink:0; opacity:.4; transition:opacity .18s, transform .18s; }
.act:hover .act-chevron { opacity:1; transform:translateX(2px); color:var(--act-col) !important; }

/* ── Table ───────────────────────────────────────────────────────────────── */
.dt thead th {
  padding:.625rem 1rem;
  background:var(--surface);
  font-size:.63rem; font-weight:700;
  letter-spacing:.08em; text-transform:uppercase;
  color:var(--text-3); white-space:nowrap;
  border-bottom:1px solid var(--divider);
}
.dt thead th:first-child { padding-left:1.5rem; }
.dt thead th:last-child  { padding-right:1.5rem; }
.dt tbody tr { border-bottom:1px solid var(--divider); transition:background .14s; }
.dt tbody tr:last-child { border-bottom:none; }
.dt tbody tr:hover { background:var(--surface); }
.dt tbody td { padding:.75rem 1rem; vertical-align:middle; }
.dt tbody td:first-child { padding-left:1.5rem; }
.dt tbody td:last-child  { padding-right:1.5rem; }

.num-chip {
  display:inline-flex; align-items:center;
  font-family:var(--font-mono); font-size:.7rem; font-weight:700;
  color:var(--blue-vivid);
  background:color-mix(in srgb, var(--blue-vivid) 10%, transparent);
  padding:2px 8px; border-radius:6px;
  border:1px solid color-mix(in srgb, var(--blue-vivid) 18%, transparent);
}
.avatar-chip {
  width:28px; height:28px; border-radius:50%; flex-shrink:0;
  background:linear-gradient(135deg,#3b82f6,#6d28d9);
  display:inline-flex; align-items:center; justify-content:center;
  font-size:.65rem; font-weight:700; color:white;
}
.badge {
  display:inline-flex; align-items:center; gap:5px;
  padding:3px 9px; border-radius:99px; border:1px solid;
  font-size:.67rem; font-weight:600; letter-spacing:.02em;
  white-space:nowrap;
}
.badge-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }

.row-link {
  display:inline-flex; align-items:center; gap:4px;
  font-size:.72rem; font-weight:700;
  color:var(--blue-vivid); text-decoration:none;
  padding:4px 10px; border-radius:6px;
  border:1px solid color-mix(in srgb, var(--blue-vivid) 15%, transparent);
  background:color-mix(in srgb, var(--blue-vivid) 6%, transparent);
  transition:all .15s;
}
.row-link:hover {
  background:color-mix(in srgb, var(--blue-vivid) 12%, transparent);
  border-color:color-mix(in srgb, var(--blue-vivid) 28%, transparent);
  gap:7px;
}

/* ── Pulse badge ─────────────────────────────────────────────────────────── */
.pulse-chip {
  display:inline-flex; align-items:center; gap:.375rem;
  font-size:.68rem; font-weight:700; letter-spacing:.04em;
  color:var(--warning);
  background:var(--warning-bg);
  border:1px solid color-mix(in srgb,var(--warning) 25%,transparent);
  padding:.3rem .75rem; border-radius:99px;
  text-decoration:none; transition:all .18s;
  animation: pulsate 2.4s ease-in-out infinite;
}
.pulse-chip:hover { filter:brightness(1.05); transform:scale(1.02); }
.pulse-dot {
  width:6px; height:6px; border-radius:50%;
  background:var(--warning); flex-shrink:0;
}

/* ── Responsive helpers ──────────────────────────────────────────────────── */
@media(max-width:640px){.hide-sm{display:none!important;}}
@media(max-width:900px){.hide-md{display:none!important;}}
</style>

@php
  $total        = $stats['total'] ?: 1;
  $approvalRate = round(($stats['aprovadas'] / $total) * 100);
@endphp

<div style="display:flex;flex-direction:column;gap:1.75rem;">

  {{-- ── Page header ──────────────────────────────────────────────────────── --}}
  <div style="display:flex;align-items:flex-end;justify-content:space-between;
              flex-wrap:wrap;gap:.875rem;
              opacity:0;animation:fadeUp .4s var(--ease-out) .04s both;">
    <div>
      <p class="panel-pretitle" style="margin-bottom:.2rem;">Visão geral · {{ now()->format('d M Y') }}</p>
      <h1 style="font-size:1.55rem;font-weight:800;color:var(--text-1);
                 letter-spacing:-.025em;margin:0;line-height:1.15;">
        Centro de Controlo
      </h1>
    </div>
    <div style="display:flex;gap:.625rem;align-items:center;flex-wrap:wrap;">
      @if($stats['pendentes'] > 0)
        <a href="{{ route('admin.inscricoes.index',['status'=>'pendente']) }}" class="pulse-chip">
          <span class="pulse-dot"></span>
          {{ $stats['pendentes'] }} pendente{{ $stats['pendentes'] != 1 ? 's' : '' }}
        </a>
      @endif
      <a href="{{ route('admin.exportar.excel') }}"
         style="display:inline-flex;align-items:center;gap:.4rem;
                font-size:.73rem;font-weight:700;letter-spacing:.02em;
                padding:.4rem .875rem;border-radius:var(--r-sm);
                background:var(--blue-vivid);color:#fff;text-decoration:none;
                box-shadow:0 2px 8px rgba(37,99,235,.3);
                transition:filter .18s,transform .18s;"
         onmouseover="this.style.filter='brightness(1.08)';this.style.transform='translateY(-1px)'"
         onmouseout="this.style.filter='';this.style.transform=''">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Exportar Excel
      </a>
    </div>
  </div>

  {{-- ── Stat cards ───────────────────────────────────────────────────────── --}}
  @php
    $cards = [
      ['label'=>'Total',      'value'=>$stats['total'],       'grad'=>'linear-gradient(90deg,#1d4ed8,#3b82f6)', 'tint'=>'rgba(59,130,246,.03)', 'col'=>'#1d4ed8', 'ibg'=>'#eff6ff', 'delay'=>'.08s'],
      ['label'=>'Pendentes',  'value'=>$stats['pendentes'],   'grad'=>'linear-gradient(90deg,#d97706,#f59e0b)', 'tint'=>'rgba(245,158,11,.03)', 'col'=>'#b45309', 'ibg'=>'#fffbeb', 'delay'=>'.14s'],
      ['label'=>'Em Análise', 'value'=>$stats['em_analise'],  'grad'=>'linear-gradient(90deg,#6d28d9,#8b5cf6)', 'tint'=>'rgba(139,92,246,.03)', 'col'=>'#6d28d9', 'ibg'=>'#f5f3ff', 'delay'=>'.20s'],
      ['label'=>'Aprovadas',  'value'=>$stats['aprovadas'],   'grad'=>'linear-gradient(90deg,#059669,#34d399)', 'tint'=>'rgba(52,211,153,.03)', 'col'=>'#059669', 'ibg'=>'#ecfdf5', 'delay'=>'.26s'],
      ['label'=>'Rejeitadas', 'value'=>$stats['rejeitadas'],  'grad'=>'linear-gradient(90deg,#be123c,#f43f5e)', 'tint'=>'rgba(244,63,94,.03)',  'col'=>'#be123c', 'ibg'=>'#fff1f2', 'delay'=>'.32s'],
    ];
    $svgPaths = [
      'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
      'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
      'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z',
      'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
      'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];
  @endphp

  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:.875rem;"
       class="lg:grid-cols-5">
    @foreach($cards as $idx => $c)
      @php $pct = $idx > 0 && $stats['total'] > 0 ? round(($c['value']/$stats['total'])*100) : null; @endphp
      <div class="sc"
           style="--sc-grad:{{ $c['grad'] }};--sc-tint:{{ $c['tint'] }};--sc-col:{{ $c['col'] }};--sc-icon-bg:{{ $c['ibg'] }};animation-delay:{{ $c['delay'] }};">
        <div class="sc-stripe"></div>
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-top:.15rem;">
          <div class="sc-icon">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="{{ $c['col'] }}" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPaths[$idx] }}"/>
            </svg>
          </div>
          @if($pct !== null)
            <span class="sc-pct">{{ $pct }}%</span>
          @endif
        </div>
        <div class="sc-num">{{ number_format($c['value']) }}</div>
        <div class="sc-label">{{ $c['label'] }}</div>
        @if($pct !== null)
          <div class="sc-bar-track">
            <div class="sc-bar-fill" data-w="{{ $pct }}" style="width:0;"></div>
          </div>
        @endif
      </div>
    @endforeach
  </div>

  {{-- ── Middle row ───────────────────────────────────────────────────────── --}}
  <div style="display:grid;grid-template-columns:1fr;gap:1.25rem;" class="lg:grid-cols-3">

    {{-- Category distribution --}}
    <div class="panel" style="animation-delay:.38s;">
      <div class="panel-body">
        <div class="panel-hd">
          <div>
            <p class="panel-pretitle">Distribuição</p>
            <h3 class="panel-title">Por Categoria</h3>
          </div>
          <span style="font-size:.65rem;color:var(--text-3);font-weight:500;">
            {{ $stats['total'] }} total
          </span>
        </div>
        @php
          $cats = [
            'medico'     => ['Médico(a)',    '#1d4ed8', '#eff6ff'],
            'enfermeiro' => ['Enfermeiro(a)','#0f766e', '#f0fdfa'],
            'psicologo'  => ['Psicólogo(a)', '#6d28d9', '#f5f3ff'],
            'estudante'  => ['Estudante',    '#b45309', '#fffbeb'],
            'outro'      => ['Outro',        '#475569', '#f8fafc'],
          ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:.875rem;">
          @foreach($cats as $k => [$lbl, $col, $ibg])
            @php $v = $porCategoria[$k] ?? 0; $p = round(($v/$total)*100); @endphp
            <div>
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.3rem;">
                <div style="display:flex;align-items:center;gap:.5rem;">
                  <span style="width:6px;height:6px;border-radius:50%;background:{{ $col }};flex-shrink:0;"></span>
                  <span style="font-size:.75rem;font-weight:500;color:var(--text-2);">{{ $lbl }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:.5rem;">
                  <span style="font-size:.68rem;color:var(--text-3);">{{ $p }}%</span>
                  <span style="font-family:var(--font-mono);font-size:.75rem;font-weight:700;
                               color:{{ $col }};background:{{ $ibg }};
                               padding:1px 7px;border-radius:5px;min-width:28px;text-align:center;">
                    {{ $v }}
                  </span>
                </div>
              </div>
              <div class="prog-track">
                <div class="prog-fill" data-w="{{ $p }}" style="background:{{ $col }};"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Modality + approval --}}
    <div class="panel" style="animation-delay:.44s;">
      <div class="panel-body">
        <div class="panel-hd">
          <div>
            <p class="panel-pretitle">Participação</p>
            <h3 class="panel-title">Por Modalidade</h3>
          </div>
        </div>
        @php
          $mods = [
            'presencial' => ['Presencial','#1d4ed8','#eff6ff','#bfdbfe',
              'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
            'online'     => ['Online','#6d28d9','#f5f3ff','#ddd6fe',
              'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3'],
          ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:.625rem;margin-bottom:1.25rem;">
          @foreach($mods as $tipo => [$lbl,$col,$bg,$bd,$svg])
            @php $v = $porTipo[$tipo] ?? 0; $p = round(($v/$total)*100); @endphp
            <div class="mod-card" style="--mc-bg:{{ $bg }};--mc-bd:{{ $bd }};">
              <div class="mod-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="{{ $col }}" stroke-width="1.75">
                  <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svg }}"/>
                </svg>
              </div>
              <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:baseline;justify-content:space-between;gap:.5rem;">
                  <p style="font-size:.78rem;font-weight:700;color:{{ $col }};margin:0;">{{ $lbl }}</p>
                  <span style="font-family:var(--font-mono);font-size:1.1rem;font-weight:700;color:{{ $col }};">{{ $v }}</span>
                </div>
                <div class="prog-track" style="height:3px;margin-top:.4rem;">
                  <div class="prog-fill" data-w="{{ $p }}" style="background:{{ $col }};"></div>
                </div>
                <p style="font-size:.65rem;color:var(--text-3);margin-top:.3rem;">{{ $p }}% das inscrições</p>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Approval KPI --}}
        <div style="border-top:1px solid var(--divider);padding-top:1.125rem;
                    display:flex;align-items:center;gap:1rem;">
          <div style="width:64px;height:64px;border-radius:50%;flex-shrink:0;
                      display:flex;flex-direction:column;align-items:center;justify-content:center;
                      border:3px solid #059669;background:#ecfdf5;">
            <span style="font-family:var(--font-mono);font-size:.9rem;font-weight:800;color:#059669;line-height:1.1;">{{ $approvalRate }}%</span>
            <span style="font-size:.5rem;color:#059669;opacity:.7;letter-spacing:.06em;text-transform:uppercase;">taxa</span>
          </div>
          <div style="flex:1;min-width:0;">
            <p style="font-size:.8rem;font-weight:700;color:var(--text-1);margin:0 0 .2rem;">Taxa de aprovação</p>
            <p style="font-size:.7rem;color:var(--text-3);margin:0 0 .5rem;">
              {{ $stats['aprovadas'] }} aprovadas de {{ $stats['total'] }} inscrições
            </p>
            <div class="prog-track">
              <div class="prog-fill" data-w="{{ $approvalRate }}"
                   style="background:linear-gradient(90deg,#059669,#34d399);"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Quick actions --}}
    <div class="panel" style="animation-delay:.50s;">
      <div class="panel-body">
        <div class="panel-hd">
          <div>
            <p class="panel-pretitle">Atalhos</p>
            <h3 class="panel-title">Acções Rápidas</h3>
          </div>
        </div>
        @php
          $acts = [
            [route('admin.inscricoes.index',['status'=>'pendente']),
             'Inscrições Pendentes', $stats['pendentes'].' a aguardar análise',
             '#b45309','#fffbeb','#fde68a',
             'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
            [route('admin.exportar.excel'),
             'Exportar para Excel', 'Download de todas as inscrições',
             '#1d4ed8','#eff6ff','#bfdbfe',
             'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3'],
            [route('admin.certificados.index'),
             'Certificados', 'Gerar e enviar por e-mail',
             '#6d28d9','#f5f3ff','#ddd6fe',
             'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
            [route('admin.exportar.presenca'),
             'Lista de Presença', 'Exportar PDF do evento',
             '#0f766e','#f0fdfa','#99f6e4',
             'M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75'],
          ];
        @endphp
        <div style="display:flex;flex-direction:column;gap:.5rem;">
          @foreach($acts as [$href,$lbl,$sub,$col,$bg,$bd,$svg])
            <a href="{{ $href }}" class="act"
               style="--act-col:{{ $col }};--act-bg:{{ $bg }};--act-bd:{{ $bd }};">
              <div class="act-icon">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="{{ $col }}" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svg }}"/>
                </svg>
              </div>
              <div style="min-width:0;flex:1;">
                <p style="font-size:.775rem;font-weight:700;color:{{ $col }};margin:0 0 .1rem;
                           white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $lbl }}</p>
                <p style="font-size:.67rem;color:var(--text-3);margin:0;">{{ $sub }}</p>
              </div>
              <svg class="act-chevron" width="13" height="13" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2.5" style="color:var(--text-4);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
              </svg>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- ── Recent registrations ─────────────────────────────────────────────── --}}
  <div class="panel" style="animation-delay:.56s;">
    <div style="display:flex;align-items:center;justify-content:space-between;
                padding:1.125rem 1.5rem;border-bottom:1px solid var(--divider);">
      <div style="display:flex;align-items:center;gap:.75rem;">
        <div>
          <p class="panel-pretitle" style="margin-bottom:.15rem;">Actividade recente</p>
          <h3 class="panel-title">Últimas Inscrições</h3>
        </div>
        @if($ultimas->count())
          <span style="font-size:.65rem;font-weight:700;
                       color:var(--blue-vivid);
                       background:color-mix(in srgb,var(--blue-vivid) 10%,transparent);
                       padding:2px 8px;border-radius:99px;
                       border:1px solid color-mix(in srgb,var(--blue-vivid) 18%,transparent);">
            {{ $ultimas->count() }}
          </span>
        @endif
      </div>
      <a href="{{ route('admin.inscricoes.index') }}" class="row-link">
        Ver todas
        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
    </div>

    <div style="overflow-x:auto;">
      <table class="dt" style="width:100%;border-collapse:collapse;">
        <thead>
          <tr>
            <th>Número</th>
            <th>Participante</th>
            <th class="hide-sm">Categoria</th>
            <th>Estado</th>
            <th class="hide-md">Data</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($ultimas as $i)
            @php
              $badges = [
                'pendente'   => ['Pendente',   '#b45309','#fffbeb','#fde68a'],
                'em_analise' => ['Em Análise', '#6d28d9','#f5f3ff','#ddd6fe'],
                'aprovada'   => ['Aprovada',   '#059669','#ecfdf5','#a7f3d0'],
                'rejeitada'  => ['Rejeitada',  '#be123c','#fff1f2','#fecdd3'],
              ];
              [$bl,$bc,$bb,$bbd] = $badges[$i->status] ?? ['—','#64748b','#f8fafc','#e2e8f0'];
            @endphp
            <tr>
              <td><span class="num-chip">{{ $i->numero }}</span></td>
              <td>
                <div style="display:flex;align-items:center;gap:.625rem;">
                  <span class="avatar-chip" aria-hidden="true">
                    {{ strtoupper(mb_substr($i->nome_completo, 0, 1)) }}
                  </span>
                  <div>
                    <p style="font-size:.78rem;font-weight:600;color:var(--text-1);margin:0;white-space:nowrap;">
                      {{ $i->nome_completo }}
                    </p>
                    <p style="font-size:.67rem;color:var(--text-3);margin:0;">{{ $i->email }}</p>
                  </div>
                </div>
              </td>
              <td class="hide-sm">
                <span style="font-size:.73rem;color:var(--text-2);">{{ $i->categoria_label }}</span>
              </td>
              <td>
                <span class="badge"
                      style="color:{{ $bc }};background:{{ $bb }};border-color:{{ $bbd }};">
                  <span class="badge-dot" style="background:{{ $bc }};"></span>
                  {{ $bl }}
                </span>
              </td>
              <td class="hide-md">
                <div style="font-size:.72rem;color:var(--text-3);">
                  {{ $i->created_at->format('d/m/Y') }}
                  <span style="color:var(--text-4);margin:0 2px;">·</span>
                  {{ $i->created_at->format('H:i') }}
                </div>
              </td>
              <td>
                <a href="{{ route('admin.inscricoes.show',$i) }}" class="row-link">
                  Ver
                  <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                  </svg>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="padding:3.5rem 1.5rem;text-align:center;">
                <div style="display:flex;flex-direction:column;align-items:center;gap:.75rem;">
                  <div style="width:44px;height:44px;border-radius:12px;background:var(--surface);
                               display:flex;align-items:center;justify-content:center;">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--text-4)" stroke-width="1.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                    </svg>
                  </div>
                  <p style="font-size:.8rem;font-weight:600;color:var(--text-2);margin:0;">Nenhuma inscrição ainda</p>
                  <p style="font-size:.72rem;color:var(--text-3);margin:0;">As novas inscrições aparecerão aqui.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($ultimas->count())
      <div style="padding:.75rem 1.5rem;border-top:1px solid var(--divider);
                  background:var(--surface);display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:.67rem;color:var(--text-3);">
          Mostrando as {{ $ultimas->count() }} inscrições mais recentes
        </span>
        <a href="{{ route('admin.inscricoes.index') }}"
           style="font-size:.67rem;font-weight:700;color:var(--blue-vivid);text-decoration:none;">
          Ver todas →
        </a>
      </div>
    @endif
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Animate progress bars on scroll into view
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.style.width = e.target.dataset.w + '%';
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.prog-fill[data-w], .sc-bar-fill[data-w]').forEach(f => {
    f.style.width = '0';
    io.observe(f);
  });
});
</script>
@endsection
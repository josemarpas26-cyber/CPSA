@extends('layouts.app')
@section('title','Inscrição Submetida')
@section('content')
<style>
  .success-wrap{min-height:calc(100vh - 60px - 80px);display:flex;align-items:center;
                justify-content:center;padding:3rem 1.5rem;position:relative;overflow:hidden;}
  .success-bg{position:absolute;inset:0;
    background:radial-gradient(ellipse 70% 50% at 50% -10%,rgba(5,150,105,.07),transparent 60%),
               radial-gradient(ellipse 50% 40% at 80% 90%,rgba(37,99,235,.05),transparent 60%);
    pointer-events:none;}
  .success-card{width:100%;max-width:520px;background:var(--card);border:1px solid var(--card-border);
                border-radius:var(--r-2xl);box-shadow:var(--shadow-lg);overflow:hidden;
                opacity:0;animation:fadeUp .5s ease .1s forwards;}
  .success-header{background:linear-gradient(135deg,var(--navy),var(--blue));
                  padding:2.5rem;text-align:center;}
  .success-body{padding:2rem;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
  .info-row{display:flex;justify-content:space-between;align-items:center;
            padding:.625rem 0;border-bottom:1px solid var(--divider);font-size:.8rem;}
  .info-row:last-child{border-bottom:none;}
</style>

<div class="success-wrap">
  <div class="success-bg"></div>
  <div class="success-card">
    <div class="success-header">
      <div style="width:56px;height:56px;border-radius:50%;
                  background:rgba(255,255,255,.12);border:2px solid rgba(255,255,255,.2);
                  display:flex;align-items:center;justify-content:center;
                  margin:0 auto 1.25rem;">
        <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <h1 style="font-family:var(--font-display);font-style:italic;font-size:1.6rem;
                 color:white;margin:0 0 .5rem;">Inscrição Recebida</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.6);margin:0;">A sua inscrição foi submetida com sucesso.</p>
    </div>

    <div class="success-body">
      <div style="background:var(--surface);border-radius:var(--r-md);
                  border:1px solid var(--card-border);padding:1.25rem;
                  text-align:center;margin-bottom:1.5rem;">
        <p style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                  color:var(--text-3);margin:0 0 .375rem;">Número de inscrição</p>
        <p style="font-family:var(--font-mono);font-size:1.4rem;font-weight:600;
                  color:var(--blue-vivid);margin:0;">
          {{ session('inscricao_numero') }}
        </p>
        <p style="font-size:.72rem;color:var(--text-3);margin:.5rem 0 0;">
          Confirmação enviada para <strong>{{ session('inscricao_email') }}</strong>
        </p>
      </div>

      <p style="font-size:.73rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
                color:var(--text-3);margin:0 0 .75rem;">Próximos passos</p>
      <div style="display:flex;flex-direction:column;gap:.625rem;margin-bottom:1.75rem;">
        @foreach([
          ['A comissão irá analisar o seu comprovativo de pagamento.'],
          ['Receberá um email de notificação com o resultado da avaliação.'],
          ['Após aprovação, o seu certificado ficará disponível para download.'],
        ] as $i=>[$t])
          <div style="display:flex;align-items:flex-start;gap:.75rem;
                      padding:.75rem;background:var(--surface);border-radius:var(--r-sm);
                      border:1px solid var(--card-border);">
            <div style="width:22px;height:22px;border-radius:50%;background:var(--navy);
                        color:white;display:flex;align-items:center;justify-content:center;
                        font-size:.6rem;font-weight:700;flex-shrink:0;margin-top:1px;">
              {{ $i+1 }}
            </div>
            <p style="font-size:.78rem;color:var(--text-2);margin:0;line-height:1.5;">{{ $t }}</p>
          </div>
        @endforeach
      </div>

      <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('home') }}" class="btn-secondary" style="font-size:.78rem;">
          Voltar ao início
        </a>
        @auth
          <a href="{{ route('participant.minha-inscricao') }}" class="btn-primary" style="font-size:.78rem;">
            Ver minha inscrição
          </a>
        @else
          <a href="{{ route('login') }}" class="btn-primary" style="font-size:.78rem;">
            Acompanhar inscrição
          </a>
        @endauth
      </div>
    </div>
  </div>
</div>
@endsection
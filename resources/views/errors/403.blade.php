{{-- 403 --}}
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Acesso negado — CPSM 2026</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&family=Instrument+Serif:ital@0;1&display=swap');
    :root{--navy:#0b1f4a;--blue-vivid:#2563eb;--danger:#be123c;
          --text-1:#0b1f4a;--text-3:#7a8fb5;--surface:#f4f7ff;}
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'DM Sans',sans-serif;background:var(--surface);color:var(--text-1);
         min-height:100vh;display:flex;align-items:center;justify-content:center;
         -webkit-font-smoothing:antialiased;}
    .error-card{text-align:center;max-width:440px;padding:2rem;}
    .error-code{font-family:'Instrument Serif',serif;font-style:italic;
                font-size:6rem;line-height:1;color:var(--danger);margin-bottom:.5rem;letter-spacing:-.04em;}
    .error-title{font-size:1.2rem;font-weight:700;color:var(--text-1);margin-bottom:.75rem;}
    .error-desc{font-size:.83rem;color:var(--text-3);line-height:1.65;margin-bottom:2rem;}
    .error-btn{display:inline-flex;align-items:center;gap:.5rem;background:var(--navy);
               color:white;font-size:.8rem;font-weight:600;padding:.6rem 1.25rem;
               border-radius:8px;text-decoration:none;transition:background .2s;}
    .error-btn:hover{background:#102668;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
    .error-card{opacity:0;animation:fadeUp .5s ease .1s forwards;}
  </style>
</head>
<body>
  <div class="error-card">
    <div class="error-code">403</div>
    <h1 class="error-title">Acesso não autorizado</h1>
    <p class="error-desc">
      Não tem permissão para aceder a esta área.<br>
      Se acredita que isto é um erro, contacte a organização.
    </p>
    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
      <a href="{{ url('/') }}" class="error-btn">Ir para o início</a>
      @auth
        <form method="POST" action="{{ route('logout') }}" style="display:contents;">
          @csrf
          <button type="submit" class="error-btn" style="background:transparent;color:var(--text-3);
                  border:1px solid #e2e8f0;cursor:pointer;font-family:'DM Sans',sans-serif;">
            Terminar sessão
          </button>
        </form>
      @endauth
    </div>
    <p style="font-size:.68rem;color:#b0bdd8;margin-top:2.5rem;">CPSM 2026 · Luanda, Angola</p>
  </div>
</body>
</html>
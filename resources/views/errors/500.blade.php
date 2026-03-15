<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Erro do servidor — CPSA 2025</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&family=Instrument+Serif:ital@0;1&display=swap');
    :root{--navy:#0b1f4a;--warning:#b45309;--text-1:#0b1f4a;--text-3:#7a8fb5;--surface:#f4f7ff;}
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'DM Sans',sans-serif;background:var(--surface);color:var(--text-1);
         min-height:100vh;display:flex;align-items:center;justify-content:center;
         -webkit-font-smoothing:antialiased;}
    .error-card{text-align:center;max-width:440px;padding:2rem;opacity:0;animation:fadeUp .5s ease .1s forwards;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
    .btn{display:inline-flex;align-items:center;gap:.5rem;font-size:.8rem;font-weight:600;
         padding:.6rem 1.25rem;border-radius:8px;text-decoration:none;
         background:var(--navy);color:white;transition:background .2s;}
    .btn:hover{background:#102668;}
  </style>
</head>
<body>
  <div class="error-card">
    <div style="font-family:'Instrument Serif',serif;font-style:italic;
                font-size:6rem;line-height:1;color:var(--warning);margin-bottom:.5rem;letter-spacing:-.04em;">
      500
    </div>
    <h1 style="font-size:1.2rem;font-weight:700;color:var(--text-1);margin-bottom:.75rem;">Erro interno do servidor</h1>
    <p style="font-size:.83rem;color:var(--text-3);line-height:1.65;margin-bottom:2rem;">
      Ocorreu um erro inesperado.<br>
      A nossa equipa técnica foi notificada. Tente novamente em alguns instantes.
    </p>
    <a href="{{ url('/') }}" class="btn">Ir para o início</a>
    <p style="font-size:.68rem;color:#b0bdd8;margin-top:2.5rem;">CPSA 2025 · Luanda, Angola</p>
  </div>
</body>
</html>
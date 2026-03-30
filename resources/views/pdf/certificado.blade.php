<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  @php
      $imgPath = public_path('images/certificadoA.png');
      $imgData = base64_encode(file_get_contents($imgPath));
      $imgMime = mime_content_type($imgPath);
  @endphp
  <style>
    @page {
      size: 297mm 210mm landscape;
      margin: 0;
    }

    body {
      width: 297mm;
      height: 210mm;
      margin: 0;
      padding: 0;
      font-family: 'Lora', Georgia, serif;
      position: relative;
      background-image: url("data:{{ $imgMime }};base64,{{ $imgData }}");
      background-size: 100% 100%;
      background-repeat: no-repeat;
      background-position: center center;
    }

.center-name {
  position: absolute;
  top: 40%;             /* controla a posição vertical */
  left: 50%;            /* centraliza horizontalmente */
  transform: translate(-50%, -50%); /* centraliza exatamente no ponto */
  
  font-family: 'Lora', serif; /* elegante e clássico */
  font-size: 40pt;             /* aumenta a presença do nome */
  font-weight: 700;            /* bold para destaque */
  font-style: italic;          /* opcional: dá um toque refinado */
  
  color: #1a1a1a;              /* cor escura elegante */
  text-align: center;
  width: 80%;                   /* largura máxima do texto */
  letter-spacing: 0.04em;       /* afina o espaçamento entre letras */
  font-variant: small-caps;     /* pequenas capitais sofisticadas */
  
  text-shadow: 1px 1px 2px rgba(0,0,0,0.15); /* sombra suave para elegância */
}
  </style>
</head>
<body>

  <div class="center-name">
    {{ $inscricao->full_name }}
  </div>

</body>
</html>
<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso negado — CPSA 2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans flex items-center justify-center">
    <div class="text-center px-6 max-w-md">
        <div class="text-8xl mb-6">🔒</div>
        <h1 class="text-6xl font-bold text-red-600 mb-2">403</h1>
        <h2 class="text-xl font-semibold text-gray-800 mb-3">
            Acesso não autorizado
        </h2>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            Não tem permissão para aceder a esta área.
            Se acredita que isto é um erro, contacte a organização.
        </p>
        <div class="flex gap-3 justify-center">
            <a href="{{ url('/') }}"
               class="bg-blue-800 text-white font-semibold px-6 py-2.5
                      rounded-lg hover:bg-blue-900 transition text-sm">
                Ir para o início
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="border border-gray-200 text-gray-600 font-medium
                                   px-6 py-2.5 rounded-lg hover:border-gray-300 transition text-sm">
                        Sair
                    </button>
                </form>
            @endauth
        </div>
        <p class="text-xs text-gray-400 mt-10">
            CPSA 2025 — 1º Congresso de Psiquiatria e Saúde Mental em Angola
        </p>
    </div>
</body>
</html>
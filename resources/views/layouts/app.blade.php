<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '1º CPSA 2025') — Congresso de Psiquiatria e Saúde Mental</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans antialiased">

    {{-- NAVBAR --}}
    <nav class="bg-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="text-white font-bold text-lg leading-tight">
                        1º CPSA 2025
                        <span class="block text-blue-200 text-xs font-normal">
                            Psiquiatria e Saúde Mental em Angola
                        </span>
                    </span>
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-blue-200 text-sm">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-white hover:text-blue-200 transition">
                                Sair
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm text-blue-200 hover:text-white transition">
                            Entrar
                        </a>
                        <a href="{{ route('inscricao.create') }}"
                           class="bg-white text-blue-800 text-sm font-semibold
                                  px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                            Inscrever-me
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 max-w-7xl mx-auto mt-4 px-4">
            <p class="text-green-700 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 max-w-7xl mx-auto mt-4 px-4">
            <p class="text-red-700 text-sm">{{ session('error') }}</p>
        </div>
    @endif

    {{-- CONTEÚDO --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="mt-16 bg-blue-900 text-blue-300 text-center text-xs py-6">
        © {{ date('Y') }} 1º Congresso de Psiquiatria e Saúde Mental em Angola.
        Todos os direitos reservados.
    </footer>

</body>
</html>
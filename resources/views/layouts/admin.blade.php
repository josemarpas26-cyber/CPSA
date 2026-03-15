<!DOCTYPE html>
<html lang="pt" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Admin') — CPSA 2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">

<div class="flex h-full">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-blue-900 flex flex-col flex-shrink-0">
        <div class="h-16 flex items-center px-6 border-b border-blue-800">
            <span class="text-white font-bold text-sm leading-tight">
                CPSA 2025
                <span class="block text-blue-300 text-xs font-normal">Painel da Comissão</span>
            </span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',        'label' => 'Dashboard',    'icon' => '📊'],
                    ['route' => 'admin.inscricoes.index',  'label' => 'Inscrições',   'icon' => '📋'],
                    ['route' => 'admin.certificados.index','label' => 'Certificados', 'icon' => '🏅'],
                    ['route' => 'admin.exportar.excel',    'label' => 'Exportar',     'icon' => '📥'],
                ];

                if (Auth::user()?->hasRole('admin')) {
                    $navItems[] = ['route' => 'admin.utilizadores.index', 'label' => 'Utilizadores', 'icon' => '👥'];
                }
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs($item['route'])
                             ? 'bg-blue-800 text-white font-semibold'
                             : 'text-blue-200 hover:bg-blue-800 hover:text-white' }}">
                    <span>{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- User info --}}
        <div class="border-t border-blue-800 p-4">
            <p class="text-blue-300 text-xs truncate">{{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="text-xs text-blue-400 hover:text-white transition">
                    Terminar sessão
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOP BAR --}}
        <header class="h-16 bg-white shadow-sm flex items-center px-6 justify-between">
            <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <span class="text-sm text-gray-400">
                {{ now()->format('d/m/Y') }}
            </span>
        </header>

        {{-- FLASH --}}
        @if(session('success'))
            <div class="bg-green-50 border-b border-green-200 px-6 py-3">
                <p class="text-green-700 text-sm">✓ {{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-b border-red-200 px-6 py-3">
                <p class="text-red-700 text-sm">✕ {{ session('error') }}</p>
            </div>
        @endif

        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
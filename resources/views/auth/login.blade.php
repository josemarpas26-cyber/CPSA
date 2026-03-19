{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Painel de Gestão — CPSA 2025')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-16">
        <div class="w-full max-w-md">

            {{-- Logo / Cabeçalho --}}
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo-cpsa.png') }}" alt="CPSA 2025" class="mx-auto h-16 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Painel de Gestão</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Acesso restrito à comissão organizadora
                </p>
            </div>

            {{-- Mensagens de sessão --}}
            @if (session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Formulário --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            class="w-full rounded-lg border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                   {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Senha
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-lg border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                   {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lembrar --}}
                    <div class="flex items-center mb-6">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                        <label for="remember" class="ml-2 text-sm text-gray-600">
                            Manter sessão iniciada
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white
                               hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition-colors"
                    >
                        Entrar no painel
                    </button>
                </form>
            </div>

            {{-- Nota de acesso restrito --}}
            <p class="mt-6 text-center text-xs text-gray-400">
                Esta área é exclusiva para administradores e organizadores do CPSA&nbsp;2025.<br>
                Participantes acedem à sua inscrição via link enviado por email.
            </p>

        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Entrar')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <h2 class="text-2xl font-bold text-gray-900 mb-1">Entrar na sua conta</h2>
            <p class="text-sm text-gray-500 mb-6">Aceda à sua área de participante</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5
                                  text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('email') border-red-400 @enderror"
                           placeholder="o.seu@email.ao">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Senha
                    </label>
                    <input type="password" name="password"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5
                                  text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('password') border-red-400 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded">
                        Lembrar-me
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-blue-800 hover:bg-blue-900 text-white font-semibold
                               py-2.5 rounded-lg transition text-sm">
                    Entrar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Não tem conta?
                <a href="{{ route('register') }}" class="text-blue-700 font-medium hover:underline">
                    Registar-se
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
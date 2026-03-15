@extends('layouts.app')
@section('title', 'Criar Conta')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <h2 class="text-2xl font-bold text-gray-900 mb-1">Criar conta</h2>
            <p class="text-sm text-gray-500 mb-6">Para acompanhar a sua inscrição</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nome completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('name') border-red-400 @enderror">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('email') border-red-400 @enderror">
                    @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone') }}"
                           placeholder="+244 9XX XXX XXX"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('telefone') border-red-400 @enderror">
                    @error('telefone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Senha</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('password') border-red-400 @enderror">
                    @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Confirmar senha
                    </label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                        class="w-full bg-blue-800 hover:bg-blue-900 text-white font-semibold
                               py-2.5 rounded-lg transition text-sm">
                    Criar conta
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Já tem conta?
                <a href="{{ route('login') }}" class="text-blue-700 font-medium hover:underline">
                    Entrar
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
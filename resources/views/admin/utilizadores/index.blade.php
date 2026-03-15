@extends('layouts.admin')
@section('title', 'Utilizadores')
@section('page-title', 'Gestão de Utilizadores')

@section('content')
@if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
        <p class="text-sm font-semibold text-red-700 mb-1">Corrija os erros abaixo:</p>
        <ul class="text-sm text-red-600 list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-1 bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
            Adicionar Admin/Organizador
        </h3>

        <form method="POST" action="{{ route('admin.utilizadores.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs text-gray-500 font-medium mb-1">Nome</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-500 font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-500 font-medium mb-1">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-500 font-medium mb-1">Perfil</label>
                <select name="role" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <option value="organizador" @selected(old('role') === 'organizador')>Organizador</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrador</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-500 font-medium mb-1">Senha</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-500 font-medium mb-1">Confirmar senha</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-2 rounded-lg transition">
                Criar utilizador
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
            Administradores e Organizadores
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-4 py-3 text-left">Nome</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Telefone</th>
                        <th class="px-4 py-3 text-left">Perfis</th>
                        <th class="px-4 py-3 text-left">Criado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($utilizadores as $user)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->telefone ?: '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        @if(in_array($role->name, ['admin', 'organizador']))
                                            <span class="text-xs px-2 py-1 rounded-full {{ $role->name === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ $role->display_name }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">Sem utilizadores de gestão.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

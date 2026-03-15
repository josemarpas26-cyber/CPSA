<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GestorUtilizadorRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UtilizadorController extends Controller
{
    public function index(): View
    {
        $utilizadores = User::with('roles')
            ->whereHas('roles', fn ($q) => $q->whereIn('name', ['admin', 'organizador']))
            ->latest()
            ->get();

        return view('admin.utilizadores.index', compact('utilizadores'));
    }

    public function store(GestorUtilizadorRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        DB::transaction(function () use ($dados) {
            $user = User::create([
                'name' => $dados['name'],
                'email' => $dados['email'],
                'telefone' => $dados['telefone'] ?? null,
                'password' => Hash::make($dados['password']),
            ]);

            $role = Role::where('name', $dados['role'])->firstOrFail();
            $user->roles()->attach($role);
        });

        return back()->with('success', 'Utilizador criado com sucesso.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /** Formulário de login */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /** Processar login */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Credenciais inválidas.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Redirecionar conforme role
        if (Auth::user()->hasRole(['admin', 'organizador'])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('participant.minha-inscricao'));
    }

    /** Formulário de registo */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /** Processar registo */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefone' => $request->telefone,
            'password' => Hash::make($request->password),
        ]);

        // Atribuir role de participante
        $role = Role::where('name', 'participante')->first();
        $user->roles()->attach($role);

        Auth::login($user);

        return redirect()->route('participant.minha-inscricao')
            ->with('success', 'Conta criada com sucesso! Bem-vindo(a).');
    }

    /** Logout */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sessão terminada com sucesso.');
    }
}
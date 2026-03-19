<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Autenticação exclusiva para Admin e Organizador.
 *
 * Segurança implementada (Fortify-style sem o package):
 *  • Rate limiting: 5 tentativas por (email + IP) em 5 minutos
 *  • Verificação de role após autenticação (não basta ter credenciais)
 *  • Regeneração de sessão após login bem-sucedido
 *  • Invalidação completa de sessão no logout
 *  • Log de auditoria para logins, falhas e logouts
 */
class AdminAuthController extends Controller
{
    private const MAX_ATTEMPTS  = 5;
    private const DECAY_SECONDS = 300; // 5 minutos

    // ── Formulário de login ───────────────────

    public function showLogin(): View
    {
        return view('auth.login');
    }

    // ── Processar login ───────────────────────

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'O email é obrigatório.',
            'email.email'       => 'Formato de email inválido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        $throttleKey = $this->throttleKey($request);

        // ── 1. Verificar rate limit ────────────
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::warning('[Admin Login] Bloqueado por excesso de tentativas', [
                'email' => $request->email,
                'ip'    => $request->ip(),
                'wait'  => $seconds,
            ]);

            throw ValidationException::withMessages([
                'email' => "Demasiadas tentativas falhadas. Tente novamente em {$seconds} segundos.",
            ]);
        }

        // ── 2. Tentativa de autenticação ───────
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

            Log::warning('[Admin Login] Credenciais inválidas', [
                'email'    => $request->email,
                'ip'       => $request->ip(),
                'attempts' => RateLimiter::attempts($throttleKey),
            ]);

            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas.',
            ]);
        }

        // ── 3. Verificar role de gestão ────────
        if (! Auth::user()->hasRole(['admin', 'organizador'])) {
            Auth::logout();
            RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

            Log::warning('[Admin Login] Utilizador sem role de gestão tentou aceder', [
                'user_id' => Auth::id(),
                'email'   => $request->email,
                'ip'      => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'email' => 'Não tem permissão para aceder ao painel de gestão.',
            ]);
        }

        // ── 4. Sucesso ─────────────────────────
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate(); // previne session fixation

        Log::info('[Admin Login] Login bem-sucedido', [
            'user_id' => Auth::id(),
            'email'   => Auth::user()->email,
            'ip'      => $request->ip(),
            'role'    => Auth::user()->roles->pluck('name')->join(', '),
        ]);

        return redirect()->intended(route('admin.dashboard'));
    }

    // ── Logout ────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Log::info('[Admin Login] Logout', [
            'user_id' => Auth::id(),
            'email'   => Auth::user()?->email,
            'ip'      => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sessão terminada com sucesso.');
    }

    // ── Helper ────────────────────────────────

    /**
     * Chave de throttle: combinação de email (normalizado) + IP.
     * Usar Str::transliterate para remover caracteres especiais.
     */
    private function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower($request->input('email', '')) . '|' . $request->ip()
        );
    }
}
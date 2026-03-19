<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Não autenticado → redirecionar para login (não 403 genérico)
        if (! $request->user()) {
            return redirect()->route('login')
                ->with('error', 'É necessário iniciar sessão para aceder ao painel.');
        }

        // Autenticado mas sem role → 403
        if (! $request->user()->hasRole($roles)) {
            abort(403, 'Não tem permissão para aceder a esta área.');
        }

        return $next($request);
    }
}
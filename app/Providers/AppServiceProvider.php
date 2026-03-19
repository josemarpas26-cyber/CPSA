<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useTailwind();

        // Máx. 3 inscrições por IP a cada 10 minutos (formulário público)
        RateLimiter::for('inscricao', function (Request $request) {
            return Limit::perMinutes(10, 3)
                ->by($request->ip())
                ->response(function () {
                    return redirect()
                        ->route('inscricao.create')
                        ->with('error', 'Muitas tentativas. Aguarde alguns minutos antes de tentar novamente.');
                });
        });

        // O rate limiting do login admin é tratado directamente no
        // AdminAuthController via RateLimiter::tooManyAttempts(),
        // o que permite logging granular e mensagens personalizadas.
    }
}
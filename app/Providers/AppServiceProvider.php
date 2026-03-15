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
        // Máx. 3 inscrições por IP a cada 10 minutos
        RateLimiter::for('inscricao', function (Request $request) {
            return Limit::perMinutes(10, 3)
                ->by($request->ip())
                ->response(function () {
                    return redirect()
                        ->route('inscricao.create')
                        ->with('error',
                            'Muitas tentativas. Aguarde alguns minutos antes de tentar novamente.'
                        );
                });
        });

        // Máx. 5 tentativas de login por minuto
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->input('email') . '|' . $request->ip());
        });
    }
}
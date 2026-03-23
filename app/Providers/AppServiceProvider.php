<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useTailwind();

        // ── HTTPS forçado em produção (Railway, Render, etc.) ────
        // Railway usa proxy reverso — o Laravel precisa saber que está atrás de HTTPS
        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            // Confiar no proxy do Railway (X-Forwarded-For, X-Forwarded-Proto)
            $this->app['request']->setTrustedProxies(
                ['REMOTE_ADDR', '0.0.0.0/0'],
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_FOR |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PORT |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PROTO |
                \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_PREFIX
            );
        }

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
    }
}
<?php

namespace App\Jobs;

use App\Models\Inscricao;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class NotificarComissao implements ShouldQueue
{
    use Queueable;

    public int $tries   = 3;
    public int $backoff = 30;

    public function __construct(public Inscricao $inscricao) {}

    public function handle(): void
    {
        // Buscar todos os admins e organizadores
        $destinatarios = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['admin', 'organizador']);
        })->pluck('email')->toArray();

        if (empty($destinatarios)) {
            return;
        }

        Mail::to($destinatarios)
            ->send(new \App\Mail\NovaInscricaoComissao($this->inscricao));
    }
}
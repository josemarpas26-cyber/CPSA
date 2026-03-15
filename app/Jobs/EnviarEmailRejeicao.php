<?php

namespace App\Jobs;

use App\Mail\InscricaoRejeitada;
use App\Models\Inscricao;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EnviarEmailRejeicao implements ShouldQueue
{
    use Queueable;

    public int $tries   = 3;
    public int $backoff = 60;

    public function __construct(public Inscricao $inscricao) {}

    public function handle(): void
    {
        Mail::to($this->inscricao->email)
            ->send(new InscricaoRejeitada($this->inscricao));
    }
}
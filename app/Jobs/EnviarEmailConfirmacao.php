<?php

namespace App\Jobs;

use App\Models\Inscricao;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class EnviarEmailConfirmacao implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(public Inscricao $inscricao) {}

    public function handle(): void
    {
        Mail::to($this->inscricao->email)
            ->send(new \App\Mail\InscricaoConfirmada($this->inscricao));
    }
}
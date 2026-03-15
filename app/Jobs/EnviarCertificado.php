<?php

namespace App\Jobs;

use App\Mail\CertificadoDisponivel;
use App\Models\Certificado;
use App\Models\Inscricao;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EnviarCertificado implements ShouldQueue
{
    use Queueable;

    public int $tries   = 3;
    public int $backoff = 60;

    public function __construct(
        public Inscricao    $inscricao,
        public Certificado  $certificado
    ) {}

    public function handle(): void
    {
        Mail::to($this->inscricao->email)
            ->send(new CertificadoDisponivel($this->inscricao, $this->certificado));

        $this->certificado->update(['enviado_em' => now()]);
    }
}
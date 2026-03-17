<?php

namespace App\Mail;

use App\Models\Certificado;
use App\Models\Inscricao;
use App\Services\CertificadoService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificadoDisponivel extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Inscricao   $inscricao,
        public Certificado $certificado
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🏅 O seu Certificado — CPSM 2026 | {$this->inscricao->numero}",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.certificado-disponivel');
    }

    public function attachments(): array
    {
        $service  = app(CertificadoService::class);
        $conteudo = $service->conteudo($this->certificado);

        return [
            Attachment::fromData(
                fn () => $conteudo,
                "certificado-{$this->inscricao->numero}.pdf"
            )->withMime('application/pdf'),
        ];
    }
}
<?php

namespace App\Mail;

use App\Models\Inscricao;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscricaoAprovada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inscricao $inscricao) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "✅ Inscrição Aprovada — {$this->inscricao->numero} | CPSM 2026",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.inscricao-aprovada');
    }
}
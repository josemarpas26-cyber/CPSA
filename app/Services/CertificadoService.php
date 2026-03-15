<?php

namespace App\Services;

use App\Jobs\EnviarCertificado;
use App\Models\Certificado;
use App\Models\Inscricao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificadoService
{
    /**
     * Gera o certificado PDF para uma inscrição aprovada.
     */
public function gerar(Inscricao $inscricao): Certificado
{
    if ($inscricao->status !== 'aprovada') {
        throw new \RuntimeException('Só é possível gerar certificados para inscrições aprovadas.');
    }

    // 1️⃣ Criar certificado primeiro
    $certificado = Certificado::updateOrCreate(
        ['inscricao_id' => $inscricao->id],
        [
            'codigo_verificacao' => 'CPSA-' . Str::upper(Str::random(8)),
            'gerado_em' => now(),
        ]
    );

    // 2️⃣ Gerar PDF com certificado disponível
    $pdf = Pdf::loadView('pdf.certificado', [
        'inscricao' => $inscricao,
        'certificado' => $certificado
    ])
    ->setPaper('a4', 'landscape')
    ->setOptions([
        'defaultFont' => 'DejaVu Sans',
        'isHtml5ParserEnabled' => true,
        'dpi' => 150,
    ]);

    $ano = now()->year;
    $filename = "certificado-{$inscricao->numero}.pdf";
    $path = "certificados/{$ano}/{$filename}";

    Storage::disk('private')->put($path, $pdf->output());

    // 3️⃣ atualizar path
    $certificado->update([
        'path' => $path
    ]);

    // 4️⃣ enviar email
    EnviarCertificado::dispatch($inscricao, $certificado)->onQueue('emails');

    return $certificado;
}

    /**
     * Gera certificados em lote para todas as aprovadas sem certificado.
     */
    public function gerarTodos(): int
    {
        $inscricoes = Inscricao::where('status', 'aprovada')
            ->whereDoesntHave('certificado')
            ->get();

        foreach ($inscricoes as $inscricao) {
            $this->gerar($inscricao);
        }

        return $inscricoes->count();
    }

    /**
     * Retorna o conteúdo binário do PDF para stream/download.
     */
    public function conteudo(Certificado $certificado): string
    {
        return Storage::disk('private')->get($certificado->path);
    }
}
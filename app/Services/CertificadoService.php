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

        // Gerar PDF
        $pdf = Pdf::loadView('pdf.certificado', compact('inscricao'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'          => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'dpi'                  => 150,
            ]);

        // Path de destino
        $ano      = now()->year;
        $filename = "certificado-{$inscricao->numero}.pdf";
        $path     = "certificados/{$ano}/{$filename}";

        // Salvar em disco privado
        Storage::disk('private')->put($path, $pdf->output());

        // Criar ou actualizar registo
        $certificado = Certificado::updateOrCreate(
            ['inscricao_id' => $inscricao->id],
            [
                'path'               => $path,
                'codigo_verificacao' => Str::uuid()->toString(),
                'gerado_em'          => now(),
            ]
        );

        // Disparar envio por email
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
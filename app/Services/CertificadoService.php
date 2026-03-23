<?php

namespace App\Services;

use App\Models\Certificado;
use App\Models\Inscricao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificadoService
{
    /**
     * Gera o certificado PDF para uma inscrição aprovada.
     * NÃO envia email — o download é feito manualmente pelo admin.
     *
     * @throws \RuntimeException
     */
    public function gerar(Inscricao $inscricao): Certificado
    {
        if ($inscricao->status !== 'aprovada') {
            throw new \RuntimeException(
                "Só é possível gerar certificados para inscrições aprovadas. " .
                "A inscrição {$inscricao->numero} tem estado: {$inscricao->status}."
            );
        }

        $certificado = Certificado::updateOrCreate(
            ['inscricao_id' => $inscricao->id],
            [
                'codigo_verificacao' => 'CPSA-' . Str::upper(Str::random(8)),
                'gerado_em'          => now(),
            ]
        );

        $pdf = Pdf::loadView('pdf.certificado', [
            'inscricao'   => $inscricao,
            'certificado' => $certificado,
        ])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'          => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'dpi'                  => 150,
            ]);

        $conteudo = $pdf->output();
        if (empty($conteudo)) {
            throw new \RuntimeException(
                "Falha na geração do PDF para a inscrição {$inscricao->numero}."
            );
        }

        $ano      = now()->year;
        $filename = "certificado-{$inscricao->numero}.pdf";
        $path     = "certificados/{$ano}/{$filename}";

        $guardado = Storage::disk('private')->put($path, $conteudo);
        if (! $guardado) {
            throw new \RuntimeException(
                "Falha ao guardar o certificado no armazenamento para {$inscricao->numero}."
            );
        }

        $certificado->update(['path' => $path]);

        // ── SEM envio de email ────────────────────────────────────
        // O download é feito pelo admin directamente no painel.
        // Para enviar por email, use o método enviarEmail() separadamente.

        return $certificado;
    }

    /**
     * Gera certificados em lote para todas as inscrições aprovadas sem certificado.
     * Não envia emails.
     */
    public function gerarTodos(): int
    {
        $inscricoes = Inscricao::aprovada()
            ->whereDoesntHave('certificado')
            ->get();

        $total = 0;
        foreach ($inscricoes as $inscricao) {
            try {
                $this->gerar($inscricao);
                $total++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error(
                    "Erro ao gerar certificado para {$inscricao->numero}: " . $e->getMessage()
                );
            }
        }

        return $total;
    }

    /**
     * Retorna o conteúdo binário do PDF para stream/download.
     *
     * @throws \RuntimeException se o ficheiro não existir
     */
    public function conteudo(Certificado $certificado): string
    {
        if (! Storage::disk('private')->exists($certificado->path)) {
            throw new \RuntimeException(
                'Ficheiro do certificado não encontrado no armazenamento.'
            );
        }

        return Storage::disk('private')->get($certificado->path);
    }
}
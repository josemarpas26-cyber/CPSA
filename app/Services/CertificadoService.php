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
     *
     * @throws \RuntimeException se a inscrição não estiver aprovada ou se falhar a geração/armazenamento
     */
    public function gerar(Inscricao $inscricao): Certificado
    {
        if ($inscricao->status !== 'aprovada') {
            throw new \RuntimeException('Só é possível gerar certificados para inscrições aprovadas.');
        }

        // 1️⃣ Criar/actualizar registo do certificado na BD
        $certificado = Certificado::updateOrCreate(
            ['inscricao_id' => $inscricao->id],
            [
                'codigo_verificacao' => 'CPSA-' . Str::upper(Str::random(8)),
                'gerado_em'          => now(),
            ]
        );

        // 2️⃣ Gerar o PDF
        $pdf = Pdf::loadView('pdf.certificado', [
            'inscricao'   => $inscricao,
            'certificado' => $certificado,
        ])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'         => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'dpi'                 => 150,
            ]);

        // FIX: Verificar que o PDF foi gerado com conteúdo válido
        $conteudo = $pdf->output();
        if (empty($conteudo)) {
            throw new \RuntimeException("Falha na geração do PDF para a inscrição {$inscricao->numero}.");
        }

        $ano      = now()->year;
        $filename = "certificado-{$inscricao->numero}.pdf";
        $path     = "certificados/{$ano}/{$filename}";

        // FIX: Verificar que o ficheiro foi guardado com sucesso
        $guardado = Storage::disk('private')->put($path, $conteudo);
        if (! $guardado) {
            throw new \RuntimeException("Falha ao guardar o certificado no armazenamento para {$inscricao->numero}.");
        }

        // 3️⃣ Actualizar o path no registo
        $certificado->update(['path' => $path]);

        // 4️⃣ Despachar job de envio por email
        EnviarCertificado::dispatch($inscricao, $certificado)->onQueue('emails');

        return $certificado;
    }

    /**
     * Gera certificados em lote para todas as aprovadas sem certificado.
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
                // Log o erro mas continua para as restantes inscrições
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
     * @throws \RuntimeException se o ficheiro não existir no disco
     */
    public function conteudo(Certificado $certificado): string
    {
        if (! Storage::disk('private')->exists($certificado->path)) {
            throw new \RuntimeException('Ficheiro do certificado não encontrado no armazenamento.');
        }

        return Storage::disk('private')->get($certificado->path);
    }
}
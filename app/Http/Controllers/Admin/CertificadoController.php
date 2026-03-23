<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use App\Models\Inscricao;
use App\Services\CertificadoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use ZipArchive;

class CertificadoController extends Controller
{
    public function __construct(private CertificadoService $service) {}

    /** Listagem de certificados */
    public function index(): View
    {
        $aprovadas = Inscricao::where('status', 'aprovada')
            ->with('certificado')
            ->orderBy('full_name')
            ->paginate(20);

        $stats = [
            'aprovadas' => Inscricao::where('status', 'aprovada')->count(),
            'com_cert'  => Certificado::count(),
            'sem_cert'  => Inscricao::where('status', 'aprovada')
                              ->whereDoesntHave('certificado')->count(),
            'enviados'  => Certificado::whereNotNull('enviado_em')->count(),
        ];

        return view('admin.certificados.index', compact('aprovadas', 'stats'));
    }

    /** Gerar certificado individual — SEM envio de email */
    public function gerar(Inscricao $inscricao): RedirectResponse
    {
        // Só inscrições aprovadas
        if ($inscricao->status !== 'aprovada') {
            return back()->with('error',
                "Não é possível gerar certificado: a inscrição {$inscricao->numero} não está aprovada."
            );
        }

        try {
            $this->service->gerar($inscricao);

            return back()->with('success',
                "Certificado de {$inscricao->full_name} gerado com sucesso. Pode descarregá-lo abaixo."
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** Gerar certificados em lote — SEM envio de email */
    public function gerarTodos(): RedirectResponse
    {
        $total = $this->service->gerarTodos();

        return back()->with('success',
            "{$total} certificado(s) gerado(s) com sucesso. Pode descarregá-los individualmente ou em bloco."
        );
    }

    /** Download individual (admin) — abre inline no browser */
    public function download(Certificado $certificado): Response
    {
        $conteudo = $this->service->conteudo($certificado);

        return response($conteudo, 200, [
            'Content-Type'        => 'application/pdf',
            // 'inline' faz o browser abrir o PDF em vez de descarregar
            'Content-Disposition' => "inline; filename=certificado-{$certificado->inscricao->numero}.pdf",
        ]);
    }

    /**
     * Download em massa — ZIP com os certificados seleccionados.
     * Recebe POST com array de IDs de certificados.
     */
    public function downloadMassa(Request $request): Response|RedirectResponse
    {
        $request->validate([
            'certificado_ids'   => ['required', 'array', 'min:1'],
            'certificado_ids.*' => ['integer', 'exists:certificados,id'],
        ], [
            'certificado_ids.required' => 'Seleccione pelo menos um certificado.',
            'certificado_ids.min'      => 'Seleccione pelo menos um certificado.',
        ]);

        $certificados = Certificado::with('inscricao')
            ->whereIn('id', $request->certificado_ids)
            ->get();

        if ($certificados->isEmpty()) {
            return back()->with('error', 'Nenhum certificado encontrado.');
        }

        // Se só um certificado, descarrega directamente sem ZIP
        if ($certificados->count() === 1) {
            return $this->download($certificados->first());
        }

        // Criar ZIP em memória
        $tmpPath = storage_path('app/tmp/certificados-' . now()->format('YmdHis') . '.zip');

        // Garantir que a pasta tmp existe
        if (! is_dir(storage_path('app/tmp'))) {
            mkdir(storage_path('app/tmp'), 0775, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($tmpPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Não foi possível criar o arquivo ZIP.');
        }

        $adicionados = 0;
        foreach ($certificados as $cert) {
            try {
                $conteudo = $this->service->conteudo($cert);
                $filename = "certificado-{$cert->inscricao->numero}.pdf";
                $zip->addFromString($filename, $conteudo);
                $adicionados++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning(
                    "Certificado {$cert->id} não encontrado para ZIP: " . $e->getMessage()
                );
            }
        }

        $zip->close();

        if ($adicionados === 0) {
            @unlink($tmpPath);
            return back()->with('error', 'Nenhum ficheiro de certificado encontrado no armazenamento.');
        }

        $zipContent = file_get_contents($tmpPath);
        @unlink($tmpPath); // limpar ficheiro temporário

        return response($zipContent, 200, [
            'Content-Type'        => 'application/zip',
            'Content-Disposition' => 'attachment; filename=certificados-cpsm2026-' . now()->format('Y-m-d') . '.zip',
            'Content-Length'      => strlen($zipContent),
        ]);
    }

    /**
     * Download de TODOS os certificados gerados (ZIP).
     */
    public function downloadTodos(): Response|RedirectResponse
    {
        $certificados = Certificado::with('inscricao')
            ->whereNotNull('path')
            ->get();

        if ($certificados->isEmpty()) {
            return back()->with('error', 'Ainda não foram gerados certificados.');
        }

        $tmpPath = storage_path('app/tmp/todos-certificados-' . now()->format('YmdHis') . '.zip');

        if (! is_dir(storage_path('app/tmp'))) {
            mkdir(storage_path('app/tmp'), 0775, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($tmpPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Não foi possível criar o arquivo ZIP.');
        }

        $adicionados = 0;
        foreach ($certificados as $cert) {
            try {
                $conteudo = $this->service->conteudo($cert);
                $zip->addFromString("certificado-{$cert->inscricao->numero}.pdf", $conteudo);
                $adicionados++;
            } catch (\Exception $e) {
                // ficheiro em falta — continua
            }
        }

        $zip->close();

        if ($adicionados === 0) {
            @unlink($tmpPath);
            return back()->with('error', 'Nenhum ficheiro de certificado encontrado no armazenamento.');
        }

        $zipContent = file_get_contents($tmpPath);
        @unlink($tmpPath);

        return response($zipContent, 200, [
            'Content-Type'        => 'application/zip',
            'Content-Disposition' => 'attachment; filename=todos-certificados-cpsm2026.zip',
            'Content-Length'      => strlen($zipContent),
        ]);
    }
}
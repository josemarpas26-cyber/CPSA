<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificado;
use App\Models\Inscricao;
use App\Services\CertificadoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CertificadoController extends Controller
{
    public function __construct(private CertificadoService $service) {}

    /** Listagem de certificados */
    public function index(): View
    {
        $aprovadas = Inscricao::where('status', 'aprovada')
            ->with('certificado')
            ->orderBy('nome_completo')
            ->paginate(20);

        $stats = [
            'aprovadas'   => Inscricao::where('status', 'aprovada')->count(),
            'com_cert'    => Certificado::count(),
            'sem_cert'    => Inscricao::where('status', 'aprovada')
                                ->whereDoesntHave('certificado')->count(),
            'enviados'    => Certificado::whereNotNull('enviado_em')->count(),
        ];

        return view('admin.certificados.index', compact('aprovadas', 'stats'));
    }

    /** Gerar certificado individual */
    public function gerar(Inscricao $inscricao): RedirectResponse
    {
        try {
            $this->service->gerar($inscricao);

            return back()->with('success',
                "Certificado de {$inscricao->nome_completo} gerado e enviado por email."
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** Gerar certificados em lote */
    public function gerarTodos(): RedirectResponse
    {
        $total = $this->service->gerarTodos();

        return back()->with('success',
            "{$total} certificado(s) gerado(s) e enviados para a queue de email."
        );
    }

    /** Download individual (admin) */
    public function download(Certificado $certificado): Response
    {
        $conteudo = $this->service->conteudo($certificado);

        return response($conteudo, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=certificado-{$certificado->inscricao->numero}.pdf",
        ]);
    }
}
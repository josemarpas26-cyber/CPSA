<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvaliacaoRequest;
use App\Models\Inscricao;
use App\Services\InscricaoService;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
class InscricaoController extends Controller
{
    public function __construct(private InscricaoService $service) {}

    // ─── Listagem ─────────────────────────────

    public function index(Request $request): View
    {
        $query = Inscricao::with('comprovativo')->latest();

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo_participacao', $request->tipo);
        }

        // Busca por nome, email ou número
        if ($request->filled('busca')) {
            $termo = $request->busca;
            $query->where(function ($q) use ($termo) {
                $q->where('nome_completo', 'like', "%{$termo}%")
                  ->orWhere('email', 'like', "%{$termo}%")
                  ->orWhere('numero', 'like', "%{$termo}%")
                  ->orWhere('instituicao', 'like', "%{$termo}%");
            });
        }

        $inscricoes = $query->paginate(15)->withQueryString();

        // Contadores para badges nos filtros
        $contadores = [
            'total'      => Inscricao::count(),
            'pendente'   => Inscricao::where('status', 'pendente')->count(),
            'em_analise' => Inscricao::where('status', 'em_analise')->count(),
            'aprovada'   => Inscricao::where('status', 'aprovada')->count(),
            'rejeitada'  => Inscricao::where('status', 'rejeitada')->count(),
        ];

        return view('admin.inscricoes.index', compact('inscricoes', 'contadores'));
    }

    // ─── Detalhe ──────────────────────────────

    public function show(Inscricao $inscricao): View
    {
        $inscricao->load(['comprovativo', 'certificado', 'avaliador']);

        // URL temporária (5 min) para visualização segura do comprovativo
        $urlComprovativo = $inscricao->comprovativo
            ? $inscricao->comprovativo->urlTemporaria(5)
            : null;

        return view('admin.inscricoes.show', compact('inscricao', 'urlComprovativo'));
    }

    // ─── Aprovar ──────────────────────────────

    public function aprovar(AvaliacaoRequest $request, Inscricao $inscricao): RedirectResponse
    {
        if (! in_array($inscricao->status, ['pendente', 'em_analise'])) {
            return back()->with('error', 'Esta inscrição não pode ser aprovada.');
        }

        $this->service->aprovar($inscricao);

        return redirect()
            ->route('admin.inscricoes.show', $inscricao)
            ->with('success', "Inscrição {$inscricao->numero} aprovada com sucesso.");
    }

    // ─── Rejeitar ─────────────────────────────

    public function rejeitar(AvaliacaoRequest $request, Inscricao $inscricao): RedirectResponse
    {
        if ($inscricao->status === 'aprovada') {
            return back()->with('error', 'Não é possível rejeitar uma inscrição já aprovada.');
        }

        $this->service->rejeitar($inscricao, $request->motivo_rejeicao);

        return redirect()
            ->route('admin.inscricoes.index')
            ->with('success', "Inscrição {$inscricao->numero} rejeitada.");
    }

    /** Download seguro do certificado pelo participante */
public function downloadCertificado(): Response|RedirectResponse
{
    $inscricao = \App\Models\Inscricao::where('user_id', auth()->id())
        ->where('status', 'aprovada')
        ->whereHas('certificado')
        ->with('certificado')
        ->latest()
        ->first();

    if (! $inscricao?->certificado) {
        return redirect()
            ->route('participant.minha-inscricao')
            ->with('error', 'Certificado não disponível.');
    }

    $service  = app(\App\Services\CertificadoService::class);
    $conteudo = $service->conteudo($inscricao->certificado);

    return response($conteudo, 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => "attachment; filename=certificado-{$inscricao->numero}.pdf",
    ]);
}
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvaliacaoRequest;
use App\Http\Requests\AtualizarDadosInscricaoRequest;
use App\Models\Inscricao;
use App\Models\InscricaoAlteracaoLog;
use App\Services\InscricaoService;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $query->where('participation_mode', $request->tipo);
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

        // FIX: Consolidar 5 queries separadas numa única query agregada
        $contadoresRaw = Inscricao::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $contadores = [
            'total'      => array_sum($contadoresRaw),
            'pendente'   => $contadoresRaw['pendente']    ?? 0,
            'em_analise' => $contadoresRaw['em_analise']  ?? 0,
            'aprovada'   => $contadoresRaw['aprovada']    ?? 0,
            'rejeitada'  => $contadoresRaw['rejeitada']   ?? 0,
        ];

        return view('admin.inscricoes.index', compact('inscricoes', 'contadores'));
    }

    // ─── Detalhe ──────────────────────────────

    public function show(Inscricao $inscricao): View
    {
        $inscricao->load(['comprovativo', 'certificado', 'avaliador', 'alteracoes.editor']);

        // URL para visualização segura do comprovativo
        $urlComprovativo = $inscricao->comprovativo
            ? $inscricao->comprovativo->urlTemporaria(5)
            : null;

        return view('admin.inscricoes.show', compact('inscricao', 'urlComprovativo'));
    }

    // ─── Actualização de dados do participante ──────────────────────────────

    public function atualizarDados(AtualizarDadosInscricaoRequest $request, Inscricao $inscricao): RedirectResponse
    {
        $dados     = $request->validated();
        $alteracoes = [];

        foreach ($dados as $campo => $novoValor) {
            $valorAtual = $inscricao->{$campo};
            if ((string) $valorAtual !== (string) $novoValor) {
                $alteracoes[$campo] = [
                    'antes'  => (string) $valorAtual,
                    'depois' => (string) $novoValor,
                ];
            }
        }

        if (empty($alteracoes)) {
            return back()->with('info', 'Nenhuma alteração detectada nos dados do participante.');
        }

        DB::transaction(function () use ($inscricao, $dados, $alteracoes) {
            $inscricao->update($dados);

            foreach ($alteracoes as $campo => $valores) {
                InscricaoAlteracaoLog::create([
                    'inscricao_id'   => $inscricao->id,
                    'editor_id'      => auth()->id(),
                    'campo'          => $campo,
                    'valor_anterior' => $valores['antes'],
                    'valor_novo'     => $valores['depois'],
                    'editado_em'     => now(),
                ]);
            }
        });

        return redirect()
            ->route('admin.inscricoes.show', $inscricao)
            ->with('success', 'Dados do participante actualizados com sucesso.');
    }

    // ─── Marcar Em Análise ────────────────────

    /**
     * Transição explícita de pendente → em_analise.
     * Útil para sinalizar que a comissão está a analisar sem ainda decidir.
     */
    public function marcarEmAnalise(Inscricao $inscricao): RedirectResponse
    {
        if ($inscricao->status !== 'pendente') {
            return back()->with('error', 'Só inscrições pendentes podem ser marcadas em análise.');
        }

        $inscricao->update([
            'status'       => 'em_analise',
            'avaliado_por' => Auth::id(),
        ]);

        return back()->with('success', "Inscrição {$inscricao->numero} marcada como em análise.");
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

    // ─── Check-in no evento ───────────────────

    /**
     * Regista a presença do participante no evento.
     */
    public function checkin(Inscricao $inscricao): RedirectResponse
    {
        if ($inscricao->status !== 'aprovada') {
            return back()->with('error', 'Apenas participantes aprovados podem fazer check-in.');
        }

        if ($inscricao->presente) {
            return back()->with('info', "Check-in de {$inscricao->nome_completo} já foi registado.");
        }

        $inscricao->update([
            'presente'   => true,
            'checkin_em' => now(),
        ]);

        return back()->with('success', "Check-in de {$inscricao->nome_completo} registado com sucesso.");
    }
}
<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests\InscricaoRequest;
use App\Models\Curso;
use App\Models\Inscricao;
use App\Services\CertificadoService;
use App\Services\InscricaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class InscricaoController extends Controller
{
    public function __construct(
        private InscricaoService $service,
        private CertificadoService $certificadoService,
    ) {}

    /** Página inicial pública */
    public function index(): View
    {
        return view('participant.index');
    }

    /** Formulário de inscrição — carrega cursos activos */
    public function create(): View
    {
        $cursos = Curso::ativo()
            ->with(['speakers', 'inscricoes'])
            ->ordenado()
            ->get();

        return view('participant.inscricao', compact('cursos'));
    }

    /** Processar submissão */
    public function store(InscricaoRequest $request): RedirectResponse
    {
        $inscricao = $this->service->criar(
            $request->validated(),
            $request->file('comprovativo')
        );

        return redirect()
            ->route('inscricao.sucesso')
            ->with('inscricao_numero', $inscricao->numero)
            ->with('inscricao_email', $inscricao->email);
    }

    /** Página de sucesso */
    public function sucesso(): View|RedirectResponse
    {
        if (! session('inscricao_numero')) {
            return redirect()->route('inscricao.create');
        }
        return view('participant.sucesso');
    }

    /** Área do participante */
    public function show(): View
    {
        $inscricao = Inscricao::where('user_id', auth()->id())
            ->with(['comprovativo', 'certificado', 'inscricaoCurso.curso.speakers'])
            ->latest()
            ->first();

        $inscricaoComCertificado = Inscricao::where('user_id', auth()->id())
            ->whereHas('certificado')
            ->with('certificado')
            ->latest()
            ->first();

        return view('participant.minha-inscricao', compact('inscricao', 'inscricaoComCertificado'));
    }

    /** Download do certificado */
    public function downloadCertificado(): Response|RedirectResponse
    {
        $inscricao = Inscricao::where('user_id', auth()->id())
            ->whereHas('certificado')
            ->with('certificado')
            ->latest()
            ->first();

        if (! $inscricao) {
            return redirect()
                ->route('participant.minha-inscricao')
                ->with('error', 'Ainda não existe nenhum certificado disponível.');
        }

        $conteudo = $this->certificadoService->conteudo($inscricao->certificado);

        return response($conteudo, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=certificado-{$inscricao->numero}.pdf",
        ]);
    }
}
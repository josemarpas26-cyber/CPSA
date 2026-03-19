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
        private InscricaoService   $service,
        private CertificadoService $certificadoService,
    ) {}

    /** Página inicial pública */
    public function index(): View
    {
        return view('participant.index');
    }

    /** Formulário de inscrição */
    public function create(): View
    {
        $cursos = Curso::ativo()
            ->with(['speakers', 'inscricoes'])
            ->ordenado()
            ->get();

        return view('participant.inscricao', compact('cursos'));
    }

    /** Processar submissão do formulário */
    public function store(InscricaoRequest $request): RedirectResponse
    {
        $inscricao = $this->service->criar(
            $request->validated(),
            $request->file('comprovativo')
        );

        return redirect()
            ->route('inscricao.sucesso')
            ->with('inscricao_numero', $inscricao->numero)
            ->with('inscricao_email',  $inscricao->email)
            ->with('inscricao_token',  $inscricao->access_token);
    }

    /** Página de confirmação pós-submissão */
    public function sucesso(): View|RedirectResponse
    {
        if (! session('inscricao_numero')) {
            return redirect()->route('inscricao.create');
        }

        return view('participant.sucesso');
    }

    /**
     * Área pessoal do participante via token único.
     * Sem login — o link é enviado por email na confirmação.
     */
    public function consultar(string $token): View|RedirectResponse
    {
        $inscricao = Inscricao::where('access_token', $token)
            ->with(['comprovativo', 'certificado', 'inscricaoCurso.curso.speakers'])
            ->first();

        if (! $inscricao) {
            return redirect()
                ->route('home')
                ->with('error', 'Link inválido ou expirado. Consulte o email de confirmação.');
        }

        return view('participant.minha-inscricao', compact('inscricao'));
    }

    /**
     * Download do certificado via token único.
     * Disponível apenas após aprovação e geração do certificado.
     */
    public function downloadCertificado(string $token): Response|RedirectResponse
    {
        $inscricao = Inscricao::where('access_token', $token)
            ->with('certificado')
            ->first();

        if (! $inscricao) {
            return redirect()->route('home')
                ->with('error', 'Link inválido. Consulte o email de confirmação.');
        }

        if (! $inscricao->certificado) {
            return redirect()
                ->route('inscricao.consultar', $token)
                ->with('error', 'O certificado ainda não está disponível.');
        }

        $conteudo = $this->certificadoService->conteudo($inscricao->certificado);

        return response($conteudo, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=certificado-{$inscricao->numero}.pdf",
        ]);
    }
}
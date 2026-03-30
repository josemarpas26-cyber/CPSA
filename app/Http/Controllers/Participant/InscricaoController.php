<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests\InscricaoRequest;
use App\Models\Curso;
use App\Services\InscricaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Speaker;

class InscricaoController extends Controller
{
    public function __construct(
        private InscricaoService $service,
    ) {}

    /** Página inicial pública */
    public function index(): View
    {
        $cursos   = Curso::ativo()->with(['speakers','inscricoes'])->ordenado()->get();
        $speakers = Speaker::destaque()->ativo()->ordenado()->take(4)->get();
        return view('participant.index', compact('cursos', 'speakers'));
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
            ->with('inscricao_email',  $inscricao->email);
    }

    /** Página de confirmação pós-submissão */
    public function sucesso(): View|RedirectResponse
    {
        if (! session('inscricao_numero')) {
            return redirect()->route('inscricao.create');
        }

        return view('participant.sucesso');
    }
}
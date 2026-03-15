<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests\InscricaoRequest;
use App\Models\Inscricao;
use App\Services\InscricaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InscricaoController extends Controller
{
    public function __construct(private InscricaoService $service) {}

    /** Página inicial pública */
    public function index(): View
    {
        return view('participant.index');
    }

    /** Formulário de inscrição */
    public function create(): View
    {
        return view('participant.inscricao');
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
    public function sucesso(): View
    {
        // Prevenir acesso directo sem submissão
        if (! session('inscricao_numero')) {
            return redirect()->route('inscricao.create');
        }

        return view('participant.sucesso');
    }

    /** Área do participante */
    public function show(): View
    {
        $inscricao = Inscricao::where('user_id', auth()->id())
            ->with(['comprovativo', 'certificado'])
            ->latest()
            ->first();

        return view('participant.minha-inscricao', compact('inscricao'));
    }
}
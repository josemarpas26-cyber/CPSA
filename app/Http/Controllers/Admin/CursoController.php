<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Speaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CursoController extends Controller
{
    // ── Listagem ──────────────────────────────

    public function index(): View
    {
        $cursos = Curso::with(['speakers', 'inscricoes'])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->orderBy('ordem')
            ->paginate(20);

        return view('admin.cursos.index', compact('cursos'));
    }

    // ── Formulário criar ──────────────────────

    public function create(): View
    {
        $speakers = Speaker::ativo()->ordenado()->get();
        return view('admin.cursos.form', [
            'curso'    => new Curso,
            'speakers' => $speakers,
        ]);
    }

    // ── Guardar novo ──────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $data        = $this->validar($request);
        $speakerIds  = $request->input('speaker_ids', []);

        $curso = Curso::create($data);
        $curso->speakers()->sync($speakerIds);

        return redirect()
            ->route('admin.cursos.index')
            ->with('success', 'Curso criado com sucesso.');
    }

    // ── Formulário editar ─────────────────────

    public function edit(Curso $curso): View
    {
        $curso->load('speakers');
        $speakers = Speaker::ativo()->ordenado()->get();

        return view('admin.cursos.form', compact('curso', 'speakers'));
    }

    // ── Actualizar ────────────────────────────

    public function update(Request $request, Curso $curso): RedirectResponse
    {
        $data       = $this->validar($request);
        $speakerIds = $request->input('speaker_ids', []);

        $curso->update($data);
        $curso->speakers()->sync($speakerIds);

        return redirect()
            ->route('admin.cursos.index')
            ->with('success', 'Curso actualizado com sucesso.');
    }

    // ── Eliminar ──────────────────────────────

    public function destroy(Curso $curso): RedirectResponse
    {
        if ($curso->inscricoes()->exists()) {
            return back()->with('error',
                'Não é possível eliminar um curso com inscrições associadas.'
            );
        }

        $curso->speakers()->detach();
        $curso->delete();

        return redirect()
            ->route('admin.cursos.index')
            ->with('success', 'Curso eliminado.');
    }

    // ── Toggle ativo ──────────────────────────

    public function toggleAtivo(Curso $curso): RedirectResponse
    {
        $curso->update(['ativo' => ! $curso->ativo]);
        return back()->with('success', 'Estado do curso actualizado.');
    }

    // ── Helper de validação ───────────────────

    private function validar(Request $request): array
    {
        return $request->validate([
            'nome'        => ['required', 'string', 'max:255'],
            'descricao'   => ['nullable', 'string'],
            'sala'        => ['required', 'string', 'max:150'],
            'dia'         => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim'    => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'vagas'       => ['nullable', 'integer', 'min:1'],
            'ordem'       => ['integer', 'min:0'],
            'ativo'       => ['boolean'],
            'speaker_ids' => ['nullable', 'array'],
            'speaker_ids.*' => ['exists:speakers,id'],
        ], [
            'nome.required'        => 'O nome do curso é obrigatório.',
            'sala.required'        => 'A sala é obrigatória.',
            'dia.required'         => 'O dia é obrigatório.',
            'hora_inicio.required' => 'A hora de início é obrigatória.',
            'hora_fim.required'    => 'A hora de fim é obrigatória.',
            'hora_fim.after'       => 'A hora de fim deve ser posterior à hora de início.',
        ]);
    }
}
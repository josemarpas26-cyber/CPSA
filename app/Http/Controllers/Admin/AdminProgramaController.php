<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramaActividade;
use App\Models\Speaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProgramaController extends Controller
{
    // ── Listagem ──────────────────────────────

    public function index(): View
    {
        $actividades = ProgramaActividade::with('speakers')
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->orderBy('ordem')
            ->paginate(30);

        // Contadores por dia
        $statsDias = [
            '2026-08-13' => ProgramaActividade::where('dia', '2026-08-13')->count(),
            '2026-08-14' => ProgramaActividade::where('dia', '2026-08-14')->count(),
            '2026-08-15' => ProgramaActividade::where('dia', '2026-08-15')->count(),
        ];

        return view('admin.programa.index', compact('actividades', 'statsDias'));
    }

    // ── Formulário criar ──────────────────────

    public function create(): View
    {
        $speakers = Speaker::ativo()->ordenado()->get();
        return view('admin.programa.form', [
            'actividade' => new ProgramaActividade,
            'speakers'   => $speakers,
            'tipos'      => ProgramaActividade::tipos(),
            'dias'       => ProgramaActividade::dias(),
        ]);
    }

    // ── Guardar novo ──────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $data       = $this->validar($request);
        $speakerIds = $request->input('speaker_ids', []);

        $actividade = ProgramaActividade::create($data);
        $actividade->speakers()->sync($speakerIds);

        return redirect()
            ->route('admin.programa.index')
            ->with('success', 'Actividade criada com sucesso.');
    }

    // ── Formulário editar ─────────────────────

    public function edit(ProgramaActividade $programa): View
    {
        $programa->load('speakers');
        $speakers = Speaker::ativo()->ordenado()->get();

        return view('admin.programa.form', [
            'actividade' => $programa,
            'speakers'   => $speakers,
            'tipos'      => ProgramaActividade::tipos(),
            'dias'       => ProgramaActividade::dias(),
        ]);
    }

    // ── Actualizar ────────────────────────────

    public function update(Request $request, ProgramaActividade $programa): RedirectResponse
    {
        $data       = $this->validar($request);
        $speakerIds = $request->input('speaker_ids', []);

        $programa->update($data);
        $programa->speakers()->sync($speakerIds);

        return redirect()
            ->route('admin.programa.index')
            ->with('success', 'Actividade actualizada com sucesso.');
    }

    // ── Eliminar ──────────────────────────────

    public function destroy(ProgramaActividade $programa): RedirectResponse
    {
        $programa->speakers()->detach();
        $programa->delete();

        return redirect()
            ->route('admin.programa.index')
            ->with('success', 'Actividade eliminada.');
    }

    // ── Toggle ativo ──────────────────────────

    public function toggleAtivo(ProgramaActividade $programa): RedirectResponse
    {
        $programa->update(['ativo' => ! $programa->ativo]);
        return back()->with('success', 'Estado actualizado.');
    }

    // ── Helper de validação ───────────────────

    private function validar(Request $request): array
    {
        return $request->validate([
            'nome'        => ['required', 'string', 'max:255'],
            'descricao'   => ['nullable', 'string'],
            'tipo'        => ['required', 'in:' . implode(',', array_keys(ProgramaActividade::tipos()))],
            'sala'        => ['nullable', 'string', 'max:150'],
            'dia'         => ['required', 'in:2026-08-13,2026-08-14,2026-08-15'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim'    => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'ordem'       => ['integer', 'min:0'],
            'ativo'       => ['boolean'],
            'speaker_ids'   => ['nullable', 'array'],
            'speaker_ids.*' => ['exists:speakers,id'],
        ], [
            'nome.required'        => 'O nome da actividade é obrigatório.',
            'tipo.required'        => 'Seleccione um tipo de actividade.',
            'dia.required'         => 'Seleccione o dia.',
            'hora_inicio.required' => 'A hora de início é obrigatória.',
            'hora_fim.required'    => 'A hora de fim é obrigatória.',
            'hora_fim.after'       => 'A hora de fim deve ser posterior à hora de início.',
        ]);
    }
}
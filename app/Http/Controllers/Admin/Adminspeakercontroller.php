<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminSpeakerController extends Controller
{
    /* ── Listagem ─────────────────────────────────── */
    public function index()
    {
        $speakers = Speaker::ordenado()->paginate(20);
        return view('admin.speakers.index', compact('speakers'));
    }

    /* ── Formulário criar ─────────────────────────── */
    public function create()
    {
        return view('admin.speakers.form', ['speaker' => new Speaker]);
    }

    /* ── Guardar novo ─────────────────────────────── */
    public function store(Request $request)
    {
        $data = $this->validate($request);
        $data['foto'] = $this->handleFoto($request);

        Speaker::create($data);

        return redirect()
            ->route('admin.speakers.index')
            ->with('success', 'Palestrante criado com sucesso.');
    }

    /* ── Formulário editar ────────────────────────── */
    public function edit(Speaker $speaker)
    {
        return view('admin.speakers.form', compact('speaker'));
    }

    /* ── Atualizar ────────────────────────────────── */
    public function update(Request $request, Speaker $speaker)
    {
        $data = $this->validate($request, $speaker->id);

        if ($request->hasFile('foto')) {
            // Apaga foto antiga
            if ($speaker->foto) {
                Storage::disk('public')->delete($speaker->foto);
            }
            $data['foto'] = $this->handleFoto($request);
        }

        // Permite remover foto existente
        if ($request->boolean('remover_foto') && $speaker->foto) {
            Storage::disk('public')->delete($speaker->foto);
            $data['foto'] = null;
        }

        $speaker->update($data);

        return redirect()
            ->route('admin.speakers.index')
            ->with('success', 'Palestrante atualizado com sucesso.');
    }

    /* ── Eliminar ─────────────────────────────────── */
    public function destroy(Speaker $speaker)
    {
        if ($speaker->foto) {
            Storage::disk('public')->delete($speaker->foto);
        }
        $speaker->delete();

        return redirect()
            ->route('admin.speakers.index')
            ->with('success', 'Palestrante eliminado.');
    }

    /* ── Toggle ativo/inativo ─────────────────────── */
    public function toggleAtivo(Speaker $speaker)
    {
        $speaker->update(['ativo' => ! $speaker->ativo]);
        return back()->with('success', 'Estado atualizado.');
    }

    /* ── Toggle destaque ──────────────────────────── */
    public function toggleDestaque(Speaker $speaker)
    {
        $speaker->update(['destaque' => ! $speaker->destaque]);
        return back()->with('success', 'Destaque atualizado.');
    }

    /* ── Helpers privados ─────────────────────────── */

    private function validate(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nome'         => ['required', 'string', 'max:255'],
            'especialidade'=> ['required', 'string', 'max:255'],
            'instituicao'  => ['nullable', 'string', 'max:255'],
            'pais'         => ['nullable', 'string', 'max:100'],
            'biografia'    => ['nullable', 'string'],
            'email'        => [
                'nullable', 'email', 'max:320',
                $ignoreId
                    ? Rule::unique('speakers', 'email')->ignore($ignoreId)
                    : Rule::unique('speakers', 'email'),
            ],
            'linkedin'     => ['nullable', 'url', 'max:500'],
            'twitter'      => ['nullable', 'url', 'max:500'],
            'foto'         => ['nullable', 'image', 'max:2048'], // 2 MB
            'destaque'     => ['boolean'],
            'ordem'        => ['integer', 'min:0'],
            'ativo'        => ['boolean'],
        ], [
            'nome.required'          => 'O nome é obrigatório.',
            'especialidade.required' => 'A especialidade é obrigatória.',
            'email.unique'           => 'Este email já está registado.',
            'foto.image'             => 'O ficheiro deve ser uma imagem.',
            'foto.max'               => 'A foto não pode exceder 2 MB.',
            'linkedin.url'           => 'O URL do LinkedIn não é válido.',
            'twitter.url'            => 'O URL do Twitter não é válido.',
        ]);
    }

    private function handleFoto(Request $request): ?string
    {
        if (! $request->hasFile('foto')) {
            return null;
        }
        return $request->file('foto')->store('speakers', 'public');
    }
}
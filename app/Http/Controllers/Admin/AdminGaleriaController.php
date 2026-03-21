<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminGaleriaController extends Controller
{
    // ── Listagem ──────────────────────────────

   // Substituir o bloco @php na view por dados vindos do controller
    public function index(): View
    {
        $items = Galeria::with('criador')
            ->orderBy('ordem')
            ->orderByDesc('data_publicacao')
            ->paginate(20);

        $stats = [
            'total'      => Galeria::count(),
            'activos'    => Galeria::where('ativo', true)->count(),
            'categorias' => count(Galeria::categorias()),
        ];

        return view('admin.galeria.index', compact('items', 'stats'));
    }

    // ── Formulário criar ──────────────────────

    public function create(): View
    {
        return view('admin.galeria.form', [
            'item'       => new Galeria,
            'categorias' => Galeria::categorias(),
        ]);
    }

    // ── Guardar novo ──────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validar($request);
        $data['foto']      = $this->handleFoto($request);
        $data['criado_por'] = Auth::id();

        Galeria::create($data);

        return redirect()
            ->route('admin.galeria.index')
            ->with('success', 'Item da galeria criado com sucesso.');
    }

    // ── Formulário editar ─────────────────────

    public function edit(Galeria $galeria): View
    {
        return view('admin.galeria.form', [
            'item'       => $galeria,
            'categorias' => Galeria::categorias(),
        ]);
    }

    // ── Actualizar ────────────────────────────

    public function update(Request $request, Galeria $galeria): RedirectResponse
    {
        $data = $this->validar($request, updating: true);

        // Upload tem precedência — ignora "remover" se vier ficheiro novo
        if ($request->hasFile('foto')) {
            if ($galeria->foto) {
                Storage::disk('public')->delete($galeria->foto);
            }
            $data['foto'] = $this->handleFoto($request);
        } elseif ($request->boolean('remover_foto') && $galeria->foto) {
            Storage::disk('public')->delete($galeria->foto);
            $data['foto'] = null;
        }

        $galeria->update($data);

        return redirect()
            ->route('admin.galeria.index')
            ->with('success', 'Item da galeria actualizado com sucesso.');
    }

    // ── Eliminar ──────────────────────────────

    public function destroy(Galeria $galeria): RedirectResponse
    {
        if ($galeria->foto) {
            Storage::disk('public')->delete($galeria->foto);
        }
        $galeria->delete();

        return redirect()
            ->route('admin.galeria.index')
            ->with('success', 'Item eliminado.');
    }

    // ── Toggle ativo ──────────────────────────

    public function toggleAtivo(Galeria $galeria): RedirectResponse
    {
        $galeria->update(['ativo' => ! $galeria->ativo]);
        return back()->with('success', 'Estado actualizado.');
    }

    // ── Helpers ───────────────────────────────

    private function validar(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'titulo'           => ['required', 'string', 'max:255'],
            'descricao'        => ['nullable', 'string'],
            'foto'             => [$updating ? 'nullable' : 'required', 'image', 'max:4096'],
            'foto_alt'         => ['nullable', 'string', 'max:255'],
            'categoria'        => ['required', 'in:' . implode(',', array_keys(Galeria::categorias()))],
            'data_publicacao'  => ['required', 'date'],
            'ordem'            => ['integer', 'min:0'],
            'ativo'            => ['boolean'],
        ], [
            'titulo.required'          => 'O título é obrigatório.',
            'foto.required'            => 'A foto é obrigatória.',
            'foto.image'               => 'O ficheiro deve ser uma imagem.',
            'foto.max'                 => 'A imagem não pode exceder 4 MB.',
            'categoria.required'       => 'Seleccione uma categoria.',
            'data_publicacao.required' => 'A data de publicação é obrigatória.',
        ]);
    }

    private function handleFoto(Request $request): ?string
    {
        if (! $request->hasFile('foto')) {
            return null;
        }
        return $request->file('foto')->store('galeria', 'public');
    }
}
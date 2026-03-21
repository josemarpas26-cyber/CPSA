<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use Illuminate\Http\Request;

class GaleriaPublicController extends Controller
{
    public function index(Request $request)
    {
        $categoria = $request->query('categoria');

        $query = Galeria::ativo()->ordenado();

        if ($categoria && array_key_exists($categoria, Galeria::categorias())) {
            $query->categoria($categoria);
        }

        $items      = $query->paginate(12)->withQueryString();
        $categorias = Galeria::categorias();

        return view('galeria.index', compact('items', 'categorias', 'categoria'));
    }
}
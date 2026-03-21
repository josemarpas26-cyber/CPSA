<?php

namespace App\Http\Controllers;

use App\Models\ProgramaActividade;

class ProgramaPublicController extends Controller
{
    public function index()
    {
        $dias = ProgramaActividade::dias();

        $actividades = [];
        foreach (array_keys($dias) as $dia) {
            $actividades[$dia] = ProgramaActividade::ativo()
                ->with('speakers')
                ->dia($dia)
                ->ordenado()
                ->get();
        }

        return view('programa.index', compact('actividades', 'dias'));
    }
}
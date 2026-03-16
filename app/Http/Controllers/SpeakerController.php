<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * Listagem pública de palestrantes.
     */
    public function index()
    {
        $speakers = Speaker::ativo()
            ->ordenado()
            ->get();

        return view('speakers.index', compact('speakers'));
    }

    /**
     * Página de detalhe de um palestrante.
     */
    public function show(Speaker $speaker)
    {
        abort_unless($speaker->ativo, 404);

        return view('speakers.show', compact('speaker'));
    }
}
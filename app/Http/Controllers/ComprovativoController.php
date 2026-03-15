<?php

namespace App\Http\Controllers;

use App\Models\Comprovativo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ComprovativoController extends Controller
{
    // Somente usuários logados podem baixar
    public function download(Comprovativo $comprovativo)
    {
        $user = auth()->user();

        // Verifica se o usuário pode acessar este comprovativo
        if ($comprovativo->inscricao->user_id !== $user->id && ! $user->hasRole(['admin','organizador'])) {
            abort(403, 'Acesso negado.');
        }

        // Baixa o arquivo do storage local
        return Storage::disk('private')->download($comprovativo->path, $comprovativo->nome_original);
    }
}
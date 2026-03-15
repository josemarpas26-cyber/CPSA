<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarDadosInscricaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'organizador']) ?? false;
    }

    public function rules(): array
    {
        return [
            'nome_completo' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telefone' => ['required', 'string', 'max:20'],
            'instituicao' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'in:medico,enfermeiro,psicologo,estudante,outro'],
            'tipo_participacao' => ['required', 'in:presencial,online'],
        ];
    }
}

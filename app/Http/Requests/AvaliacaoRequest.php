<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvaliacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'organizador']);
    }

    public function rules(): array
    {
        return [
            'motivo_rejeicao' => [
                $this->routeIs('admin.inscricoes.rejeitar') ? 'required' : 'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'motivo_rejeicao.required' => 'O motivo da rejeição é obrigatório.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtualizarDadosInscricaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'organizador']) ?? false;
    }

    public function rules(): array
    {
        $inscricaoId = $this->route('inscricao')?->id;

        return [
            'full_name'       => ['required', 'string', 'max:255'],
            'gender'          => ['required', 'in:masculino,feminino,outro'],
            'date_of_birth'   => ['required', 'date', 'before:today'],
            'nationality'     => ['required', 'string', 'max:100'],
            'document_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('inscricoes', 'document_number')
                    ->ignore($inscricaoId)
                    ->whereNull('deleted_at'),
            ],
            'profession'         => ['required', 'string', 'max:150'],
            'institution'        => ['required', 'string', 'max:255'],
            'category'           => ['required', 'in:profissional,estudante,orador,convidado,imprensa'],
            'phone'              => ['required', 'string', 'max:20'],
            'email'              => [
                'required', 'email', 'max:255',
                Rule::unique('inscricoes', 'email')
                    ->ignore($inscricaoId)
                    ->whereNull('deleted_at'),
            ],
            'province'           => ['required', 'string', 'max:100'],
            'participation_mode' => ['required', 'in:presencial,online'],
            'observations'       => ['nullable', 'string', 'max:2000'],
        ];
    }
}
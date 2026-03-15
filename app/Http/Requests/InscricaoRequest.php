<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscricaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Inscrição é pública
    }

    public function rules(): array
    {
        return [
            'nome_completo'    => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'telefone'         => ['required', 'string', 'max:20'],
            'instituicao'      => ['required', 'string', 'max:255'],
            'cargo'            => ['required', 'string', 'max:255'],
            'categoria'        => ['required', 'in:medico,enfermeiro,psicologo,estudante,outro'],
            'tipo_participacao'=> ['required', 'in:presencial,online'],
            'comprovativo'     => [
                'required',
                'file',
                'max:5120',                          // 5MB
                'mimes:pdf,jpg,jpeg,png',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome_completo.required'     => 'O nome completo é obrigatório.',
            'email.required'             => 'O email é obrigatório.',
            'email.email'                => 'Insira um email válido.',
            'telefone.required'          => 'O telefone é obrigatório.',
            'instituicao.required'       => 'A instituição é obrigatória.',
            'cargo.required'             => 'O cargo é obrigatório.',
            'categoria.required'         => 'Seleccione uma categoria.',
            'categoria.in'               => 'Categoria inválida.',
            'tipo_participacao.required' => 'Seleccione o tipo de participação.',
            'tipo_participacao.in'       => 'Tipo de participação inválido.',
            'comprovativo.required'      => 'O comprovativo de pagamento é obrigatório.',
            'comprovativo.max'           => 'O ficheiro não pode exceder 5MB.',
            'comprovativo.mimes'         => 'Formatos aceites: PDF, JPG, JPEG, PNG.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InscricaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Inscrição é pública
    }

    public function rules(): array
    {
        return [
            'nome_completo'     => ['required', 'string', 'max:255'],
            // FIX: Adicionar unicidade de email para evitar inscrições duplicadas
            'email'             => [
                'required',
                'email',
                'max:255',
                Rule::unique('inscricoes', 'email')->whereNull('deleted_at'),
            ],
            'telefone'          => ['required', 'string', 'max:20'],
            'instituicao'       => ['required', 'string', 'max:255'],
            'cargo'             => ['required', 'string', 'max:255'],
            'categoria'         => ['required', 'in:medico,enfermeiro,psicologo,estudante,outro'],
            'tipo_participacao' => ['required', 'in:presencial,online'],
            'comprovativo'      => [
                'required',
                'file',
                'max:5120',                         // 5MB
                'mimes:pdf,jpg,jpeg,png',
                // FIX: Validação extra — rejeitar ficheiros com múltiplas extensões
                function ($attribute, $value, $fail) {
                    $originalName = $value->getClientOriginalName();
                    $parts        = explode('.', $originalName);

                    if (count($parts) > 2) {
                        $fail('Nome de ficheiro inválido. Não são permitidos ficheiros com múltiplas extensões.');
                        return;
                    }

                    $allowedMimes = ['application/pdf', 'image/jpeg', 'image/png'];
                    if (! in_array($value->getMimeType(), $allowedMimes)) {
                        $fail('O tipo de ficheiro não é permitido. Utilize PDF, JPG ou PNG.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome_completo.required'     => 'O nome completo é obrigatório.',
            'email.required'             => 'O email é obrigatório.',
            'email.email'                => 'Insira um email válido.',
            'email.unique'               => 'Já existe uma inscrição registada com este endereço de email.',
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
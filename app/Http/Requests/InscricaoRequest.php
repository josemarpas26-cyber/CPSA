<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InscricaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ── Dados pessoais ────────────────────────────
            'full_name'       => ['required', 'string', 'max:255'],
            'gender'          => ['required', 'in:masculino,feminino,outro'],
            'date_of_birth'   => ['required', 'date', 'before:today'],
            'nationality'     => ['required', 'string', 'max:100'],
            'document_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('inscricoes', 'document_number')->whereNull('deleted_at'),
            ],
            'profession'      => ['required', 'string', 'max:150'],
            'institution'     => ['required', 'string', 'max:255'],
            'category'        => ['required', 'in:profissional,estudante,orador,convidado,imprensa'],
            'phone'           => ['required', 'string', 'max:20'],
            'email'           => [
                'required',
                'email',
                'max:255',
                Rule::unique('inscricoes', 'email')->whereNull('deleted_at'),
            ],
            'province'           => ['required', 'string', 'max:100'],
            'participation_mode' => ['required', 'in:presencial,online'],
            'observations'       => ['nullable', 'string', 'max:2000'],

            // ── Curso ─────────────────────────────────────
            'curso_id' => [
                'required',
                Rule::exists('cursos', 'id')->where('ativo', true),
            ],

            // ── Comprovativo ──────────────────────────────
            'comprovativo' => [
                'required',
                'file',
                'max:5120',
                'mimes:pdf,jpg,jpeg,png',
                function ($attribute, $value, $fail) {
                    $parts = explode('.', $value->getClientOriginalName());
                    if (count($parts) > 2) {
                        $fail('Nome de ficheiro inválido. Não são permitidos ficheiros com múltiplas extensões.');
                        return;
                    }
                    $allowed = ['application/pdf', 'image/jpeg', 'image/png'];
                    if (! in_array($value->getMimeType(), $allowed)) {
                        $fail('O tipo de ficheiro não é permitido. Utilize PDF, JPG ou PNG.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'       => 'O nome completo é obrigatório.',
            'gender.required'          => 'O género é obrigatório.',
            'date_of_birth.required'   => 'A data de nascimento é obrigatória.',
            'date_of_birth.before'     => 'A data de nascimento deve ser no passado.',
            'nationality.required'     => 'A nacionalidade é obrigatória.',
            'document_number.required' => 'O número do documento de identificação é obrigatório.',
            'document_number.unique'   => 'Já existe uma inscrição com este número de documento.',
            'profession.required'      => 'A profissão é obrigatória.',
            'institution.required'     => 'A instituição é obrigatória.',
            'category.required'        => 'Seleccione uma categoria.',
            'category.in'              => 'Categoria inválida.',
            'phone.required'           => 'O contacto telefónico é obrigatório.',
            'email.required'           => 'O e-mail é obrigatório.',
            'email.email'              => 'Introduza um e-mail válido.',
            'email.unique'             => 'Já existe uma inscrição com este e-mail.',
            'province.required'        => 'A província/país é obrigatória.',
            'participation_mode.required' => 'Seleccione o modo de participação.',
            'participation_mode.in'    => 'Modo de participação inválido.',
            'curso_id.required'        => 'Seleccione um curso.',
            'curso_id.exists'          => 'O curso seleccionado não está disponível.',
            'comprovativo.required'    => 'O comprovativo de pagamento é obrigatório.',
            'comprovativo.max'         => 'O ficheiro não pode exceder 5 MB.',
            'comprovativo.mimes'       => 'Formatos aceites: PDF, JPG, JPEG, PNG.',
        ];
    }
}
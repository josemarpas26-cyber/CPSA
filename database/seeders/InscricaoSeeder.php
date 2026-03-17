<?php

namespace Database\Seeders;

use App\Models\Comprovativo;
use App\Models\Curso;
use App\Models\Inscricao;
use App\Models\InscricaoCurso;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InscricaoSeeder extends Seeder
{
    public function run(): void
    {
        $roleParticipante = Role::where('name', 'participante')->firstOrFail();

        // Buscar cursos criados pelo CursoSeeder
        $cursos = Curso::orderBy('ordem')->get();

        if ($cursos->isEmpty()) {
            $this->command->warn('⚠️  Nenhum curso encontrado. Corra o CursoSeeder primeiro.');
            return;
        }

        $dados = [
            [
                'nome'             => 'Ana Paula Ferreira',
                'email'            => 'ana.ferreira@hospital.ao',
                'gender'           => 'feminino',
                'date_of_birth'    => '1982-04-15',
                'nationality'      => 'Angolana',
                'document_number'  => '0045678901LA041',
                'profession'       => 'Médica Psiquiatra',
                'institution'      => 'Hospital Geral de Luanda',
                'category'         => 'profissional',
                'phone'            => '+244 923 456 789',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => null,
                'status'           => 'aprovada',
                'curso_ordem'      => 1,
            ],
            [
                'nome'             => 'Carlos Manuel Neto',
                'email'            => 'carlos.neto@clinica.ao',
                'gender'           => 'masculino',
                'date_of_birth'    => '1990-08-22',
                'nationality'      => 'Angolana',
                'document_number'  => '0056789012LA041',
                'profession'       => 'Enfermeiro Especialista',
                'institution'      => 'Clínica Sagrada Esperança',
                'category'         => 'profissional',
                'phone'            => '+244 912 345 678',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => null,
                'status'           => 'aprovada',
                'curso_ordem'      => 8,
            ],
            [
                'nome'             => 'Maria da Conceição Silva',
                'email'            => 'msilva@univ.ao',
                'gender'           => 'feminino',
                'date_of_birth'    => '1975-11-03',
                'nationality'      => 'Angolana',
                'document_number'  => '0067890123LA041',
                'profession'       => 'Professora e Investigadora',
                'institution'      => 'Universidade Agostinho Neto',
                'category'         => 'profissional',
                'phone'            => '+244 934 567 890',
                'province'         => 'Luanda',
                'participation_mode' => 'online',
                'observations'     => null,
                'status'           => 'aprovada',
                'curso_ordem'      => 2,
            ],
            [
                'nome'             => 'João António Lopes',
                'email'            => 'joao.lopes@estudante.ao',
                'gender'           => 'masculino',
                'date_of_birth'    => '2001-03-17',
                'nationality'      => 'Angolana',
                'document_number'  => '0078901234LA041',
                'profession'       => 'Estudante de Medicina',
                'institution'      => 'Faculdade de Medicina — UAN',
                'category'         => 'estudante',
                'phone'            => '+244 945 678 901',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => 'Tenho interesse especial em psiquiatria infanto-juvenil.',
                'status'           => 'pendente',
                'curso_ordem'      => 3,
            ],
            [
                'nome'             => 'Esperança Domingos',
                'email'            => 'esperanca.d@saude.gov.ao',
                'gender'           => 'feminino',
                'date_of_birth'    => '1988-06-29',
                'nationality'      => 'Angolana',
                'document_number'  => '0089012345LA041',
                'profession'       => 'Técnica de Saúde Mental',
                'institution'      => 'Ministério da Saúde de Angola',
                'category'         => 'profissional',
                'phone'            => '+244 956 789 012',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => null,
                'status'           => 'em_analise',
                'curso_ordem'      => 5,
            ],
            [
                'nome'             => 'Paulo Sebastião Mbala',
                'email'            => 'paulo.mbala@hpd.ao',
                'gender'           => 'masculino',
                'date_of_birth'    => '1970-09-11',
                'nationality'      => 'Angolana',
                'document_number'  => '0090123456LA041',
                'profession'       => 'Director Clínico',
                'institution'      => 'Hospital Psiquiátrico de Luanda',
                'category'         => 'profissional',
                'phone'            => '+244 967 890 123',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => null,
                'status'           => 'rejeitada',
                'curso_ordem'      => 6,
            ],
            [
                'nome'             => 'Luísa Beatriz Tavares',
                'email'            => 'luisa.tavares@univ.ao',
                'gender'           => 'feminino',
                'date_of_birth'    => '1993-02-14',
                'nationality'      => 'Angolana',
                'document_number'  => '0001234567LA041',
                'profession'       => 'Psicóloga Clínica',
                'institution'      => 'Universidade Católica de Angola',
                'category'         => 'profissional',
                'phone'            => '+244 978 901 234',
                'province'         => 'Benguela',
                'participation_mode' => 'online',
                'observations'     => null,
                'status'           => 'pendente',
                'curso_ordem'      => 4,
            ],
            [
                'nome'             => 'Domingos Cardoso',
                'email'            => 'domingos.c@hospital.ao',
                'gender'           => 'masculino',
                'date_of_birth'    => '1965-12-05',
                'nationality'      => 'Angolana',
                'document_number'  => '0012345678LA041',
                'profession'       => 'Médico Especialista',
                'institution'      => 'Hospital Militar Principal',
                'category'         => 'profissional',
                'phone'            => '+244 989 012 345',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => null,
                'status'           => 'aprovada',
                'curso_ordem'      => 7,
            ],
            [
                'nome'             => 'Rosa Fernanda Quintas',
                'email'            => 'rfquintas@estudante.ao',
                'gender'           => 'feminino',
                'date_of_birth'    => '2000-07-19',
                'nationality'      => 'Angolana',
                'document_number'  => '0023456789LA041',
                'profession'       => 'Estudante de Psicologia',
                'institution'      => 'UCAN — Universidade Católica de Angola',
                'category'         => 'estudante',
                'phone'            => '+244 911 222 333',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => null,
                'status'           => 'aprovada',
                'curso_ordem'      => 4,
            ],
            [
                'nome'             => 'Miguel Afonso Teixeira',
                'email'            => 'mateixeira@imprensa.ao',
                'gender'           => 'masculino',
                'date_of_birth'    => '1985-05-30',
                'nationality'      => 'Angolana',
                'document_number'  => '0034567890LA041',
                'profession'       => 'Jornalista de Saúde',
                'institution'      => 'Jornal de Angola',
                'category'         => 'imprensa',
                'phone'            => '+244 922 444 555',
                'province'         => 'Luanda',
                'participation_mode' => 'presencial',
                'observations'     => 'Credencial de imprensa a apresentar na recepção.',
                'status'           => 'pendente',
                'curso_ordem'      => 1,
            ],
        ];

        $adminId = User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))
                       ->value('id');

        foreach ($dados as $dado) {
            // Criar user participante
            $user = User::firstOrCreate(
                ['email' => $dado['email']],
                [
                    'name'     => $dado['nome'],
                    'password' => Hash::make('Password@123'),
                    'telefone' => $dado['phone'],
                ]
            );
            $user->roles()->syncWithoutDetaching($roleParticipante->id);

            // Escolher curso pela ordem
            $curso = $cursos->firstWhere('ordem', $dado['curso_ordem'])
                   ?? $cursos->first();

            // Criar inscrição
            $inscricao = Inscricao::create([
                'numero'             => Inscricao::gerarNumero(),
                'full_name'          => $dado['nome'],
                'gender'             => $dado['gender'],
                'date_of_birth'      => $dado['date_of_birth'],
                'nationality'        => $dado['nationality'],
                'document_number'    => $dado['document_number'],
                'profession'         => $dado['profession'],
                'institution'        => $dado['institution'],
                'category'           => $dado['category'],
                'phone'              => $dado['phone'],
                'email'              => $dado['email'],
                'province'           => $dado['province'],
                'participation_mode' => $dado['participation_mode'],
                'observations'       => $dado['observations'],
                'status'             => $dado['status'],
                'user_id'            => $user->id,
                'avaliado_por'       => in_array($dado['status'], ['aprovada', 'rejeitada', 'em_analise'])
                                        ? $adminId : null,
                'avaliado_em'        => in_array($dado['status'], ['aprovada', 'rejeitada'])
                                        ? now()->subHours(rand(1, 48)) : null,
                'motivo_rejeicao'    => $dado['status'] === 'rejeitada'
                                        ? 'Comprovativo de pagamento ilegível. Por favor, submeta um novo comprovativo com maior qualidade.'
                                        : null,
            ]);

            // Ligar ao curso
            InscricaoCurso::firstOrCreate([
                'inscricao_id' => $inscricao->id,
            ], [
                'curso_id' => $curso->id,
            ]);

            // Comprovativo fictício
            $path = "comprovativos/2026/comprovativo-{$inscricao->numero}.pdf";
            Storage::put($path, '%PDF-1.4 placeholder');

            Comprovativo::create([
                'inscricao_id'  => $inscricao->id,
                'nome_original' => 'comprovativo-pagamento.pdf',
                'path'          => $path,
                'mime_type'     => 'application/pdf',
                'tamanho'       => rand(150000, 2000000),
                'hash'          => hash('sha256', $inscricao->numero),
                'status'        => match($dado['status']) {
                    'aprovada'  => 'aceite',
                    'rejeitada' => 'rejeitado',
                    default     => 'pendente',
                },
            ]);
        }

        $this->command->info('✅ ' . count($dados) . ' inscrições de teste criadas.');
    }
}
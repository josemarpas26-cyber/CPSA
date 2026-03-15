<?php

namespace Database\Seeders;

use App\Models\Comprovativo;
use App\Models\Inscricao;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InscricaoSeeder extends Seeder
{
    public function run(): void
    {
        $roleParticipante = Role::where('name', 'participante')->first();

        $dados = [
            [
                'nome'       => 'Ana Paula Ferreira',
                'email'      => 'ana.ferreira@hospital.ao',
                'telefone'   => '+244 923 456 789',
                'instituicao'=> 'Hospital Geral de Luanda',
                'cargo'      => 'Médica Psiquiatra',
                'categoria'  => 'medico',
                'tipo'       => 'presencial',
                'status'     => 'aprovada',
            ],
            [
                'nome'       => 'Carlos Manuel Neto',
                'email'      => 'carlos.neto@clinica.ao',
                'telefone'   => '+244 912 345 678',
                'instituicao'=> 'Clínica Sagrada Esperança',
                'cargo'      => 'Enfermeiro Especialista',
                'categoria'  => 'enfermeiro',
                'tipo'       => 'presencial',
                'status'     => 'aprovada',
            ],
            [
                'nome'       => 'Maria da Conceição Silva',
                'email'      => 'msilva@univ.ao',
                'telefone'   => '+244 934 567 890',
                'instituicao'=> 'Universidade Agostinho Neto',
                'cargo'      => 'Professora e Investigadora',
                'categoria'  => 'psicologo',
                'tipo'       => 'online',
                'status'     => 'aprovada',
            ],
            [
                'nome'       => 'João António Lopes',
                'email'      => 'joao.lopes@estudante.ao',
                'telefone'   => '+244 945 678 901',
                'instituicao'=> 'Faculdade de Medicina — UAN',
                'cargo'      => 'Estudante de Medicina',
                'categoria'  => 'estudante',
                'tipo'       => 'presencial',
                'status'     => 'pendente',
            ],
            [
                'nome'       => 'Esperança Domingos',
                'email'      => 'esperanca.d@saude.gov.ao',
                'telefone'   => '+244 956 789 012',
                'instituicao'=> 'Ministério da Saúde de Angola',
                'cargo'      => 'Técnica de Saúde Mental',
                'categoria'  => 'outro',
                'tipo'       => 'presencial',
                'status'     => 'em_analise',
            ],
            [
                'nome'       => 'Paulo Sebastião Mbala',
                'email'      => 'paulo.mbala@hpd.ao',
                'telefone'   => '+244 967 890 123',
                'instituicao'=> 'Hospital Psiquiátrico de Luanda',
                'cargo'      => 'Director Clínico',
                'categoria'  => 'medico',
                'tipo'       => 'presencial',
                'status'     => 'rejeitada',
            ],
            [
                'nome'       => 'Luísa Beatriz Tavares',
                'email'      => 'luisa.tavares@univ.ao',
                'telefone'   => '+244 978 901 234',
                'instituicao'=> 'Universidade Católica de Angola',
                'cargo'      => 'Psicóloga Clínica',
                'categoria'  => 'psicologo',
                'tipo'       => 'online',
                'status'     => 'pendente',
            ],
            [
                'nome'       => 'Domingos Cardoso',
                'email'      => 'domingos.c@hospital.ao',
                'telefone'   => '+244 989 012 345',
                'instituicao'=> 'Hospital Militar Principal',
                'cargo'      => 'Médico Especialista',
                'categoria'  => 'medico',
                'tipo'       => 'presencial',
                'status'     => 'aprovada',
            ],
        ];

        foreach ($dados as $i => $dado) {

            // Criar user participante
            $user = User::firstOrCreate(
                ['email' => $dado['email']],
                [
                    'name'     => $dado['nome'],
                    'password' => Hash::make('Password@123'),
                    'telefone' => $dado['telefone'],
                ]
            );
            $user->roles()->syncWithoutDetaching($roleParticipante->id);

            // Criar inscrição
            $inscricao = Inscricao::create([
                'numero'            => Inscricao::gerarNumero(),
                'nome_completo'     => $dado['nome'],
                'email'             => $dado['email'],
                'telefone'          => $dado['telefone'],
                'instituicao'       => $dado['instituicao'],
                'cargo'             => $dado['cargo'],
                'categoria'         => $dado['categoria'],
                'tipo_participacao' => $dado['tipo'],
                'status'            => $dado['status'],
                'user_id'           => $user->id,
                'avaliado_por'      => in_array($dado['status'], ['aprovada','rejeitada','em_analise'])
                                       ? 1 : null,
                'avaliado_em'       => in_array($dado['status'], ['aprovada','rejeitada'])
                                       ? now()->subHours(rand(1, 48)) : null,
                'motivo_rejeicao'   => $dado['status'] === 'rejeitada'
                                       ? 'Comprovativo de pagamento ilegível. Por favor, submeta um novo comprovativo com maior qualidade.'
                                       : null,
            ]);

            // Criar comprovativo fictício
            $path = "comprovativos/2025/comprovativo-{$inscricao->numero}.pdf";

            // Criar ficheiro placeholder no storage privado
            Storage::disk('private')->put($path, '%PDF-1.4 placeholder');

            Comprovativo::create([
                'inscricao_id'  => $inscricao->id,
                'nome_original' => "comprovativo-pagamento.pdf",
                'path'          => $path,
                'mime_type'     => 'application/pdf',
                'tamanho'       => rand(150000, 2000000),
                'hash'          => hash('sha256', $inscricao->numero),
                'status'        => match($dado['status']) {
                    'aprovada'   => 'aceite',
                    'rejeitada'  => 'rejeitado',
                    default      => 'pendente',
                },
            ]);
        }

        $this->command->info('✅ ' . count($dados) . ' inscrições de teste criadas.');
    }
}
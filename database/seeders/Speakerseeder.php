<?php

namespace Database\Seeders;

use App\Models\Speaker;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        
        $speakers = [
            [
                'nome'          => 'Prof. Dr. António Sebastião Mbala',
                'especialidade' => 'Psiquiatria Clínica e Neuropsiquiatria',
                'instituicao'   => 'Hospital Psiquiátrico de Luanda',
                'pais'          => 'Angola',
                'biografia'     => 'Professor catedrático e director clínico do Hospital Psiquiátrico de Luanda. Especialista em neuropsiquiatria com mais de 25 anos de experiência clínica e académica em Angola.',
                'email'         => 'a.mbala@hpl.ao',
                'linkedin'      => null,
                'destaque'      => true,
                'ordem'         => 1,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Dra. Maria da Conceição Lopes',
                'especialidade' => 'Saúde Mental Comunitária',
                'instituicao'   => 'Universidade Agostinho Neto — Faculdade de Medicina',
                'pais'          => 'Angola',
                'biografia'     => 'Investigadora e docente universitária com foco em saúde mental comunitária e integração de cuidados primários. Coordenadora do Programa Nacional de Saúde Mental.',
                'email'         => 'm.lopes@fan.ao',
                'linkedin'      => null,
                'destaque'      => true,
                'ordem'         => 2,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Prof. Dr. João Paulo Ferreira',
                'especialidade' => 'Psiquiatria da Infância e Adolescência',
                'instituicao'   => 'Hospital Pediátrico David Bernardino',
                'pais'          => 'Angola',
                'biografia'     => 'Pioneiro da psiquiatria infanto-juvenil em Angola. Desenvolve programas de rastreio e intervenção precoce em saúde mental para crianças e adolescentes.',
                'email'         => null,
                'linkedin'      => null,
                'destaque'      => true,
                'ordem'         => 3,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Dra. Ana Paula Rodrigues',
                'especialidade' => 'Psicologia Clínica e Psicoterapia',
                'instituicao'   => 'Clínica Sagrada Esperança',
                'pais'          => 'Angola',
                'biografia'     => 'Psicóloga clínica especializada em terapia cognitivo-comportamental e intervenção em crises. Formadora certificada em EMDR para trauma.',
                'email'         => 'a.rodrigues@cse.ao',
                'linkedin'      => null,
                'destaque'      => false,
                'ordem'         => 4,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Prof. Dr. Carlos Manuel Teixeira',
                'especialidade' => 'Adições e Dependências',
                'instituicao'   => 'Universidade Católica de Angola',
                'pais'          => 'Angola',
                'biografia'     => 'Especialista em psiquiatria das adições. Coordena o único programa universitário de formação em prevenção e tratamento de dependências em Angola.',
                'email'         => null,
                'linkedin'      => null,
                'destaque'      => false,
                'ordem'         => 5,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Dra. Fátima Nunes Costa',
                'especialidade' => 'Psiquiatria Forense',
                'instituicao'   => 'Ministério da Justiça e dos Direitos Humanos',
                'pais'          => 'Angola',
                'biografia'     => 'Referência nacional em psiquiatria forense. Perita do tribunal em casos de inimputabilidade e avaliações de capacidade mental.',
                'email'         => null,
                'linkedin'      => null,
                'destaque'      => false,
                'ordem'         => 6,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Prof. Dr. Mário Augusto Santos',
                'especialidade' => 'Psiquiatria Geriátrica',
                'instituicao'   => 'Hospital Militar Principal de Luanda',
                'pais'          => 'Angola',
                'biografia'     => 'Especialista em saúde mental do idoso, com foco em demências e perturbações neurocognitivas. Coordena a única unidade de psicogeriatria do país.',
                'email'         => null,
                'linkedin'      => null,
                'destaque'      => false,
                'ordem'         => 7,
                'ativo'         => true,
            ],
            [
                'nome'          => 'Dra. Esperança Domingos Cardoso',
                'especialidade' => 'Enfermagem em Saúde Mental',
                'instituicao'   => 'Escola Superior de Enfermagem de Luanda',
                'pais'          => 'Angola',
                'biografia'     => 'Enfermeira especialista e docente. Coordena o curso de especialização em enfermagem de saúde mental e psiquiatria, formando enfermeiros em todo o país.',
                'email'         => null,
                'linkedin'      => null,
                'destaque'      => false,
                'ordem'         => 8,
                'ativo'         => true,
            ],
        ];

        foreach ($speakers as $data) {
            Speaker::firstOrCreate(
                ['nome' => $data['nome']],
                $data
            );
        }

        $this->command->info('✅ ' . count($speakers) . ' palestrantes criados.');
    }
}
<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Speaker;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Dias do congresso (exemplo: 14 e 15 de Agosto de 2026)
        $dia1 = '2026-08-14';
        $dia2 = '2026-08-15';

        $cursos = [
            // ── DIA 1 ──────────────────────────────────────────────
            [
                'nome'        => 'Fundamentos de Psicopatologia Clínica',
                'descricao'   => 'Revisão sistemática dos principais quadros psicopatológicos: psicoses, perturbações do humor, ansiedade e personalidade. Abordagem diagnóstica baseada em critérios ICD-11.',
                'sala'        => 'Auditório Principal',
                'dia'         => $dia1,
                'hora_inicio' => '09:00',
                'hora_fim'    => '11:00',
                'vagas'       => null,
                'ordem'       => 1,
                'ativo'       => true,
                'speakers'    => ['Prof. Dr. António Sebastião Mbala'],
            ],
            [
                'nome'        => 'Saúde Mental Comunitária em Contexto Africano',
                'descricao'   => 'Modelos de cuidados comunitários adaptados à realidade angolana e africana. Integração de cuidados primários, redução do estigma e envolvimento familiar.',
                'sala'        => 'Sala B',
                'dia'         => $dia1,
                'hora_inicio' => '09:00',
                'hora_fim'    => '11:00',
                'vagas'       => 60,
                'ordem'       => 2,
                'ativo'       => true,
                'speakers'    => ['Dra. Maria da Conceição Lopes'],
            ],
            [
                'nome'        => 'Psiquiatria da Infância e Adolescência: Diagnóstico Precoce',
                'descricao'   => 'Abordagem prática às perturbações do neurodesenvolvimento (PHDA, autismo), perturbações de ansiedade e humor na criança e adolescente. Ferramentas de rastreio validadas.',
                'sala'        => 'Sala C',
                'dia'         => $dia1,
                'hora_inicio' => '11:30',
                'hora_fim'    => '13:00',
                'vagas'       => 45,
                'ordem'       => 3,
                'ativo'       => true,
                'speakers'    => ['Prof. Dr. João Paulo Ferreira'],
            ],
            [
                'nome'        => 'Terapia Cognitivo-Comportamental — Nível Introdutório',
                'descricao'   => 'Workshop prático de introdução à TCC. Conceptualização de casos, técnicas de reestruturação cognitiva e técnicas comportamentais. Inclui role-play supervisionado.',
                'sala'        => 'Sala A',
                'dia'         => $dia1,
                'hora_inicio' => '14:00',
                'hora_fim'    => '17:00',
                'vagas'       => 30,
                'ordem'       => 4,
                'ativo'       => true,
                'speakers'    => ['Dra. Ana Paula Rodrigues'],
            ],
            [
                'nome'        => 'Adições: Abordagem Clínica e Reabilitação',
                'descricao'   => 'Diagnóstico e tratamento das perturbações por uso de substâncias. Modelos de entrevista motivacional, intervenções farmacológicas e programas de reabilitação.',
                'sala'        => 'Sala B',
                'dia'         => $dia1,
                'hora_inicio' => '14:00',
                'hora_fim'    => '16:30',
                'vagas'       => 50,
                'ordem'       => 5,
                'ativo'       => true,
                'speakers'    => ['Prof. Dr. Carlos Manuel Teixeira'],
            ],

            // ── DIA 2 ──────────────────────────────────────────────
            [
                'nome'        => 'Psiquiatria Forense: Avaliação e Prática Pericial',
                'descricao'   => 'Metodologia de avaliação forense, elaboração de relatórios periciais e testemunho em tribunal. Casos práticos de imputabilidade e capacidade de julgamento.',
                'sala'        => 'Auditório Principal',
                'dia'         => $dia2,
                'hora_inicio' => '09:00',
                'hora_fim'    => '11:00',
                'vagas'       => null,
                'ordem'       => 6,
                'ativo'       => true,
                'speakers'    => ['Dra. Fátima Nunes Costa'],
            ],
            [
                'nome'        => 'Psicogeriatria: Demências e Perturbações Neurocognitivas',
                'descricao'   => 'Diagnóstico diferencial das síndromes demenciais, escalas de avaliação cognitiva, abordagem farmacológica e não farmacológica. Apoio ao cuidador.',
                'sala'        => 'Sala A',
                'dia'         => $dia2,
                'hora_inicio' => '09:00',
                'hora_fim'    => '11:00',
                'vagas'       => 40,
                'ordem'       => 7,
                'ativo'       => true,
                'speakers'    => ['Prof. Dr. Mário Augusto Santos'],
            ],
            [
                'nome'        => 'Cuidados de Enfermagem em Saúde Mental',
                'descricao'   => 'Papel do enfermeiro especialista na avaliação e gestão de crises, comunicação terapêutica, contenção de agitação e planos de cuidados individualizados.',
                'sala'        => 'Sala C',
                'dia'         => $dia2,
                'hora_inicio' => '11:30',
                'hora_fim'    => '13:30',
                'vagas'       => 60,
                'ordem'       => 8,
                'ativo'       => true,
                'speakers'    => ['Dra. Esperança Domingos Cardoso'],
            ],
            [
                'nome'        => 'Abordagem Multidisciplinar em Psiquiatria de Ligação',
                'descricao'   => 'Interface entre psiquiatria e medicina interna, oncologia e cirurgia. Gestão de perturbações psiquiátricas em contexto hospitalar geral e cuidados paliativos.',
                'sala'        => 'Sala B',
                'dia'         => $dia2,
                'hora_inicio' => '14:00',
                'hora_fim'    => '16:30',
                'vagas'       => 45,
                'ordem'       => 9,
                'ativo'       => true,
                'speakers'    => [
                    'Prof. Dr. António Sebastião Mbala',
                    'Dra. Maria da Conceição Lopes',
                ],
            ],
            [
                'nome'        => 'Psicofarmacologia Prática — Antipsicóticos e Estabilizadores',
                'descricao'   => 'Revisão dos antipsicóticos de 1ª e 2ª geração, estabilizadores do humor e antidepressivos. Casos clínicos de titulação, efeitos adversos e interacções medicamentosas.',
                'sala'        => 'Auditório Principal',
                'dia'         => $dia2,
                'hora_inicio' => '14:00',
                'hora_fim'    => '16:00',
                'vagas'       => null,
                'ordem'       => 10,
                'ativo'       => true,
                'speakers'    => [
                    'Prof. Dr. João Paulo Ferreira',
                    'Prof. Dr. Carlos Manuel Teixeira',
                ],
            ],
        ];

        foreach ($cursos as $data) {
            $speakerNames = $data['speakers'];
            unset($data['speakers']);

            $curso = Curso::firstOrCreate(
                ['nome' => $data['nome'], 'dia' => $data['dia']],
                $data
            );

            // Associar palestrantes pelo nome
            $speakerIds = Speaker::whereIn('nome', $speakerNames)->pluck('id');
            $curso->speakers()->syncWithoutDetaching($speakerIds);
        }

        $this->command->info('✅ ' . count($cursos) . ' cursos criados.');
    }
}
<?php

namespace App\Exports;

use App\Models\Inscricao;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InscricoesExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function __construct(
        private ?string $status = null
    ) {}

    public function title(): string
    {
        return 'Inscrições CPSM 2026';
    }

    public function query()
    {
        $query = Inscricao::with(['comprovativo', 'avaliador'])->latest();

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Nº Inscrição',
            'Nome Completo',
            'Email',
            'Telefone',
            'Instituição',
            'Profissão',
            'Categoria',
            'Modalidade',
            'Estado',
            'Comprovativo',
            'Avaliado Por',
            'Avaliado Em',
            'Motivo Rejeição',
            'Data Inscrição',
        ];
    }

    public function map($inscricao): array
    {
        return [
            $inscricao->numero,
            $inscricao->full_name,
            $inscricao->email,
            $inscricao->phone,                                          // era: telefone
            $inscricao->institution,                                    // era: instituicao
            $inscricao->profession,                                     // era: cargo
            $inscricao->category_label,
            ucfirst($inscricao->participation_mode),                    // era: tipo_participacao
            $inscricao->status_label,
            $inscricao->comprovativo ? 'Sim' : 'Não',
            $inscricao->avaliador?->name ?? '—',
            $inscricao->avaliado_em?->format('d/m/Y H:i') ?? '—',
            $inscricao->motivo_rejeicao ?? '—',
            $inscricao->created_at->format('d/m/Y H:i'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, 'B' => 30, 'C' => 30,
            'D' => 16, 'E' => 28, 'F' => 20,
            'G' => 16, 'H' => 14, 'I' => 14,
            'J' => 14, 'K' => 24, 'L' => 18,
            'M' => 36, 'N' => 18,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1e40af'],
                ],
            ],
        ];
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InscricoesExport;
use App\Models\Inscricao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ExportacaoController extends \App\Http\Controllers\Controller
{
    /** Exportar Excel completo */
    public function excel(Request $request): BinaryFileResponse
    {
        $status   = $request->query('status');
        $filename = 'inscricoes-cpsa2025' . ($status ? "-{$status}" : '') . '.xlsx';

        return Excel::download(new InscricoesExport($status), $filename);
    }

    /** Exportar CSV */
    public function csv(Request $request): BinaryFileResponse
    {
        $status   = $request->query('status');
        $filename = 'inscricoes-cpsa2025' . ($status ? "-{$status}" : '') . '.csv';

        return Excel::download(new InscricoesExport($status), $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    /** Lista de presença em PDF */
    public function presenca(Request $request): Response
    {
        $inscricoes = Inscricao::where('status', 'aprovada')
            ->orderBy('nome_completo')
            ->get();

        $pdf = Pdf::loadView('pdf.lista-presenca', compact('inscricoes'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
            ]);

        return $pdf->download('lista-presenca-cpsa2025.pdf');
    }
}
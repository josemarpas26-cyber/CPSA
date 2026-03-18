<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscricao;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Contadores por status (1 query agregada)
        $contadoresRaw = Inscricao::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $stats = [
            'total'      => array_sum($contadoresRaw),
            'pendentes'  => $contadoresRaw['pendente']   ?? 0,
            'em_analise' => $contadoresRaw['em_analise'] ?? 0,
            'aprovadas'  => $contadoresRaw['aprovada']   ?? 0,
            'rejeitadas' => $contadoresRaw['rejeitada']  ?? 0,
        ];

        // Distribuição por category (campo novo: category)
        $porcategory = Inscricao::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        // Distribuição por modalidade (campo novo: participation_mode)
        $porTipo = Inscricao::selectRaw('participation_mode, count(*) as total')
            ->groupBy('participation_mode')
            ->pluck('total', 'participation_mode');

        // Últimas 8 inscrições
        $ultimas = Inscricao::with('comprovativo')
            ->latest()
            ->limit(8)
            ->get();

        // Inscrições por dia (últimos 14 dias)
        $porDia = Inscricao::selectRaw('DATE(created_at) as dia, count(*) as total')
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('dia')
            ->orderBy('dia')
            ->pluck('total', 'dia');

        return view('admin.dashboard', compact(
            'stats', 'porcategory', 'porTipo', 'ultimas', 'porDia'
        ));
    }
}
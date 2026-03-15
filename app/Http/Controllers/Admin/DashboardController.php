<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscricao;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // FIX: Usar uma única query agregada em vez de 5 queries separadas
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

        // Distribuição por categoria
        $porCategoria = Inscricao::selectRaw('categoria, count(*) as total')
            ->groupBy('categoria')
            ->pluck('total', 'categoria');

        // Distribuição por tipo
        $porTipo = Inscricao::selectRaw('tipo_participacao, count(*) as total')
            ->groupBy('tipo_participacao')
            ->pluck('total', 'tipo_participacao');

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
            'stats', 'porCategoria', 'porTipo', 'ultimas', 'porDia'
        ));
    }
}
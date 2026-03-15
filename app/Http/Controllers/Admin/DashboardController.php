<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscricao;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total'       => Inscricao::count(),
            'pendentes'   => Inscricao::where('status', 'pendente')->count(),
            'em_analise'  => Inscricao::where('status', 'em_analise')->count(),
            'aprovadas'   => Inscricao::where('status', 'aprovada')->count(),
            'rejeitadas'  => Inscricao::where('status', 'rejeitada')->count(),
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
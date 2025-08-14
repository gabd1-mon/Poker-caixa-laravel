<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();

        // Calcula os totais para o dia de hoje
        $totalEntradas = Transacao::where('tipo', 'entrada')
            ->whereDate('created_at', $hoje)
            ->sum('valor');

        $totalSaidas = Transacao::where('tipo', 'saida')
            ->whereDate('created_at', $hoje)
            ->sum('valor');

        $balancoFinal = $totalEntradas - $totalSaidas;

        // Busca as 5 transações mais recentes, já com os dados do jogador associado
        $transacoesRecentes = Transacao::with('jogador')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'entradas' => number_format($totalEntradas, 2, ',', '.'),
                'saidas' => number_format($totalSaidas, 2, ',', '.'),
                'balanco' => number_format($balancoFinal, 2, ',', '.'),
            ],
            'transacoesRecentes' => $transacoesRecentes,
        ]);
    }
}

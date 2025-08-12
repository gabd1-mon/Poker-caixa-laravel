<?php

namespace App\Http\Controllers;
use App\Models\Jogador;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transacao;
use Carbon\Carbon;

class TransacaoController extends Controller
{
    public function index()
    {
        // Busca todos os jogadores no banco e os envia para a view
        return Inertia::render('Transacoes/Index', [
            'jogadores' => Jogador::latest()->get(),
        ]);
    }


    public function store(Request $request)
    {
        // 1. Validação dos dados recebidos do formulário Vue
        $validated = $request->validate([
            'jogador_id' => 'required|exists:jogadores,id', // Garante que o jogador selecionado existe
            'valor' => 'required|numeric|min:0.01', // Garante que o valor é um número positivo
            'tipo' => 'required|in:entrada,saida', // Garante que o tipo é 'entrada' ou 'saida'
        ]);

        // 2. Adiciona o ID do usuário logado (o operador do caixa) aos dados
        $validated['user_id'] = auth()->id();

        // 3. Cria a transação no banco de dados
        Transacao::create($validated);

        // 4. Redireciona de volta para a página do caixa. O Inertia vai atualizar as props.
        return redirect()->route('caixa.index');
    }


    public function relatorio(Request $request)
    {
        // Valida se o que foi enviado é de fato uma data.
        $validated = $request->validate([
            'data' => 'nullable|date_format:Y-m-d'
        ]);

        // Usa o Carbon para criar um objeto de data. Se não houver data, usa hoje.
        $dataConsultada = isset($validated['data']) ? Carbon::parse($validated['data']) : Carbon::today();

        // Calcula a soma das 'entradas' para a data especificada.
        $totalEntradas = \App\Models\Transacao::where('tipo', 'entrada')
            ->whereDate('created_at', $dataConsultada)
            ->sum('valor');

        // Calcula a soma das 'saidas' para a data especificada.
        $totalSaidas = \App\Models\Transacao::where('tipo', 'saida')
            ->whereDate('created_at', $dataConsultada)
            ->sum('valor');

        $balancoFinal = $totalEntradas - $totalSaidas;

        return Inertia::render('Relatorios/Index', [
            'totalEntradas' => number_format($totalEntradas, 2, ',', '.'),
            'totalSaidas' => number_format($totalSaidas, 2, ',', '.'),
            'balancoFinal' => number_format($balancoFinal, 2, ',', '.'),
            'dataConsulta' => $dataConsultada->format('Y-m-d'), // Envia a data formatada de volta
        ]);
    }

    public function destroy(Transacao $transacao)
    {
        // 1. Registra quem está cancelando a transação.
        $transacao->deleted_by = auth()->id();
        $transacao->save(); // Salva essa informação no banco

        // 2. Agora, executa o soft delete.
        $transacao->delete();

        // 3. Redireciona de volta.
        return back();
    }
}

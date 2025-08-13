<?php

namespace App\Http\Controllers;

use App\Models\Jogador;
use App\Models\Transacao;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class JogadorController extends Controller
{
    /**
     * Exibe uma lista de todos os jogadores.
     */
    public function index()
    {
        $jogadores = Jogador::latest()->get();

        return Inertia::render('Jogadores/Index', [
            'jogadores' => $jogadores,
        ]);
    }

    /**
     * Mostra o formulário para criar um novo jogador.
     */
    public function create()
    {
        return Inertia::render('Jogadores/Create');
    }

    /**
     * Salva um novo jogador no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'contato' => 'nullable|string|max:255',
        ]);

        Jogador::create($validatedData);

        return redirect()->route('jogadores.index');
    }

    /**
     * Mostra o formulário para editar um jogador existente.
     */
    public function edit(Jogador $jogador)
    {
        return Inertia::render('Jogadores/Edit', [
            'jogador' => $jogador,
        ]);
    }

    /**
     * Atualiza o jogador especificado no banco de dados.
     */
    public function update(Request $request, Jogador $jogador)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'contato' => 'nullable|string|max:255',
        ]);

        $jogador->update($validatedData);

        return redirect()->route('jogadores.index');
    }

    /**
     * Remove o jogador especificado do banco de dados.
     */
    public function destroy(Jogador $jogador)
    {
        $jogador->delete();

        return redirect()->route('jogadores.index');
    }

    /**
     * Mostra o extrato de transações de um jogador.
     */
    public function extrato(Request $request, Jogador $jogador)
    {
        $validated = $request->validate([
            'data' => 'nullable|date_format:Y-m-d'
        ]);

        $dataConsultada = isset($validated['data']) ? Carbon::parse($validated['data']) : Carbon::today();


        $transacoes = Transacao::where('jogador_id', $jogador->id)
            ->whereBetween('created_at', [
                $dataConsultada->copy()->startOfDay(),
                $dataConsultada->copy()->endOfDay()
            ])
            ->latest()
            ->get();

        return Inertia::render('Jogadores/Extrato', [
            'jogador' => $jogador,
            'transacoes' => $transacoes,
            'dataConsulta' => $dataConsultada->format('Y-m-d'),
        ]);
    }
}

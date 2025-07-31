<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\TransacaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota de boas-vindas (pública)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rotas que exigem que o usuário esteja logado e verificado
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROTAS DO PROJETO POKER ---

    // Jogadores (Definidas Manualmente para evitar o erro do Ziggy)
    Route::get('/jogadores', [JogadorController::class, 'index'])->name('jogadores.index');
    Route::get('/jogadores/create', [JogadorController::class, 'create'])->name('jogadores.create');
    Route::post('/jogadores', [JogadorController::class, 'store'])->name('jogadores.store');
    Route::get('/jogadores/{jogador}/edit', [JogadorController::class, 'edit'])->name('jogadores.edit');
    Route::patch('/jogadores/{jogador}', [JogadorController::class, 'update'])->name('jogadores.update');
    Route::delete('/jogadores/{jogador}', [JogadorController::class, 'destroy'])->name('jogadores.destroy');
    Route::get('/jogadores/{jogador}/extrato', [JogadorController::class, 'extrato'])->name('jogadores.extrato');

    // Caixa
    Route::get('/caixa', [TransacaoController::class, 'index'])->name('caixa.index');

    // Transações
    Route::post('/transacoes', [TransacaoController::class, 'store'])->name('transacoes.store');
    Route::delete('/transacoes/{transacao}', [TransacaoController::class, 'destroy'])->name('transacoes.destroy');

    // Relatório
    Route::get('/relatorio', [TransacaoController::class, 'relatorio'])->name('relatorio.index');
});


// Rotas de autenticação (login, register, etc.)
require __DIR__.'/auth.php';

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cria a tabela 'transacoes' para atender ao RF02
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jogador_id')->constrained('jogadores'); // Link com o jogador [cite: 14, 22]
            $table->foreignId('user_id')->constrained('users'); // Link com o operador do caixa
            $table->enum('tipo', ['entrada', 'saida']); // Tipo da transação [cite: 26]
            $table->decimal('valor', 15, 2); // Valor da transação com precisão monetária [cite: 25]
            $table->timestamps(); // Data da transação, essencial para o RF04 [cite: 34]
            $table->softDeletes();// Para cancelamento sem exclusão, conforme RNF02 [cite: 38]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};

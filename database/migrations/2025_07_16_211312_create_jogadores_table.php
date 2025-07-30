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
        // Cria a tabela 'jogadores' para atender ao RF01
        Schema::create('jogadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Armazena o Nome ou Apelido
            $table->string('contato')->nullable(); // O contato é opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jogadores');
    }
};

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
        Schema::table('transacoes', function (Blueprint $table) {
            // Adiciona a coluna para guardar quem cancelou a transação.
            // Ela pode ser nula, pois só terá valor quando a transação for cancelada.
            // A chave estrangeira aponta para a tabela 'users'.
            $table->foreignId('deleted_by')->nullable()->constrained('users')->after('valor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transacoes', function (Blueprint $table) {
            //
        });
    }
};

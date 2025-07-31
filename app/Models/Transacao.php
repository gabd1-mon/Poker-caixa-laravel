<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    use HasFactory, SoftDeletes;

    // Boa prática adicionar o nome da tabela
    protected $table = 'transacoes';



    protected $fillable = [
        'jogador_id',
        'user_id',
        'tipo',
        'valor',
        'deleted_by',
    ];
}

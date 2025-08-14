<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transacoes';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jogador_id',
        'user_id',
        'tipo',
        'valor',
        'deleted_by',
    ];

    /**
     * Define a relação de que uma Transação pertence a um Jogador.
     */
    public function jogador()
    {
        return $this->belongsTo(Jogador::class);
    }
}

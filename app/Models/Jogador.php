<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jogador extends Model
{
    use HasFactory;
    protected $table = 'jogadores';


    /**
     * Os atributos que podem ser atribuídos em massa.
     *
      @var array<int, string>
     */

    protected $fillable = [
        'nome',
        'contato',
    ];
}

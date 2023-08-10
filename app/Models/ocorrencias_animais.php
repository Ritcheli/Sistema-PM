<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_animais extends Model
{
    protected $table = 'ocorrencias_animais';

    protected $fillable = [
        'id_ocorrencia',
        'id_animal',
        'quantidade',
        'observacao',
        'participacao',
    ];

    protected $primaryKey = 'id_ocorrencia_animal';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_animais extends Model
{
    protected $table = 'ocorrencias_extraidas_animais';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_animal',
        'quantidade',
        'observacao',
        'participacao',
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_animal';

    public $timestamps = false;
}

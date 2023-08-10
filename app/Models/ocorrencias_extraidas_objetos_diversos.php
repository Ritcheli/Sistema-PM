<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_objetos_diversos extends Model
{
    protected $table = 'ocorrencias_extraidas_objetos_diversos';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_objeto_diverso',
        'quantidade'
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_objeto_diverso';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_drogas extends Model
{
    protected $table = 'ocorrencias_extraidas_drogas';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_droga',
        'quantidade',
        'un_medida'
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_droga';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_armas extends Model
{
    protected $table = 'ocorrencias_extraidas_armas';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_arma',
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_arma';

    public $timestamps = false;
}

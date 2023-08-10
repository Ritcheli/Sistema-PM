<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_armas extends Model
{
    protected $table = 'ocorrencias_armas';

    protected $fillable = [
        'id_ocorrencia',
        'id_arma',
    ];

    protected $primaryKey = 'id_ocorrencia_arma';

    public $timestamps = false;
}

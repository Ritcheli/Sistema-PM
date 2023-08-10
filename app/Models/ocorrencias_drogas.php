<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_drogas extends Model
{
    protected $table = 'ocorrencias_drogas';

    protected $fillable = [
        'id_ocorrencia',
        'id_droga',
        'quantidade',
        'un_medida'
    ];

    protected $primaryKey = 'id_ocorrencia_droga';

    public $timestamps = false;
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_fatos_ocorrencias extends Model
{
    protected $table = 'ocorrencias_extraidas_fatos_ocorrencias';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_fato_ocorrencia',
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_fato_ocorrencia';

    public $timestamps = false;
}

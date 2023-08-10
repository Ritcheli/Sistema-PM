<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_fatos_ocorrencias extends Model
{
    protected $table = 'ocorrencias_fatos_ocorrencias';

    protected $fillable = [
        'id_ocorrencia',
        'id_fato_ocorrencia'
    ];

    protected $primaryKey = 'id_ocorrencia_fato_ocorrencia';

    public $timestamps = false;
}

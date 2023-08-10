<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_pessoas extends Model
{
    protected $table = 'ocorrencias_extraidas_pessoas';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_pessoa',
        'classificacao'
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_pessoa';

    public $timestamps = false;
}

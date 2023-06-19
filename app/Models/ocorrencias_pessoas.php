<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_pessoas extends Model
{
    protected $table = 'ocorrencias_pessoas';

    protected $fillable = [
        'id_ocorrencia',
        'id_pessoa',
        'classificacao'
    ];

    protected $primaryKey = 'id_ocorrencia_pessoa';

    public $timestamps = false;
}

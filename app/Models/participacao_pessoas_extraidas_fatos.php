<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class participacao_pessoas_extraidas_fatos extends Model
{
    protected $table = 'participacao_pessoas_extraidas_fatos';

    protected $fillable = [
        'id_fato_ocorrencia',
        'id_ocorrencia_extraida_pessoa',
        'participacao'
    ];

    protected $primaryKey = 'id_participacao_pessoa_extraida_fato';

    public $timestamps = false; 
}

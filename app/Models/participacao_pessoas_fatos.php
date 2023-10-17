<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class participacao_pessoas_fatos extends Model
{
    protected $table = 'participacao_pessoas_fatos';

    protected $fillable = [
        'id_fato_ocorrencia',
        'id_ocorrencia_pessoa',
        'participacao'
    ];

    protected $primaryKey = 'id_participacao_pessoa_fato';

    public $timestamps = false; 
}

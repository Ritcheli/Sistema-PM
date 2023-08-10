<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias extends Model
{
    protected $table = 'ocorrencias';

    protected $fillable = [
        'num_protocol',
        'data_hora',
        'endereco_cep',
        'endereco_num',
        'endereco_rua',
        'descricao_inicial',
        'descricao_ocorrencia',
        'id_bairro',
        'id_ocorrencia_extraida',
        'id_usuario'
    ];

    protected $primaryKey = 'id_ocorrencia';

    public $timestamps = false;
}

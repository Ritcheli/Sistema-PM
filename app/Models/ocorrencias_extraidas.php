<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas extends Model
{
    protected $table = 'ocorrencias_extraidas';

    protected $fillable = [
        'num_protocol',
        'data_hora',
        'endereco_cep',
        'endereco_num',
        'endereco_rua',
        'pdf_caminho_servidor',
        'revisado',
        'descricao_inicial',
        'descricao_ocorrencia',
        'possui_envolvidos',
        'possui_veiculos',
        'possui_armas',
        'possui_drogas',
        'possui_objetos',
        'possui_animais',
        'id_bairro',
        'id_usuario'
    ];

    protected $primaryKey = 'id_ocorrencia_extraida';

    public $timestamps = false;
}

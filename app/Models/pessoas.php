<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoas extends Model
{
    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'telefone',
        'RG-CPF',
        'alcunha',
        'observação',
        'confiabilidade_informante',
        'id_faccao',
        'id_estado',
        'id_usuario'
    ];

    protected $primaryKey = 'id_pessoa';

    public $timestamps = false;
}

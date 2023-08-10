<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_veiculos extends Model
{
    protected $table = 'ocorrencias_veiculos';

    protected $fillable = [
        'id_ocorrencia',
        'id_veiculo',
        'participacao'
    ];

    protected $primaryKey = 'id_ocorrencia_veiculo';

    public $timestamps = false;
}

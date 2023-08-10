<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ocorrencias_extraidas_veiculos extends Model
{
    protected $table = 'ocorrencias_extraidas_veiculos';

    protected $fillable = [
        'id_ocorrencia_extraida',
        'id_veiculo',
        'participacao'
    ];

    protected $primaryKey = 'id_ocorrencia_extraida_veiculo';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ocorrencias_objetos_diversos extends Model
{
    protected $table = 'ocorrencias_objetos_diversos';

    protected $fillable = [
        'id_ocorrencia',
        'id_objeto_diverso',
        'quantidade'
    ];

    protected $primaryKey = 'id_objeto_diverso';

    public $timestamps = false;
}

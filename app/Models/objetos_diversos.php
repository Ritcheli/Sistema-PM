<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class objetos_diversos extends Model
{
    protected $table = 'objetos_diversos';

    protected $fillable = [
        'num_identificacao', 
        'modelo',
        'marca',
        'un_medida',
        'id_tipo_objeto'
    ];

    protected $primaryKey = 'id_objeto_diverso';

    public $timestamps = false; 
}

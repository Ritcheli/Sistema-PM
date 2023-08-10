<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class objetos_diversos extends Model
{
    protected $table = 'objetos_diversos';

    protected $fillable = [
        'objeto',
        'num_identificacao', 
        'modelo',
        'marca',
        'tipo',
        'un_medida'
    ];

    protected $primaryKey = 'id_objeto_diverso';

    public $timestamps = false; 
}

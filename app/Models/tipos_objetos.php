<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipos_objetos extends Model
{
    protected $table = 'tipos_objetos';

    protected $fillable = [
        'objeto'
    ];

    protected $primaryKey = 'id_tipo_objeto';

    public $timestamps = false; 
}

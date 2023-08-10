<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupos_fatos extends Model
{
    protected $table = 'grupos_fatos';
    
    protected $fillable = [ 
        'nome',
    ];

    protected $primaryKey = 'id_grupo_fato';

    public $timestamps = false;
}

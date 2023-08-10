<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fatos_ocorrencias extends Model
{
    protected $table = 'fatos_ocorrencias';
    
    protected $fillable = [ 
        'id_grupo_fato',
        'natureza',
        'potencial_ofensivo'
    ];

    protected $primaryKey = 'id_fato_ocorrencia';

    public $timestamps = false;
}

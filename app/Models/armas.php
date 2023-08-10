<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class armas extends Model
{
    protected $table = 'armas';

    protected $fillable = [
        'tipo',
        'especie', 
        'fabricacao',
        'calibre',
        'num_serie',
    ];

    protected $primaryKey = 'id_arma';

    public $timestamps = false; 
}

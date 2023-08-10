<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cidades extends Model
{
    protected $table = 'cidades';

    protected $fillable = [
        'nome',
        'id_estado'
    ];

    protected $primaryKey = 'id_cidade';

    public $timestamps = false;
}

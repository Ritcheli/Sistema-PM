<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bairros extends Model
{
    protected $table = 'bairros';

    protected $fillable = [
        'nome',
        'id_cidade'
    ];

    protected $primaryKey = 'id_bairro';

    public $timestamps = false;
}

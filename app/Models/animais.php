<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class animais extends Model
{
    protected $table = 'animais';

    protected $fillable = [
        'especie'
    ];

    protected $primaryKey = 'id_animal';

    public $timestamps = false; 
}

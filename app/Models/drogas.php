<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class drogas extends Model
{
    protected $table = 'drogas';

    protected $fillable = [
        'tipo'
    ];

    protected $primaryKey = 'id_droga';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estados extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'sigla',
    ];

    protected $primaryKey = 'id_estado';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class marcas_veiculos extends Model
{
    protected $table = 'marcas_veiculos';

    protected $fillable = [
        'marca'
    ];

    protected $primaryKey = 'id_marca_veiculo';

    public $timestamps = false;
}

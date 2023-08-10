<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class veiculos extends Model
{
    protected $table = 'veiculos';

    protected $fillable = [
        'placa',
        'cor',
        'renavam',
        'chassi',
        'id_marca_veiculo'
    ];

    protected $primaryKey = 'id_veiculo';

    public $timestamps = false;
}

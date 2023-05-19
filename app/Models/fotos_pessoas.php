<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fotos_pessoas extends Model
{
    protected $table = 'fotos_pessoas';
    
    protected $fillable = [
        'caminho_servidor',
        'id_pessoa'
    ];

    protected $primaryKey = 'id_foto_pessoa';

    public $timestamps = false;
}

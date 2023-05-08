<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class usuarios extends Authenticatable implements AuthenticatableContract
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nome_usuario',
        'nome_completo',
        'email',
        'senha',
        'token_lembrar',
        'data_nascimento',
        'CPF',
        'data_criacao',
        'permissao',
        'status'
    ];

    protected $hidden = [
        'senha'
    ];

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->senha;
    }
}

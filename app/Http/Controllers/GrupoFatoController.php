<?php

namespace App\Http\Controllers;

use App\Models\grupos_fatos;

class GrupoFatoController extends Controller
{
    public function create($dados){
        return grupos_fatos::create([
            'nome' => $dados['nome']
        ]);
    }
}

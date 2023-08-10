<?php

namespace App\Http\Controllers;

use App\Models\armas;

class ArmaController extends Controller
{
    public function create($dados){
        return armas::create([
            'tipo'       => $dados['tipo'],
            'especie'    => $dados['especie'],
            'fabricacao' => $dados['fabricacao'],
            'calibre'    => $dados['calibre'],
            'num_serie'  => $dados['num_serie']
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_drogas;

class OcorrenciaDrogaController extends Controller
{
    public function create($dados){
        return ocorrencias_drogas::create([
            'id_ocorrencia' => $dados['id_ocorrencia'],
            'id_droga'      => $dados['id_droga'],
            'quantidade'    => $dados['quantidade'],
            'un_medida'     => $dados['un_medida'],
        ]);
    }
}

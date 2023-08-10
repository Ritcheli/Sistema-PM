<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_drogas;

class OcorrenciaExtraidaDrogaController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_drogas::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_droga'               => $dados['id_droga'],
            'quantidade'             => $dados['quantidade'],
            'un_medida'              => $dados['un_medida'],
        ]);
    }
}

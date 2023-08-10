<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_objetos_diversos;

class OcorrenciaExtraidaObjetoDiversoController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_objetos_diversos::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_objeto_diverso'      => $dados['id_objeto_diverso'],
            'quantidade'             => $dados['quantidade']
        ]);
    }
}

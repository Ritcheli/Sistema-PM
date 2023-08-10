<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_objetos_diversos;

class OcorrenciaObjetoDiversoController extends Controller
{
    public function create($dados){
        return ocorrencias_objetos_diversos::create([
            'id_ocorrencia'     => $dados['id_ocorrencia'],
            'id_objeto_diverso' => $dados['id_objeto_diverso'],
            'quantidade'        => $dados['quantidade']
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_fatos_ocorrencias;

class OcorrenciaFatoOcorrenciaController extends Controller
{
    public function create($dados){
        return ocorrencias_fatos_ocorrencias::create([
            'id_ocorrencia'      => $dados['id_ocorrencia'],
            'id_fato_ocorrencia' => $dados['id_fato_ocorrencia']
        ]);
    }
}

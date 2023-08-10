<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_fatos_ocorrencias;

class OcorrenciaExtraidaFatoOcorrenciaController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_fatos_ocorrencias::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_fato_ocorrencia'     => $dados['id_fato_ocorrencia']
        ]);
    }
}

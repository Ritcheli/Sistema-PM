<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_armas;

class OcorrenciaExtraidaArmaController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_armas::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_arma'                => $dados['id_arma']
        ]);
    }
}

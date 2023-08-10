<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_armas;

class OcorrenciaArmaController extends Controller
{
    public function create($dados){
        return ocorrencias_armas::create([
            'id_ocorrencia' => $dados['id_ocorrencia'],
            'id_arma'       => $dados['id_arma']
        ]);
    }
}

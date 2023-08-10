<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_veiculos;

class OcorrenciaExtraidaVeiculoController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_veiculos::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_veiculo'             => $dados['id_veiculo'],
            'participacao'           => $dados['participacao']
        ]);
    }
}

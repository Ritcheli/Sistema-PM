<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_veiculos;

class OcorrenciaVeiculoController extends Controller
{
    public function create($dados){
        return ocorrencias_veiculos::create([
            'id_ocorrencia' => $dados['id_ocorrencia'],
            'id_veiculo'    => $dados['id_veiculo'],
            'participacao'  => $dados['participacao']
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_animais;

class OcorrenciaExtraidaAnimalController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_animais::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_animal'              => $dados['id_animal'],
            'quantidade'             => $dados['quantidade'],
            'observacao'             => $dados['observacao'],
            'participacao'           => $dados['participacao'],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_animais;

class OcorrenciaAnimalController extends Controller
{
    public function create($dados){
        return ocorrencias_animais::create([
            'id_ocorrencia' => $dados['id_ocorrencia'],
            'id_animal'     => $dados['id_animal'],
            'quantidade'    => $dados['quantidade'],
            'observacao'    => $dados['observacao'],
            'participacao'  => $dados['participacao'],
        ]);
    }
}

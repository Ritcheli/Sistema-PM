<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_extraidas_pessoas;

class OcorrenciaExtraidaPessoaController extends Controller
{
    public function create($dados){
        return ocorrencias_extraidas_pessoas::create([
            'id_ocorrencia_extraida' => $dados['id_ocorrencia_extraida'],
            'id_pessoa'              => $dados['id_pessoa'],
            'classificacao'          => 'N'
        ]);
    }
}

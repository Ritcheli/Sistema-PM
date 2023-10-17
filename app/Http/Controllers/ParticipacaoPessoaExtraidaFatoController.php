<?php

namespace App\Http\Controllers;

use App\Models\participacao_pessoas_extraidas_fatos;

class ParticipacaoPessoaExtraidaFatoController extends Controller
{
    public function create($dados){
        return participacao_pessoas_extraidas_fatos::create([
            'id_fato_ocorrencia'            => $dados['id_fato_ocorrencia'],
            'id_ocorrencia_extraida_pessoa' => $dados['id_ocorrencia_extraida_pessoa'],
            'participacao'                  => $dados['participacao']
        ]);
    }
}

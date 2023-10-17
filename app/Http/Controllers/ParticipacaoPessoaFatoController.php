<?php

namespace App\Http\Controllers;

use App\Models\participacao_pessoas_fatos;

class ParticipacaoPessoaFatoController extends Controller
{
    public function create($dados){
        return participacao_pessoas_fatos::create([
            'id_fato_ocorrencia'   => $dados['id_fato_ocorrencia'],
            'id_ocorrencia_pessoa' => $dados['id_ocorrencia_pessoa'],
            'participacao'         => $dados['participacao']
        ]);
    }
}

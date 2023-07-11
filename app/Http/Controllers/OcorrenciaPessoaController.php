<?php

namespace App\Http\Controllers;

use App\Models\ocorrencias_pessoas;
use Illuminate\Support\Facades\DB;

class OcorrenciaPessoaController extends Controller
{
    public function create($dados){
        return ocorrencias_pessoas::create([
            'id_ocorrencia' => $dados['id_ocorrencia'],
            'id_pessoa'     => $dados['id_pessoa'],
            'classificacao' => 'N'
        ]);
    }
}

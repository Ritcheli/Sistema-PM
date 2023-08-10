<?php

namespace App\Http\Controllers;

use App\Models\fatos_ocorrencias;
use Illuminate\Support\Facades\DB;

class FatoOcorrenciaController extends Controller
{
    public function create($dados){
        return fatos_ocorrencias::create([
            'natureza'           => $dados['natureza'],
            'potencial_ofensivo' => $dados['potencial_ofensivo'],
            'id_grupo_fato'      => $dados['id_grupo_fato']
        ]);
    }
}

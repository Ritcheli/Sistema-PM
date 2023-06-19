<?php

namespace App\Http\Controllers;

use App\Models\cidades;
use Illuminate\Support\Facades\DB;

class CidadeController extends Controller
{
    public function create($dados){
        $id_cidade = DB::table('cidades')
                   ->select('id_cidade')
                   ->where('nome', $dados['endereco_cidade'])
                   ->where('id_estado', $dados['id_estado'])
                   ->get();

        if (count($id_cidade) == 0){
            $cidade = cidades::create([
                'nome'      => $dados['endereco_cidade'],
                'id_estado' => $dados['id_estado']
            ]);

            return $cidade->id_cidade;
        } else {
            return $id_cidade[0]->id_cidade;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\bairros;
use Illuminate\Support\Facades\DB;

class BairroController extends Controller
{
    public function create($dados){
        $id_bairro = DB::table('bairros')
                     ->select('id_bairro')
                     ->where('nome', $dados['endereco_bairro'])
                     ->where('id_cidade', $dados['id_cidade'])
                     ->get();
        
        if (count($id_bairro) == 0){
            $bairro = bairros::create([
                'nome'  => $dados['endereco_bairro'],
                'id_cidade' => $dados['id_cidade']
            ]);

            return $bairro->id_bairro;
        } else {
            return $id_bairro[0]->id_bairro;
        }
    }
}

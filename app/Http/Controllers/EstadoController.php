<?php

namespace App\Http\Controllers;

use App\Models\estados;
use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    public function create($dados){
        $id_estado = DB::table('estados')
                   ->select('id_estado')
                   ->where('sigla', $dados['endereco_estado'])
                   ->get();


        if (count($id_estado) == 0) {
            $estado = estados::create([
                'sigla' => $dados['endereco_estado']
            ]);

            return ($estado->id_estado);
        } else {
            return ($id_estado[0]->id_estado);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\tipos_objetos;
use Illuminate\Support\Facades\DB;

class TipoObjetoController extends Controller
{
    public function create($dados){
        $tipo_objeto = DB::table('tipos_objetos')
                         ->select('id_tipo_objeto')
                         ->where('tipos_objetos.objeto', $dados['objeto'])
                         ->first();
        
        if ($tipo_objeto == null) {
            $tipo_objeto = tipos_objetos::create([
                                'objeto' => $dados['objeto']
                           ]);
        }

        return $tipo_objeto->id_tipo_objeto;
    }
}

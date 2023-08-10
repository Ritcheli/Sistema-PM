<?php

namespace App\Http\Controllers;

use App\Models\drogas;
use Illuminate\Support\Facades\DB;

class DrogaController extends Controller
{
    public function create($dados){
        $id_droga = DB::table('drogas')
                       ->select('id_droga')
                       ->where('tipo', $dados['tipo'])
                       ->first();

        if ($id_droga == null) {
            $droga = drogas::create([
                'tipo' => $dados['tipo']
            ]);

            return ($droga->id_droga);
        } else {
            return ($id_droga->id_droga);
        }
    }
}

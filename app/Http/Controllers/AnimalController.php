<?php

namespace App\Http\Controllers;

use App\Models\animais;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    public function create($dados){
        $id_animal = DB::table('animais')
                       ->select('id_animal')
                       ->where('especie', $dados['especie'])
                       ->first();

        if ($id_animal == null) {
            $animal = animais::create([
                'especie' => $dados['especie']
            ]);

            return ($animal->id_animal);
        } else {
            return ($id_animal->id_animal);
        }
    }
}

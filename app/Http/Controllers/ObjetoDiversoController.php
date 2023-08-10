<?php

namespace App\Http\Controllers;

use App\Models\objetos_diversos;

class ObjetoDiversoController extends Controller
{
    public function create($data){  
        return objetos_diversos::create([
            'objeto'             => $data['objeto'],
            'num_identificacao'  => $data['num_identificacao'],
            'modelo'             => $data['modelo'],
            'un_medida'          => $data['un_medida'],
            'marca'              => $data['marca'],
            'tipo'               => $data['tipo']
        ]);
    }
}

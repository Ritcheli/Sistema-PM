<?php

namespace App\Http\Controllers;

use App\Models\objetos_diversos;

class ObjetoDiversoController extends Controller
{
    public function create($data){  
        return objetos_diversos::create([
            'num_identificacao'  => $data['num_identificacao'],
            'modelo'             => $data['modelo'],
            'un_medida'          => $data['un_medida'],
            'marca'              => $data['marca'],
            'id_tipo_objeto'     => $data['id_tipo_objeto']
        ]);
    }
}

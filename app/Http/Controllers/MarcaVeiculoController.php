<?php

namespace App\Http\Controllers;

use App\Models\marcas_veiculos;

class MarcaVeiculoController extends Controller
{
    public function create($data){
        return marcas_veiculos::create([
            'marca' => $data
        ]);
    }
}

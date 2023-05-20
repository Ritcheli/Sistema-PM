<?php

namespace App\Http\Controllers;

use App\Models\fotos_pessoas;

class FotosPessoasController extends Controller
{
    public function create(array $data){
        return fotos_pessoas::create([
            'caminho_servidor' => $data['caminho_servidor'],
            'id_pessoa'        => $data['id_pessoa']
        ]);
    }
}

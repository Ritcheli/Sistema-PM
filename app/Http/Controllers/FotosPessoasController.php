<?php

namespace App\Http\Controllers;

use App\Models\fotos_pessoas;
use Illuminate\Support\Facades\DB;

class FotosPessoasController extends Controller
{
    public function buscar_Foto_Pessoa($id_pessoa){
        return DB::table('fotos_pessoas')
                 ->select('id_foto_pessoa' ,'caminho_servidor')
                 ->where('id_pessoa', $id_pessoa)
                 ->get();
    }

    public function create(array $data){
        return fotos_pessoas::create([
            'caminho_servidor' => $data['caminho_servidor'],
            'id_pessoa'        => $data['id_pessoa']
        ]);
    }

    public function destroy($id_foto_pessoa){
        DB::delete('delete from fotos_pessoas where id_foto_pessoa = ?', [$id_foto_pessoa]);
    }
}

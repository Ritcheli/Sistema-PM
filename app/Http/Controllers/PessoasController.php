<?php

namespace App\Http\Controllers;

use App\Models\pessoas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Image;

class PessoasController extends Controller
{
    public function nova_Pessoa_Ocorr(Request $request){
        $validator = Validator::make($request->all(), [
            'nome'              => ['required', 'string', 'max:60'],
            'telefone'          => ['max:15'],
            'CPF_RG'            => ['max:11'],
            'alcunha'           => ['max:60'],
            'observacao_pessoa' => ['max:65535'],
            'files.*'           => ['mimes:jpg,jpeg,png'],
        ]);     

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $data = $request->only('nome', 'telefone', 'CPF_RG', 'data_nascimento', 'alcunha', 'observacao_pessoa');

        $pessoa = $this->create($data);

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file) {
                $name = time().'_'.$file->getClientOriginalName().'.'.$file->extension();
                $caminho_img = public_path('uploads\fotos_pessoas') . '/' . $name;

                // Redimensionando a imagem
                $new_img = Image::fromFile($file->path());
                $new_img->resize(250, 250);
                $new_img->save($caminho_img);

                $dado_foto = [
                    'caminho_servidor' => $caminho_img,
                    'id_pessoa'        => $pessoa->id_pessoa
                ];

                (new FotosPessoasController)->create($dado_foto);
            }           
        }
        return response()->json([
            'pessoa' => $pessoa,
        ]);
    }

    public function buscar_Pessoa_Ocorr(Request $request){
        $pessoas = DB::table('pessoas')
                     ->select('id_pessoa', 'nome', 'RG_CPF')
                     ->where('nome', 'like', '%' . $request->nome . '%')->get();

        Log::debug($request->nome);

        return response()->json([
            'pessoas' => $pessoas,
        ]);
    }

    public function create(array $data){
        return pessoas::create([
            'nome'            => $data['nome'],
            'data_nascimento' => $data['data_nascimento'],
            'telefone'        => $data['telefone'],
            'RG_CPF'          => $data['CPF_RG'],
            'alcunha'         => $data['alcunha'],
            'observacao'      => $data['observacao_pessoa'],    
            'id_usuario'      => Auth::id()
        ]);
    }
}

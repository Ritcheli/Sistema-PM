<?php

namespace App\Http\Controllers;

use App\Models\pessoas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PessoasController extends Controller
{
    public function nova_Pessoa_Ocorr(Request $request){
        $validator = Validator::make($request->all(), [
            'nome'              => ['required', 'string', 'max:60'],
            'telefone'          => ['max:15'],
            'CPF_RG'            => ['max:11'],
            'alcunha'           => ['max:60'],
            'observacao_pessoa' => ['max:65535']
        ]);     

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $data = $request->only('nome', 'telefone', 'CPF_RG', 'data_nascimento', 'alcunha', 'observacao_pessoa');
        
        Log::debug($data);

        $this->create($data);
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

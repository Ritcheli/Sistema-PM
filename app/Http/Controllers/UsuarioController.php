<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function show_Cad_Usuario(){
        return view("usuario.cad_usuario");
    }

    public function novo_usuario(Request $request){
        $request->validate([
            'nome_usuario'   => ['required', 'string', 'max:60', 'unique:usuarios'],
            'nome_completo'  => ['required', 'string', 'max:60'],
            'email'          => ['required', 'string', 'email', 'max:90', 'unique:usuarios'],
            'CPF_RG'         => ['required', 'string', 'max:20'],
            'data_nasc'      => ['required', 'date'],
            'senha'          => ['required', 'min:6', 'same:confirma_senha'],
            'confirma_senha' => ['required', 'min:6', 'same:senha']
        ]);

        $data = $request->only('nome_usuario', 'nome_completo', 'email', 'CPF_RG', 'data_nasc', 'senha');
        $this->create($data);

        return redirect('/dashboard');
    }

    public function show_Perfil(){
        $query_usuarios = DB::table('usuarios')
                            ->select('usuarios.nome_usuario', 'usuarios.nome_completo', 'usuarios.email', 'usuarios.data_nascimento', 'usuarios.CPF', 'usuarios.status')
                            ->where('usuarios.id_usuario', Auth::id())
                            ->first();

        return view("usuario.perfil", compact('query_usuarios'));
    }

    public function create($data){
        return usuarios::create([
            'nome_usuario'    => $data['nome_usuario'],
            'nome_completo'   => $data['nome_completo'],
            'email'           => $data['email'],
            'senha'           => Hash::make($data['senha']),
            'token_lembrar'   => 'teste',
            'data_nascimento' => $data['data_nasc'],
            'CPF'             => $data['CPF_RG'],
            'data_criacao'    => date('d-m-y h:i:s'),
            'permissao'       => 'admin',
            'status'          => 'A'
        ]);
    }
}

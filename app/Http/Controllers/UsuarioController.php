<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function show_Cad_Usuario(){
        $Who_Call = "Cad_Usuario";

        return view("usuario.cad_usuario", compact('Who_Call'));
    }

    public function show_Edit_Usuario(){
        $Who_Call = "Edit_Usuario";

        $query_Usuarios = DB::table("usuarios")
                            ->select("usuarios.nome_completo", "usuarios.nome_usuario", "usuarios.email", "usuarios.CPF", "usuarios.data_nascimento")
                            ->where("usuarios.id_usuario", Auth::id())
                            ->first();

        return view("usuario.cad_usuario", compact("Who_Call", "query_Usuarios"));
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

        return redirect('/usuario/perfil');
    }

    public function edit_Usuario(Request $request){
        $usuario = Auth::user();

        $request->validate([
            'nome_usuario'   => ['required', 'string', 'max:60', Rule::unique('usuarios', 'nome_usuario')->ignore($usuario->id_usuario, 'id_usuario')],
            'nome_completo'  => ['required', 'string', 'max:60'],
            'email'          => ['required', 'string', 'email', 'max:90', Rule::unique('usuarios', 'email')->ignore($usuario->id_usuario, 'id_usuario')],
            'CPF_RG'         => ['required', 'string', 'max:20'],
            'data_nasc'      => ['required', 'date'],
            'senha'          => ['required', 'min:6', 'same:confirma_senha'],
            'confirma_senha' => ['required', 'min:6', 'same:senha']
        ]);

        $data = $request->only('nome_usuario', 'nome_completo', 'email', 'CPF_RG', 'data_nasc', 'senha');
        $this->update($data);

        return redirect('/usuario/perfil');
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

    public function update($data){
        $usuario = usuarios::find(Auth::id());

        $usuario->update([
            'nome_usuario'    => $data['nome_usuario'],
            'nome_completo'   => $data['nome_completo'],
            'email'           => $data['email'],
            'senha'           => Hash::make($data['senha']),
            'data_nascimento' => $data['data_nasc'],
            'CPF'             => $data['CPF_RG']
        ]);

        return $usuario;
    }
}

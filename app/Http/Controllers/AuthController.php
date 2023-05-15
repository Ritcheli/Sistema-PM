<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function show_login(){
        if (Auth::check()){
            return redirect()->intended('dashboard');
        }

        return view("usuario.login");
    }

    public function login(Request $request){
        $request->validate([
            'nome_usuario' => ['required'],
            'senha' => ['required']
        ]);

        $credentials = $request->only('nome_usuario', 'senha');

        if (Auth::attempt(['nome_usuario' => $credentials['nome_usuario'], 'password' =>$credentials['senha']])) {
            return redirect()->intended('dashboard');
        }

        Session::flash('error', 'Usuário ou senha não encontrados!');

        return redirect("");
    }

    public function logout(){
        Session::flush();
        Auth::logout();

        return redirect('');
    }
}

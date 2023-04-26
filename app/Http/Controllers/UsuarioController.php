<?php

namespace App\Http\Controllers;

class UsuarioController extends Controller
{
    public function show()
    {
        return view("usuario.cad_usuario");
    }
}

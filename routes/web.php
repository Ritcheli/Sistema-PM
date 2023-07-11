<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotosPessoasController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\PessoasController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/",[AuthController::class, "show_login"])->name("show_Login");
Route::post("/", [AuthController::class, "login"])->name("login");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");

Route::middleware('auth')->group(function(){
    Route::get("/cad-usuario", [UsuarioController::class, "show_Cad_Usuario"])->name("show_Cad_Usuario");
    Route::post("/cad-usuario", [UsuarioController::class, "novo_Usuario"])->name("novo_Usuario");

    Route::get("/ocorrencia/cad-ocorrencia", [OcorrenciaController::class, "show_Cad_Ocorrencia"])->name("show_Cad_Ocorrencia");
    Route::get("/ocorrencia/buscar-ocorrencia", [OcorrenciaController::class, "show_Busca_Ocorrencia"])->name("show_Busca_Ocorrencia");
    Route::get("/ocorrencia/visualizar_ocorrencia/{id_ocorrencia}", [OcorrenciaController::class, "show_Visualizar_Ocorrencia"])->name("show_Visualizar_Ocorrencia");
    Route::get("/ocorrencia/editar-ocorrencia/{id_ocorrencia}", [OcorrenciaController::class, "show_Editar_Ocorrencia"])->name("show_Editar_Ocorrencia");
    Route::post("/ocorrencia/pessoa-ocorrencia", [PessoasController::class, "nova_Pessoa"])->name("nova_Pessoa");
    Route::post("/ocorrencia/nova-ocorrencia", [OcorrenciaController::class, "nova_Ocorrencia"])->name("nova_Ocorrencia");
    Route::post("/ocorrencia/editar-ocorrencia", [OcorrenciaController::class, "editar_Ocorrencia"])->name("editar_Ocorrencia");
    Route::post("/ocorrencia/excluir-ocorrencia", [OcorrenciaController::class, "excluir_Ocorrencia"])->name("excluir_Ocorrencia");
    Route::post("/ocorrencia/buscar-pessoa-modal", [PessoasController::class, "buscar_Pessoa_Ocorr_Modal"])->name("buscar_Pessoa_Ocorr_Modal");
    Route::post("/ocorrencia/editar-pessoa-modal", [PessoasController::class, "show_Editar_Pessoa_Ocorr_Modal"])->name("editar_Pessoa_Ocorr_Modal");

    Route::get("/pessoa/cad-pessoa", [PessoasController::class, "show_Cad_Pessoa"])->name("show_Cad_Pessoa");
    Route::get("/pessoa/busca-pessoa", [PessoasController::class, "show_Busca_Pessoa"])->name("show_Busca_Pessoa");
    Route::get("/pessoa/visualizar-pessoa/{id_pessoa}", [PessoasController::class, "show_Visualizar_Pessoa"])->name("show_Visualizar_Pessoa");
    Route::get("/pessoa/editar-pessoa/{id_pessoa}", [PessoasController::class, "show_Editar_Pessoa"])->name('show_Editar_Pessoa');
    Route::post("/pessoa/excluir-pessoa", [PessoasController::class, "excluir_Pessoa"])->name("excluir_Pessoa");
    Route::post("/pessoa/salvar-edit-pessoa", [PessoasController::class, "editar_Pessoa"])->name("salvar_Edit_Pessoa");

    Route::post("/fotos-pessoas", [FotosPessoasController::class, "buscar_Foto_Pessoa_Ajax"])->name("buscar_Foto_Pessoa");

    Route::get("/dashboard", [DashboardController::class, "show_Dashboard"])->name("show_Dashboard");
});


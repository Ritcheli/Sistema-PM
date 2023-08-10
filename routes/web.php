<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\ObjetosDiversosController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\OcorrenciaExtraidaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeiculoController;
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
    Route::get('/ocorrencia/revisar-ocorrencia/{id_ocorrencia_extraida}', [OcorrenciaExtraidaController::class, "show_Revisar_Ocorrencia"])->name("show_Revisar_Ocorrencia");
    Route::get('/ocorrencia/importar-ocorrencia', [OcorrenciaExtraidaController::class, "show_Importar_Ocorrencia"])->name("show_Importar_Ocorrencia");
    Route::post("/ocorrencia/pessoa-ocorrencia", [PessoaController::class, "nova_Pessoa"])->name("nova_Pessoa");
    Route::post("/ocorrencia/nova-ocorrencia", [OcorrenciaController::class, "nova_Ocorrencia"])->name("nova_Ocorrencia");
    Route::post("/ocorrencia/editar-ocorrencia", [OcorrenciaController::class, "editar_Ocorrencia"])->name("editar_Ocorrencia");
    Route::post("/ocorrencia/excluir-ocorrencia", [OcorrenciaController::class, "excluir_Ocorrencia"])->name("excluir_Ocorrencia");
    Route::post("/ocorrencia/buscar-pessoa-modal", [PessoaController::class, "buscar_Pessoa_Ocorr_Modal"])->name("buscar_Pessoa_Ocorr_Modal");
    Route::post("/ocorrencia/editar-pessoa-modal", [PessoaController::class, "show_Editar_Pessoa_Ocorr_Modal"])->name("editar_Pessoa_Ocorr_Modal");
    Route::post("/ocorrencia/importar-pdf", [OcorrenciaExtraidaController::class, "importar_Ocorrencia"])->name("importar_Ocorrencia");
    Route::post("/ocorrencia/nova-ocorrencia-revisada", [OcorrenciaExtraidaController::class, "nova_Ocorrencia_Revisada"])->name("nova_Ocorrencia_Revisada");
    Route::post("/ocorrencia/excluir-ocorrencia-extraida", [OcorrenciaExtraidaController::class, "excluir_Ocorrencia_Extraida"])->name('excluir_Ocorrencia_Extraida');

    Route::post("/veiculo/cad-veiculo", [VeiculoController::class, "novo_Veiculo"])->name('novo_Veiculo');
    Route::post("/veiculo/buscar-veiculo-modal", [VeiculoController::class, "buscar_Veiculo_Modal"])->name('buscar_Veiculo_Modal');
    Route::post("/veiculo/buscar-veiculo-por-placa", [VeiculoController::class, "buscar_Veiculo_Por_Placa"])->name('buscar_Veiculo_Por_Placa');

    Route::post("/objeto-diverso/cad-objeto-diverso", [ObjetosDiversosController::class, "novo_Objeto_Diverso"])->name('novo_Objeto_Diverso');
    Route::post("/objeto-diverso/buscar-objeto-diverso", [ObjetosDiversosController::class, "buscar_Objeto_Diverso"])->name('buscar_Objeto_Diverso');
    Route::post("/objeto-diverso/buscar-objeto-diverso-por-id", [ObjetosDiversosController::class, "buscar_Objeto_Diverso_Por_Id"])->name('buscar_Objeto_Diverso_Por_Id');

    Route::get("/pessoa/cad-pessoa", [PessoaController::class, "show_Cad_Pessoa"])->name("show_Cad_Pessoa");
    Route::get("/pessoa/busca-pessoa", [PessoaController::class, "show_Busca_Pessoa"])->name("show_Busca_Pessoa");
    Route::get("/pessoa/visualizar-pessoa/{id_pessoa}", [PessoaController::class, "show_Visualizar_Pessoa"])->name("show_Visualizar_Pessoa");
    Route::get("/pessoa/editar-pessoa/{id_pessoa}", [PessoaController::class, "show_Editar_Pessoa"])->name('show_Editar_Pessoa');
    Route::post("/pessoa/excluir-pessoa", [PessoaController::class, "excluir_Pessoa"])->name("excluir_Pessoa");
    Route::post("/pessoa/salvar-edit-pessoa", [PessoaController::class, "editar_Pessoa"])->name("salvar_Edit_Pessoa");

    Route::post("/fotos-pessoas", [FotoPessoaController::class, "buscar_Foto_Pessoa_Ajax"])->name("buscar_Foto_Pessoa");

    Route::get("/dashboard", [DashboardController::class, "show_Dashboard"])->name("show_Dashboard");
});


<?php

use App\Http\Controllers\AnaliseOcorrenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\ObjetosDiversosController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\OcorrenciaExtraidaController;
use App\Http\Controllers\PDFController;
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
    Route::controller(UsuarioController::class)->group(function () {
        Route::get("/cad-usuario", "show_Cad_Usuario")->name("show_Cad_Usuario");
        Route::get("/edit-usuario", "show_Edit_Usuario")->name("show_Edit_Usuario");
        Route::post("/cad-usuario", "novo_Usuario")->name("novo_Usuario");
        Route::post("/edit-usuario", "edit_Usuario")->name("edit_Usuario");
        Route::get("/usuario/perfil", "show_Perfil")->name("show_Perfil");
    });

    Route::controller(OcorrenciaController::class)->group(function () {
        Route::get("/ocorrencia/cad-ocorrencia", "show_Cad_Ocorrencia")->name("show_Cad_Ocorrencia");
        Route::get("/ocorrencia/buscar-ocorrencia", "show_Busca_Ocorrencia")->name("show_Busca_Ocorrencia");
        Route::get("/ocorrencia/visualizar_ocorrencia/{id_ocorrencia}", "show_Visualizar_Ocorrencia")->name("show_Visualizar_Ocorrencia");
        Route::get("/ocorrencia/editar-ocorrencia/{id_ocorrencia}", "show_Editar_Ocorrencia")->name("show_Editar_Ocorrencia");
        Route::get("/ocorrencia/cad-ocorrencia", "show_Cad_Ocorrencia")->name("show_Cad_Ocorrencia");
        Route::get("/ocorrencia/buscar-ocorrencia", "show_Busca_Ocorrencia")->name("show_Busca_Ocorrencia");
        Route::get("/ocorrencia/visualizar_ocorrencia/{id_ocorrencia}", "show_Visualizar_Ocorrencia")->name("show_Visualizar_Ocorrencia");
        Route::get("/ocorrencia/editar-ocorrencia/{id_ocorrencia}", "show_Editar_Ocorrencia")->name("show_Editar_Ocorrencia");
        Route::get("/ocorrencia/cad-ocorrencia", "show_Cad_Ocorrencia")->name("show_Cad_Ocorrencia");
        Route::get("/ocorrencia/buscar-ocorrencia", "show_Busca_Ocorrencia")->name("show_Busca_Ocorrencia");
        Route::get("/ocorrencia/visualizar_ocorrencia/{id_ocorrencia}", "show_Visualizar_Ocorrencia")->name("show_Visualizar_Ocorrencia");
        Route::get("/ocorrencia/editar-ocorrencia/{id_ocorrencia}", "show_Editar_Ocorrencia")->name("show_Editar_Ocorrencia");
        Route::post("/ocorrencia/nova-ocorrencia", "nova_Ocorrencia")->name("nova_Ocorrencia");
        Route::post("/ocorrencia/editar-ocorrencia", "editar_Ocorrencia")->name("editar_Ocorrencia");
        Route::post("/ocorrencia/excluir-ocorrencia", "excluir_Ocorrencia")->name("excluir_Ocorrencia");
    });

    Route::controller(OcorrenciaExtraidaController::class)->group(function () {
        Route::get('/ocorrencia/revisar-ocorrencia/{id_ocorrencia_extraida}', "show_Revisar_Ocorrencia")->name("show_Revisar_Ocorrencia");
        Route::get('/ocorrencia/importar-ocorrencia', "show_Importar_Ocorrencia")->name("show_Importar_Ocorrencia");
        Route::post("/ocorrencia/importar-pdf", "importar_Ocorrencia")->name("importar_Ocorrencia");
        Route::post("/ocorrencia/nova-ocorrencia-revisada", "nova_Ocorrencia_Revisada")->name("nova_Ocorrencia_Revisada");
        Route::post("/ocorrencia/excluir-ocorrencia-extraida", "excluir_Ocorrencia_Extraida")->name('excluir_Ocorrencia_Extraida');
    });    

    Route::controller(PessoaController::class)->group(function () {
        Route::post("/ocorrencia/pessoa-ocorrencia", "nova_Pessoa")->name("nova_Pessoa");
        Route::post("/ocorrencia/buscar-pessoa-modal", "buscar_Pessoa_Ocorr_Modal")->name("buscar_Pessoa_Ocorr_Modal");
        Route::post("/ocorrencia/editar-pessoa-modal", "show_Editar_Pessoa_Ocorr_Modal")->name("editar_Pessoa_Ocorr_Modal");
        Route::get("/pessoa/cad-pessoa", "show_Cad_Pessoa")->name("show_Cad_Pessoa");
        Route::get("/pessoa/busca-pessoa", "show_Busca_Pessoa")->name("show_Busca_Pessoa");
        Route::get("/pessoa/visualizar-pessoa/{id_pessoa}", "show_Visualizar_Pessoa")->name("show_Visualizar_Pessoa");
        Route::get("/pessoa/editar-pessoa/{id_pessoa}", "show_Editar_Pessoa")->name('show_Editar_Pessoa');
        Route::post("/pessoa/excluir-pessoa", "excluir_Pessoa")->name("excluir_Pessoa");
        Route::post("/pessoa/salvar-edit-pessoa", "editar_Pessoa")->name("salvar_Edit_Pessoa");
    });

    Route::controller(VeiculoController::class)->group(function () {
        Route::post("/veiculo/cad-veiculo", "novo_Veiculo")->name('novo_Veiculo');
        Route::post("/veiculo/buscar-veiculo-modal", "buscar_Veiculo_Modal")->name('buscar_Veiculo_Modal');
        Route::post("/veiculo/buscar-veiculo-por-placa", "buscar_Veiculo_Por_Placa")->name('buscar_Veiculo_Por_Placa');    
    });

    Route::controller(ObjetosDiversosController::class)->group(function () {
        Route::post("/objeto-diverso/cad-objeto-diverso", "novo_Objeto_Diverso")->name('novo_Objeto_Diverso');
        Route::post("/objeto-diverso/buscar-objeto-diverso", "buscar_Objeto_Diverso")->name('buscar_Objeto_Diverso');
        Route::post("/objeto-diverso/buscar-objeto-diverso-por-id", "buscar_Objeto_Diverso_Por_Id")->name('buscar_Objeto_Diverso_Por_Id');
    });

    Route::controller(AnaliseOcorrenciaController::class)->group(function () {
        Route::get("/analise-ocorrencia", "show_Analise_Ocorrencia")->name('show_Analise_Ocorrencia');
        Route::post("/analise-ocorrencia/plot-SNA-graph", "plot_SNA_Graph")->name('plot_SNA_Graph');
    });

    Route::controller(FotoPessoaController::class)->group(function () {
        Route::post("/fotos-pessoas", "buscar_Foto_Pessoa_Ajax")->name("buscar_Foto_Pessoa");
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get("/dashboard", "show_Dashboard")->name("show_Dashboard");
        Route::get("/dashboard/ocorr-chart-data", "get_Ocorr_Chart_Data")->name("get_Ocorr_Chart_Data");
        Route::get("/dashboard/grupo-chart-data", "get_Grupo_Chart_Data")->name("get_Grupo_Chart_Data");
    });

    Route::controller(ConfiguracoesController::class)->group(function () {
        Route::get('/configuracoes', 'show_Configuracoes')->name('show_Configuracoes');
        Route::post('/configuracoes/importar-fatos', 'importar_Fatos')->name('importar_Fatos');
        Route::post('/configuracoes/adiciona-fatos-manual', 'adiciona_Fatos_Manual')->name('adiciona_Fatos_Manual');
    });

    Route::controller(PDFController::class)->group(function (){
        Route::get('/ocorrencia/visualizar_ocorrencia/{id_ocorrencia}/pdf', 'create_PDF_Ocorrencia')->name('create_PDF_Ocorrencia');
        Route::get('/pessoa/visualizar_pessoa/{id_pessoa}/pdf', 'create_PDF_Pessoa')->name('create_PDF_Pessoa');
    });
});


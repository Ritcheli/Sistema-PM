<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
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

Route::get("/",[AuthController::class, "index"]);
Route::get("/cad-usuario", [UsuarioController::class, "cad_usuario"]);

Route::get("/cad-ocorrencia", [OcorrenciaController::class, "show"]);

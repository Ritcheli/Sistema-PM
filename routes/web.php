<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OcorrenciaController;
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

Route::get("/",[AuthController::class, "show_login"])->name("show_Login");
Route::post("/", [AuthController::class, "login"])->name("login");
Route::get("/cad-usuario", [AuthController::class, "show_Cad_Usuario"])->name("show_Cad_Usuario");
Route::post("/cad-usuario", [AuthController::class, "novo_Usuario"])->name("novo_Usuario");

Route::get("/dashboard", [DashboardController::class, "show_Dashboard"])->name("show_Dashboard");

Route::get("/cad-ocorrencia", [OcorrenciaController::class, "show_Cad_Ocorrencia"]);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesquisadorController;
use \App\Http\Controllers\MunicipioController;
use \App\Http\Controllers\DoencaController;
use \App\Http\Controllers\UFController;
use \App\Http\Controllers\PacienteController;
use \App\Http\Controllers\RegistroPacienteDoencasController;
use \App\Http\Controllers\ConsultasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});





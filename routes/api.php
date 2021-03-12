<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\API\MunicipioController;
use \App\Http\Controllers\API\DoencaController;
use \App\Http\Controllers\API\UFController;
use \App\Http\Controllers\API\PacienteController;
use \App\Http\Controllers\API\PesquisadorController;
use \App\Http\Controllers\API\RegistroPacienteDoencasController;
use \App\Http\Controllers\API\ConsultasController;
use \App\Http\Controllers\API\RegiaoController;
use \App\Http\Controllers\API\FaixaEtariaController;
use \App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::prefix('/pesquisador')->group( function (){
        Route::get('/', [PesquisadorController::class, 'index']);
        Route::get('/{id}', [PesquisadorController::class, 'show']);
        Route::post('/', [PesquisadorController::class, 'store']);
        Route::delete('/{id}', [PesquisadorController::class, 'destroy']);
        Route::put('/{id}', [PesquisadorController::class, 'update']);
    });

    Route::prefix('/municipio')->group( function (){
        Route::get('/', [MunicipioController::class, 'index']);
        Route::get('/{id}', [MunicipioController::class, 'show']);
        Route::post('/', [MunicipioController::class, 'store']);
        Route::delete('/{id}', [MunicipioController::class, 'destroy']);
        Route::put('/{id}', [MunicipioController::class, 'update']);
    });

    Route::prefix('/doenca')->group( function (){
        Route::get('/', [DoencaController::class, 'index']);
        Route::get('/{id}', [DoencaController::class, 'show']);
        Route::post('/', [DoencaController::class, 'store']);
        Route::delete('/{id}', [DoencaController::class, 'destroy']);
        Route::put('/{id}', [DoencaController::class, 'update']);
    });

    Route::prefix('/uf')->group( function (){
        Route::get('/', [UFController::class, 'index']);
        Route::get('/{id}', [UFController::class, 'show']);
        Route::post('/', [UFController::class, 'store']);
        Route::delete('/{id}', [UFController::class, 'destroy']);
        Route::put('/{id}', [UFController::class, 'update']);
    });

    Route::prefix('/paciente')->group( function (){
        Route::get('/', [PacienteController::class, 'index']);
        Route::get('/{id}', [PacienteController::class, 'show']);
        Route::post('/', [PacienteController::class, 'store']);
        Route::delete('/{id}', [PacienteController::class, 'destroy']);
        Route::put('/{id}', [PacienteController::class, 'update']);
    });

    Route::prefix('/registro_paciente_doenca')->group( function (){
        Route::get('/', [RegistroPacienteDoencasController::class, 'index']);
        Route::get('/paciente/{id}', [RegistroPacienteDoencasController::class, 'show']);
        Route::get('/paciente/{paciente_id}/doenca/{doenca_id}', [RegistroPacienteDoencasController::class, 'showByPacienteDoenca']);
        Route::post('/', [RegistroPacienteDoencasController::class, 'store']);
        Route::delete('/paciente/{paciente_id}/doenca/{doenca_id}', [RegistroPacienteDoencasController::class, 'destroy']);
        Route::put('/paciente/{paciente_id}/doenca/{doenca_id}', [RegistroPacienteDoencasController::class, 'update']);
    });

    Route::get('/regiao', [RegiaoController::class, 'index']);
    Route::get('/faixaetaria', [FaixaEtariaController::class, 'index']);
});

Route::prefix('/modulo_transparencia')->group( function (){
    Route::get('/', [ConsultasController::class, 'consultaAgregada']);
    Route::get('/ordenada', [ConsultasController::class, 'consultaOrdenada']);
    Route::get('/ordenada/export-csv', [ConsultasController::class, 'exportIntoCSV']);
    Route::get('/filtrada', [ConsultasController::class, 'consultaFiltrada']);
    Route::prefix('/agregado/doenca')->group( function () {
        Route::get('/', [ConsultasController::class, 'agregadoDoenca']);
        Route::get('/uf', [ConsultasController::class, 'agregadoDoencaUF']);
        Route::get('/faixa_etaria', [ConsultasController::class, 'agregadoDoencaFaixaEtaria']);
        Route::get('/sexo/faixa_etaria', [ConsultasController::class, 'agregadoDoencaSexoFaixaEtaria']);
        Route::get('/sexo', [ConsultasController::class, 'agregadoDoencaSexo']);
    });
});



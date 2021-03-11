<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    /**
     * @OA\Info(
     *     title="API Registro Epidemiologico de Doenças Raras",
     *     version="1.0",
     *     description="Aplicação REST que consiste em um registro epidemiológico para pacientes com doenças raras a
    servir aplicações que podem ser outros sistemas ou uma interface de usuário.",)
     *
     * @OA\Server(
     *  url="localhost:8000/registro_epidemiologico/api",
     *  description=""
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

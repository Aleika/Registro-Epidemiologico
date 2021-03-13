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
     *     description="API RESTful para o registro epidemiológico de pacientes com doenças raras a
    servir aplicações que podem ser outros sistemas ou uma interface de usuário. A API consiste em requisições que precisam de autenticação,
    destinadas aos usuários que utilizam do módulo de gestão, para restringir as operações de CRUD do sistema aos usuário autenticados. Além disso, a API também conta
    com requisições livres de autenticação, que estarão disponíveis para serem utilizadas pelo módulo de transparência, que é aberto ao público. A autenticação
    é feita com 'Bearer authentication', também conhecido como 'token authentication', ou seja, para as requisições que necessitam de autenticação é necessário
    passar a informação do token.")
     *
     * @OA\Server(
     *  url="http://127.0.0.1:8000/api",
     *  description="Caminho base para acesso"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

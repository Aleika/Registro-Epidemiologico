<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Regiao;

class RegiaoController extends Controller
{

    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/regiao?token=",
     *     tags={"região"},
     *     summary="Lista de regiões",
     *     description="Retorna uma lista com as regiões inseridas.",
     *     operationId="index",
     *     security={{"bearerAuth":{}}},

     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer",example="1"),
     *                  @OA\Property(property="nome",type="string",example="Nordeste"),
     *                  @OA\Property(property="sigla",type="string",example="NE"),
     *              ),
     *          )
     *     )
     * )
     */
    public function index()
    {
        $regioes = Regiao::all();

        return response()->json($regioes);
    }
}

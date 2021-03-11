<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Regiao;

class RegiaoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/regiao",
     *     tags={"região"},
     *     summary="Lista de regiões",
     *     description="Retorna uma lista com as regiões inseridas.",
     *     operationId="index",
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

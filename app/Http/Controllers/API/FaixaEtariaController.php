<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FaixaEtaria;

class FaixaEtariaController extends Controller
{

    /**
     * @OA\Get(
     *     path="/faixaetaria",
     *     tags={"faixa etária"},
     *     summary="Lista de faixas etárias",
     *     description="Retorna uma lista com as faixas etárias inseridas.",
     *     operationId="index",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer",example="1"),
     *                  @OA\Property(property="classe",type="string",example="00-18"),
     *                  @OA\Property(property="idade_min",type="integer",example="0"),
     *                  @OA\Property(property="idade_max",type="integer",example="18"),
     *              ),
     *          )
     *     )
     * )
     */
    public function index()
    {
        $regioes = FaixaEtaria::all();

        return response()->json($regioes);
    }
}

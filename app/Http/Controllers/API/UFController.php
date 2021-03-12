<?php

namespace App\Http\Controllers\API;

use App\Models\UF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UFController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/uf?token=",
     *     tags={"unidade federativa"},
     *     summary="Lista de UFs",
     *     description="Retorna uma lista com as unidades federativas cadastradas.",
     *     operationId="index",
     *     security={{"bearerAuth":{}}},
     *   @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="nome",
     *                      type="string",
     *                      example="Rio Grande do Norte"
     *                  ),
     *                  @OA\Property(
     *                      property="codigo_ibge",
     *                      type="integer",
     *                      example="24"
     *                  ),
     *                  @OA\Property(
     *                      property="regiao_id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time"
     *                  ),
     *                   @OA\Property(
     *                              property="regiao",
     *                               type="array",
     *                              @OA\Items(
     *                               @OA\Property(property="id", type="integer", example="1"),
     *                               @OA\Property(property="nome", type="string", example="Nordeste"),
     *                               @OA\Property(property="sigla", type="string", example="NE"),
     *                      )
     *                  )
     *              ),
     *          )
     *     )
     * )
     */
    public function index()
    {
       $ufs = UF::query()->with('regiao')->get();
       return response()->json($ufs);
    }

    /**
     * @OA\Post(
     *     path="/uf?token=",
     *     tags={"unidade federativa"},
     *     summary="Cadastrar unidade UF",
     *     description="Cadastra UF. Retorna a UF cadastrada.",
     *     operationId="store",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="201",
     *         description="Registro cadastrado com sucesso",
     *     @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="nome",
     *                      type="string",
     *                      example="Paraíba"
     *                  ),
     *                  @OA\Property(
     *                      property="sigla",
     *                      type="string",
     *                      example="PB"
     *                  ),
     *                  @OA\Property(
     *                      property="codigo_ibge",
     *                      type="integer",
     *                      example="25"
     *                  ),
     *                  @OA\Property(
     *                      property="regia_id",
     *                      type="integer",
     *                      example="PB"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time"
     *                  )
     *              ),
     *     ),
     *      @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Registro já cadastrado"
     *     ),
     *     @OA\RequestBody(
     *         description="Cadastrar nova UF",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","sigla", "codigo_ibge", "regiao_id"},
     *          @OA\Property(property="nome", type="string", format="", example="Paraíba"),
     *          @OA\Property(property="sigla", type="string", format="", example="PB"),
     *          @OA\Property(property="codigo_ibge", type="integer", format="", example="25"),
     *          @OA\Property(property="regiao_id", type="integer", format="", example="1"),
     *         ),
     *     ),
     *    )
     *  )
     * )
     */
    public function store(Request $request)
    {
        $uf = UF::query()->where('nome', '=', $request->input('nome'))->get();

        if(sizeof($uf) > 0) {
            return response()->json(['erro' => 'Registro já cadastrado'], 400);
        }

        $uf = new UF();
        $uf->fill($request->all());
        $uf->save();

        return response()->json($uf, 201);
    }

    /**
     * @OA\Get(
     *     path="/uf/{uf_id}?token=",
     *     tags={"unidade federativa"},
     *     summary="Listar UF",
     *     description="Retorna a UF cujo id foi passado pela url.",
     *     operationId="show",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uf_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *   @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="nome",
     *                      type="string",
     *                      example="Rio Grande do Norte"
     *                  ),
     *                  @OA\Property(
     *                      property="codigo_ibge",
     *                      type="integer",
     *                      example="24"
     *                  ),
     *                  @OA\Property(
     *                      property="regiao_id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time"
     *                  ),
     *                   @OA\Property(
     *                              property="regiao",
     *                               type="array",
     *                              @OA\Items(
     *                               @OA\Property(property="id", type="integer", example="1"),
     *                               @OA\Property(property="nome", type="string", example="Nordeste"),
     *                               @OA\Property(property="sigla", type="string", example="NE"),
     *                      )
     *                  )
     *              ),
     *          )
     *     )
     * )
     */
    public function show($id)
    {
        $uf = UF::query()->where('id', $id)->get();

        if(sizeof($uf)===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        return response()->json($uf);
    }

    /**
     * @OA\Put(
     *     path="/uf/{if_id}?token=",
     *     tags={"unidade federativa"},
     *     summary="Atualiza a UF cujo id é passado pela url.",
     *     description="Atualiza a UF. Retorna a UF atualizada.",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uf_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operação realizada com sucesso",
     *     @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="nome",
     *                      type="string",
     *                      example="Paraíba"
     *                  ),
     *                  @OA\Property(
     *                      property="sigla",
     *                      type="string",
     *                      example="PB"
     *                  ),
     *                  @OA\Property(
     *                      property="codigo_ibge",
     *                      type="integer",
     *                      example="25"
     *                  ),
     *                  @OA\Property(
     *                      property="regia_id",
     *                      type="integer",
     *                      example="PB"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time"
     *                  )
     *              ),
     *     ),
     *      @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\RequestBody(
     *         description="Atualizar UF",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","sigla", "codigo_ibge", "regiao_id"},
     *          @OA\Property(property="nome", type="string", format="", example="Paraíba"),
     *          @OA\Property(property="sigla", type="string", format="", example="PB"),
     *          @OA\Property(property="codigo_ibge", type="integer", format="", example="25"),
     *          @OA\Property(property="regiao_id", type="integer", format="", example="1"),
     *         ),
     *     ),
     *    )
     *  )
     * )
     */
    public function update(Request $request, $id)
    {
        $uf = UF::query()->where("id", $id);

        if(sizeof($uf->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $uf->update($request->all());

        return response()->json($uf->get());
    }

    /**
     * @OA\Delete (
     *     path="/uf/{if_id}?token=",
     *     tags={"unidade federativa"},
     *     summary="Deleta UF",
     *     description="Remove a UF cujo id é passado pela url.",
     *     operationId="destroy",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uf_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *      @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Registro não encontrado"
     *     )
     *    )
     *  )
     * )
     */
    public function destroy($id)
    {
        $uf = UF::query()->where("id", $id);

        if(sizeof($uf->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $uf->delete();
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doenca;
use Illuminate\Http\Request;

class DoencaController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/doenca?token=",
     *     tags={"doença"},
     *     summary="Lista de doenças",
     *     description="Retorna uma lista com as doenças cadastradas.",
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
     *                  @OA\Property(property="id",type="integer",example="1"),
     *                  @OA\Property(property="nome",type="string",example="Doença de Sandhoff"),
     *                  @OA\Property(property="descricao",type="string",example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."),
     *                  @OA\Property(property="created_at", type="string", format="date-time"),
     *                  @OA\Property( property="updated_at", type="string", format="date-time")
     *              ),
     *          )
     *     )
     * )
     */
    public function index()
    {
        $doencas = Doenca::all();
        return response()->json($doencas);
    }

    /**
     * @OA\Post(
     *     path="/doenca?token=",
     *     tags={"doença"},
     *     summary="Cadastrar doença",
     *     description="Cadastra doença. Retorna a doença cadastrada.",
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
     *                      example="Doença de Sandhoff"
     *                  ),
     *                  @OA\Property(
     *                      property="descricao",
     *                      type="string",
     *                      example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."
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
     *         description="Cadastrar nova doença",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","descricao"},
     *          @OA\Property(property="nome", type="string", format="", example="Doença de Sandhoff"),
     *          @OA\Property(property="descricao", type="string", format="", example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."),
     *         ),
     *     ),
     *    )
     *  )
     * )
     */
    public function store(Request $request)
    {
        $doenca = Doenca::query()->where('nome', '=', $request->input('nome'))->get();

        if(sizeof($doenca) > 0) {
            return response()->json(['erro' => 'Registro já cadastrado'], 400);
        }

        $doenca = new Doenca();
        $doenca->fill($request->all());
        $doenca->save();

        return response()->json($doenca, 201);
    }

    /**
     * @OA\Get(
     *     path="/doenca/{doenca_id}?token=",
     *     tags={"doença"},
     *     summary="Listar doença",
     *     description="Retorna dados da doença cujo id é passado pela url.",
     *     operationId="show",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="doenca_id",
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
     *         response=404,
     *         description="Registro não encontrado",
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="nome",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="descricao",
     *                      type="string",
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
     *              )
     *          )
     *     )
     * )
     */
    public function show($id)
    {
        $doenca = Doenca::query()->where("id", $id)->get();

        if(sizeof($doenca)===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        return response()->json($doenca);
    }

    /**
     * @OA\Put(
     *     path="/doenca/{doenca_id}?token=",
     *     tags={"doença"},
     *     summary="Atualizar doença",
     *     description="Atualiza dados da doença cujo id é passado na url. Retorna a doença com os dados atualizados.",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="doenca_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operação realizada com sucesso",
     *      @OA\MediaType(
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
     *                      example="Doença de Sandhoff"
     *                  ),
     *                  @OA\Property(
     *                      property="descricao",
     *                      type="string",
     *                      example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."
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
     *    ),
     *      @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Registro já cadastrado"
     *     ),
     *     @OA\RequestBody(
     *         description="Atualizar doença já cadastrada",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","descricao"},
     *          @OA\Property(property="nome", type="string", format="", example="Doença de Sandhoff"),
     *          @OA\Property(property="descricao", type="string", format="", example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."),
     *          )
     *        ),
     *     )
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        $doenca = Doenca::query()->where("id", $id);

        if(sizeof($doenca->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $doenca->update($request->all());

        return response()->json($doenca->get());
    }

    /**
     * @OA\Delete(
     *     path="/doenca/{doenca_id}?token=",
     *     summary="Remover doença",
     *     description="Remove a doença cujo id é passado pela url.",
     *     operationId="destroy",
     *     tags={"doença"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="id da doença a ser removida",
     *         in="path",
     *         name="doenca_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *      @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Redistro não encontrado"
     *     ),
     * )
     */
    public function destroy($id)
    {
        $doenca = Doenca::query()->where("id", $id);

        if(sizeof($doenca->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $doenca->delete();
    }
}

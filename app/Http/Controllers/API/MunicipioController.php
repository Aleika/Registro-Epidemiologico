<?php

namespace App\Http\Controllers\API;

use App\Models\Municipio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MunicipioController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/municipio",
     *     tags={"município"},
     *     summary="Lista de municipios",
     *     description="Retorna uma lista com os municipios cadastrados.",
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
     *                      example="Natal"
     *                  ),
     *                  @OA\Property(
     *                      property="uf_id",
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
     *                      property="uf",
     *                      type="array",
     *                      @OA\Items(
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="nome", type="string", example="Rio Grande do Norte"),
     *                         @OA\Property(property="sigla", type="string", example="RN"),
     *                         @OA\Property(property="codigo_ibge", type="integer", example="24"),
     *                         @OA\Property(property="created_at",type="string", format="date-time"),
     *                         @OA\Property(property="updated_at",type="string",format="date-time"),
     *                         @OA\Property(
     *                              property="regiao",
     *                               type="array",
     *                              @OA\Items(
     *                               @OA\Property(property="id", type="integer", example="1"),
     *                               @OA\Property(property="nome", type="string", example="Nordeste"),
     *                               @OA\Property(property="sigla", type="string", example="NE"),
     *                      )
     *                  )
     *                      )
     *                  )
     *              ),
     *          )
     *     )
     * )
     */
    public function index()
    {
        $municipios = Municipio::query()->with(['uf'])->with(['uf.regiao'])->get();

        return response()->json($municipios);
    }

    /**
     * @OA\Post(
     *     path="/municipio",
     *     tags={"município"},
     *     summary="Cadastrar município",
     *     description="Cadastra município. Retorna o município cadastrado.",
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
     *                      example="Angicos"
     *                  ),
     *                  @OA\Property(
     *                      property="uf_id",
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
     *     )
     *          )
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
     *         description="Cadastrar novo município",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","uf_id"},
     *          @OA\Property(property="nome", type="string", format="", example="Angicos"),
     *          @OA\Property(property="uf_id", type="integer", format="", example="1"),
     *         ),
     *     ),
     *    )
     *  )
     * )
     */
    public function store(Request $request)
    {

        $municipio = Municipio::query()->where('nome', '=', $request->input('nome'))->get();

        if(sizeof($municipio) > 0) {
            return response()->json(["erro" => "Registro já cadastrado"], 400);
        }

        $municipio = new Municipio();
        $municipio->fill($request->all());
        $municipio->save();

        return response()->json($municipio, 201);
    }

    /**
     * @OA\Get(
     *     path="/municipio/{municipio_id}",
     *     tags={"município"},
     *     summary="Listar município",
     *     description="Retorna os dados do município cujo id é passado pela url.",
     *     operationId="show",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="municipio_id",
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
     *           @OA\MediaType(
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
     *                      example="Natal"
     *                  ),
     *                  @OA\Property(
     *                      property="uf_id",
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
     *                      property="uf",
     *                      type="array",
     *                      @OA\Items(
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="nome", type="string", example="Rio Grande do Norte"),
     *                         @OA\Property(property="sigla", type="string", example="RN"),
     *                         @OA\Property(property="codigo_ibge", type="integer", example="24"),
     *                         @OA\Property(property="created_at",type="string", format="date-time"),
     *                         @OA\Property(property="updated_at",type="string",format="date-time"),
     *                         @OA\Property(
     *                              property="regiao",
     *                               type="array",
     *                              @OA\Items(
     *                               @OA\Property(property="id", type="integer", example="1"),
     *                               @OA\Property(property="nome", type="string", example="Nordeste"),
     *                               @OA\Property(property="sigla", type="string", example="NE"),
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     * )
     */
    public function show($id)
    {
        $municipio = Municipio::query()->with(['uf'])->with(['uf.regiao'])->where("id", $id)->get();

        if(sizeof($municipio)===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        return response()->json($municipio);
    }

    /**
     * @OA\Put(
     *     path="/municipio/{municipio_id}",
     *     tags={"município"},
     *     summary="Atualizar município",
     *     description="Atualiza dados do município cujo id é passado na url. Retorna o município com os dados atualizados.",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="municipio_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Operação realizada com sucesso",
     *         @OA\MediaType(
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
     *                      example="ANGICOS"
     *                  ),
     *                  @OA\Property(
     *                      property="uf_id",
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
     *              )
     *          )
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
     *         description="Atualizar município já cadastrado",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","uf_id"},
     *          @OA\Property(property="nome", type="string", format="", example="ANGICOS"),
     *          @OA\Property(property="uf_id", type="integer", format="", example="1"),
     *    ),
     * ),
     *     )
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        $municipio = Municipio::query()->with(['uf'])->with(['uf.regiao'])->where("id", $id);

        if(sizeof($municipio->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $municipio = Municipio::query()->where("id", $id);

        $municipio->update($request->all());

        return response()->json($municipio->get());
    }


    /**
     * @OA\Delete(
     *     path="/municipio/{municipio_id}",
     *     summary="Remover município",
     *     description="Remove o município cujo id é passado pela url.",
     *     operationId="destroy",
     *     tags={"município"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="id do município a ser removido",
     *         in="path",
     *         name="municipio_id",
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
        $municipio = Municipio::query()->with(['uf'])->with(['uf.regiao'])->where("id", $id);

        if(sizeof($municipio->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $municipio->delete();
    }
}

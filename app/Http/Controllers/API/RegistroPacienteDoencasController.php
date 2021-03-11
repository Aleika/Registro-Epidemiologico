<?php

namespace App\Http\Controllers\API;

use App\Models\RegistroPacienteDoencas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistroPacienteDoencasController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/registro_paciente_doenca",
     *     tags={"registro de doenças do paciente"},
     *     summary="Lista de registros",
     *     description="Lista os registros das doenças dos pacientes.",
     *     operationId="index",
     *     security={{"bearerAuth":{}}},
     *   @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *   @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer", example="1"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="deleted_at", type="string",format="date-time"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *                  @OA\Property(
     *                      property="doenca",
     *                      type="array",
     *                       @OA\Items(
     *                          @OA\Property(property="id",type="integer",example="1"),
     *                          @OA\Property(property="nome",type="string",example="Doença de Sandhoff"),
     *                          @OA\Property(property="descricao",type="string",example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."),
     *                          @OA\Property(property="created_at", type="string", format="date-time"),
     *                          @OA\Property( property="updated_at", type="string", format="date-time")
     *                        )
     *                  ),
     *                  @OA\Property(property="paciente", type="array",
     *                      @OA\Items(
     *                           @OA\Property(property="id",type="integer", example="1"),
     *                           @OA\Property(property="pessoa_id",type="integer",example="1"),
     *                           @OA\Property(property="faixa_etaria_id",type="integer",example="4"),
     *                           @OA\Property( property="deleted_at",type="string",format="date-time"),
     *                           @OA\Property( property="created_at",type="string",format="date-time"),
     *                           @OA\Property( property="updated_at",type="string", format="date-time"),
     *                      )
     *                  ),
     *              )
     *          )
     *     )
     * )
     */
    public function index()
    {
        $registros_paciente_doencas = RegistroPacienteDoencas::query()
            ->with('pacientes', 'doencas')->get();

        return response()->json($registros_paciente_doencas);
    }

    /**
     * @OA\Post(
     *     path="/registro_paciente_doenca",
     *     tags={"registro de doenças do paciente"},
     *     summary="Salvar registro que relaciona paciente à doença",
     *     description="Cadastra o registro. Retorna o registro cadastrado.",
     *     operationId="store",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="201",
     *         description="Registro cadastrado com sucesso",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer", example="1"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *              ),
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
     *         description="Cadastrar novo registro de doença para o paciente",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"doenca_id","paciente_id", "data_inicio_sintomas", "local_inicio_sintomas", "data_diagnostico"},
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *           ),
     *       ),
     *    )
     *  )
     */
    public function store(Request $request)
    {
        $registro = RegistroPacienteDoencas::query()
            ->where('paciente_id', $request->input('paciente_id'))
            ->where('doenca_id', $request->input('doenca_id'))
            ->get();

        if(sizeof($registro) > 0) {
            return response()->json(['erro' => 'Registro já cadastrado'], 400);
        }

        $registro = new RegistroPacienteDoencas();
        $registro->fill($request->all());
        $registro->save();

        return response()->json($registro, 201);
    }

    /**
     * @OA\Get(
     *     path="/registro_paciente_doenca/paciente/{paciente_id}",
     *     tags={"registro de doenças do paciente"},
     *     summary="Listar doenças do paciente",
     *     description="Lista as doenças do paciente cujo id foi passado pela url.",
     *     operationId="show",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="paciente_id",
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
     *     @OA\Response(
     *         response="404",
     *         description="Registro não encontrado"
     *     ),
     *   @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer", example="1"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="deleted_at", type="string",format="date-time"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *                  @OA\Property(
     *                      property="doenca",
     *                      type="array",
     *                       @OA\Items(
     *                          @OA\Property(property="id",type="integer",example="1"),
     *                          @OA\Property(property="nome",type="string",example="Doença de Sandhoff"),
     *                          @OA\Property(property="descricao",type="string",example="São esfingolipidoses, distúrbios hereditários do metabolismo, causadas por deficiência de hexosaminidase que levam a sintomas neurológicos graves e morte prematura."),
     *                          @OA\Property(property="created_at", type="string", format="date-time"),
     *                          @OA\Property( property="updated_at", type="string", format="date-time")
     *                        )
     *                  ),
     *              )
     *          )
     *     )
     * )
     */
    public function show($id)
    {
        $doencas_paciente = RegistroPacienteDoencas::query()
            ->with('doencas')
            ->where('paciente_id', $id)
            ->get();

        if(sizeof($doencas_paciente) === 0) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }

        return response()->json($doencas_paciente);
    }

    /**
     * @OA\Get(
     *     path="/registro_paciente_doenca/paciente/{paciente_id}/doenca/{doenca_id}",
     *     tags={"registro de doenças do paciente"},
     *     summary="Lista registro da relação entre doença e paciente",
     *     description="Lista os dados do registro a partir do id do paciente e do id da doenca ambos passados pela url.",
     *     operationId="showByPacienteDoenca",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="paciente_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="doenca_id",
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
     *   @OA\Response(
     *         response="404",
     *         description="Registro não encontrado"
     *     ),
     *   @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer", example="1"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="deleted_at", type="string",format="date-time"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *              )
     *          )
     *     )
     * )
     */
    public function showByPacienteDoenca($paciente_id, $doenca_id)
    {
        $doencas_paciente = RegistroPacienteDoencas::query()
            ->where('paciente_id', $paciente_id)
            ->where('doenca_id', $doenca_id)
            ->get();

        if(sizeof($doencas_paciente) === 0) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }

        return response()->json($doencas_paciente);
    }

    /**
     * @OA\Put(
     *     path="/registro_paciente_doenca/paciente/{paciente_id}/doenca/{doenca_id}",
     *     tags={"registro de doenças do paciente"},
     *     summary="Atualizar registro da doença do paciente",
     *     description="Atualiza o registro a partir do id do paciente e o id da doença passados pela url. Retorna registro atualizado.",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         description="Atualiza registro de doença para o paciente",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"doenca_id","paciente_id", "data_inicio_sintomas", "local_inicio_sintomas", "data_diagnostico"},
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *           ),
     *       ),
     *     @OA\Parameter(
     *         name="paciente_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
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
     *         response="404",
     *         description="Registro não encontrado"
     *     ),
     *    @OA\Response(
     *         response="200",
     *         description="Registro atualizado com sucesso",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer", example="1"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="paciente_id",type="integer",example="1"),
     *                  @OA\Property(property="data_inicio_sintomas",type="string", format="date-time"),
     *                  @OA\Property(property="local_inicio_sintomas",type="string",example="Braço esquerdo"),
     *                  @OA\Property(property="data_diagnostico",type="string", format="date-time"),
     *                  @OA\Property(property="observacoes",type="string", example="Avanço rápido da doença"),
     *                  @OA\Property(property="deleted_at",type="string", format="date-time"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string",format="date-time"),
     *              ),
     *          )
     *     ),
     *  )
     */
    public function update(Request $request, $paciente_id, $doenca_id)
    {
        $registros_paciente_doencas = RegistroPacienteDoencas::query()->where('paciente_id', $paciente_id)
            ->where('doenca_id', $doenca_id);

        if(sizeof($registros_paciente_doencas->get()) === 0) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }

        $registros_paciente_doencas->update($request->all());

        return response()->json($registros_paciente_doencas->get());
    }

    /**
     * @OA\Delete (
     *     path="/registro_paciente_doenca/paciente/{paciente_id}/doenca/{doenca_id}",
     *     tags={"registro de doenças do paciente"},
     *     summary="Deletar registro da doença do paciente",
     *     description="Deleta o registro a partir do id do paciente e o id da doença passados pela url.",
     *     operationId="destroy",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="paciente_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
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
     *         response="404",
     *         description="Registro não encontrado"
     *     ),
     *  )
     */
    public function destroy($paciente_id, $doenca_id)
    {
        $registros_paciente_doencas = RegistroPacienteDoencas::query()->where('paciente_id', $paciente_id)
            ->where('doenca_id', $doenca_id);

        if(sizeof($registros_paciente_doencas->get()) === 0) {
            return response()->json(['erro' => 'Registro não encontrado'], 404);
        }

        $registros_paciente_doencas->delete();
    }
}

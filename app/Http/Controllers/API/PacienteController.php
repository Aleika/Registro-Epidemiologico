<?php

namespace App\Http\Controllers\API;

use App\Models\FaixaEtaria;
use App\Models\Paciente;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class PacienteController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/paciente",
     *     tags={"paciente"},
     *     summary="Lista de pacientes",
     *     description="Retorna uma lista com os pacientes cadastrados.",
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
     *                  @OA\Property(property="id",type="integer", example="1"),
     *                  @OA\Property(property="pessoa_id",type="integer",example="1"),
     *                  @OA\Property(property="faixa_etaria_id",type="integer",example="4"),
     *                  @OA\Property( property="deleted_at",type="string",format="date-time"),
     *                  @OA\Property( property="created_at",type="string",format="date-time"),
     *                  @OA\Property( property="updated_at",type="string", format="date-time"),
     *                   @OA\Property(
     *                      property="pessoa",
     *                      type="array",
     *                      @OA\Items(
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *                         @OA\Property(property="cpf", type="string", example="22266655544"),
     *                         @OA\Property(property="data_nascimento", type="string", format="date"),
     *                         @OA\Property(property="sexo", type="string", example="F"),
     *                         @OA\Property(property="municipio_id", type="integer", example="1"),
     *                         @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *                         @OA\Property(property="profissao", type="string", example="Professora"),
     *                         @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *                         @OA\Property(property="telefone", type="string", example="3333-6565"),
     *                         @OA\Property(property="deleted_at",type="string", format="date-time"),
     *                         @OA\Property(property="created_at",type="string", format="date-time"),
     *                         @OA\Property(property="updated_at",type="string",format="date-time"),
     *                         @OA\Property(
     *                              property="municipio",
     *                               type="array",
     *                              @OA\Items(
     *                               @OA\Property(property="id", type="integer", example="1"),
     *                               @OA\Property(property="nome", type="string", example="Assu"),
     *                               @OA\Property(property="uf_id", type="integer", example="1"),
     *                               @OA\Property(property="created_at",type="string", format="date-time"),
     *                               @OA\Property(property="updated_at",type="string",format="date-time"),
     *                               @OA\Property(
     *                                  property="uf",
     *                                  type="array",
     *                                  @OA\Items(
     *                                       @OA\Property(property="id", type="integer", example="1"),
     *                                       @OA\Property(property="nome", type="string", example="Rio Grande do Norte"),
     *                                       @OA\Property(property="sigla", type="string", example="RN"),
     *                                       @OA\Property(property="codigo_ibge", type="integer", example="24"),
     *                                       @OA\Property(property="regiao_id", type="integer", example="1"),
     *                                       @OA\Property(property="created_at",type="string", format="date-time"),
     *                                       @OA\Property(property="updated_at",type="string",format="date-time"),
     *                                  )
     *                              )
     *                          )
     *                      )
     *                  )
     *               ),
     *              @OA\Property(
     *                  property="faixa_etaria",
     *                  type="array",
     *                  @OA\Items(
     *                       @OA\Property(property="id", type="integer", example="4"),
     *                       @OA\Property(property="classe", type="string", example="36-50"),
     *                       @OA\Property(property="idade_min", type="integer", example="36"),
     *                       @OA\Property(property="idade_max", type="integer", example="50"),
     *                      )
     *                 ),
     *             ),
     *          )
     *     )
     * )
     */
    public function index()
    {
        $pacientes = Paciente::query()->with('pessoa')
            ->with('faixaEtaria')
            ->with(['pessoa.municipio'])
            ->with(['pessoa.municipio.uf'])
            ->get();

        return response()->json($pacientes);
    }

    /**
     * @OA\Post(
     *     path="/paciente",
     *     tags={"paciente"},
     *     summary="Cadastrar paciente",
     *     description="Cadastra paciente. Retorna o paciente cadastrado.",
     *     operationId="store",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="201",
     *         description="Registro cadastrado com sucesso",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *                  @OA\Property(property="cpf", type="string", example="22266655544"),
     *                  @OA\Property(property="data_nascimento", type="string", format="date"),
     *                  @OA\Property(property="sexo", type="string", example="F"),
     *                  @OA\Property(property="municipio_id", type="integer", example="1"),
     *                  @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *                  @OA\Property(property="profissao", type="string", example="Professora"),
     *                  @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *                  @OA\Property(property="telefone", type="string", example="3333-6565"),
     *                  @OA\Property(property="created_at",type="string", format="date-time"),
     *                  @OA\Property(property="updated_at",type="string",format="date-time"),
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
     *         description="Cadastrar novo paciente",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","cpf", "data_nascimento", "sexo", "municipio_id"},
     *          @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *          @OA\Property(property="cpf", type="string", example="22266655544"),
     *          @OA\Property(property="data_nascimento", type="string", format="date"),
     *          @OA\Property(property="sexo", type="string", example="F"),
     *          @OA\Property(property="municipio_id", type="integer", example="1"),
     *          @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *          @OA\Property(property="profissao", type="string", example="Professora"),
     *          @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *          @OA\Property(property="telefone", type="string", example="3333-6565"),
     *         ),
     *     ),
     *    )
     *  )
     */
    public function store(Request $request)
    {
        $pessoa = Pessoa::query()->where('cpf', $request->input('cpf'))->get();

        if(sizeof($pessoa) > 0){
            return response()->json(['erro' => 'Registro já cadastrado'], 400);
        }

        $pessoa = new Pessoa();
        $pessoa->nome = $request->input('nome');
        $pessoa->cpf = $request->input('cpf');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->sexo = $request->input('sexo');
        $pessoa->endereco = $request->input('endereco');
        $pessoa->profissao = $request->input('profissao');
        $pessoa->email = $request->input('email');
        $pessoa->telefone = $request->input('telefone');
        $pessoa->municipio_id = $request->input('municipio_id');
        $pessoa->save();

        $hoje = Carbon::now();
        $data_nasc = Carbon::createFromDate($request->input('data_nascimento'));
        $idade_paciente = $hoje->diffInYears($data_nasc);

        $faixa_etaria_id = FaixaEtaria::query()->where('idade_min', '<', $idade_paciente)
                                                ->where('idade_max', '>', $idade_paciente)
                                                ->get('id')[0]['id'];

        $paciente = new Paciente();
        $paciente->faixa_etaria_id = $faixa_etaria_id;

        $pessoa->paciente()->save($paciente);

        return response()->json($pessoa, 201);
    }

    /**
     * @OA\Get(
     *     path="/paciente/{paciente_id}",
     *     tags={"paciente"},
     *     summary="Listar paciente",
     *     description="Retorna os dados do paciente cujo id foi passado na url.",
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
     *                      property="pessoa_id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="faixa_etaria_id",
     *                      type="integer",
     *                      example="4"
     *                  ),
     *                  @OA\Property(
     *                      property="deleted_at",
     *                      type="string",
     *                      format="date-time"
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
     *                      property="pessoa",
     *                      type="array",
     *                      @OA\Items(
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *                         @OA\Property(property="cpf", type="string", example="22266655544"),
     *                         @OA\Property(property="data_nascimento", type="string", format="date"),
     *                         @OA\Property(property="sexo", type="string", example="F"),
     *                         @OA\Property(property="municipio_id", type="integer", example="1"),
     *                         @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *                         @OA\Property(property="profissao", type="string", example="Professora"),
     *                         @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *                         @OA\Property(property="telefone", type="string", example="3333-6565"),
     *                         @OA\Property(property="deleted_at",type="string", format="date-time"),
     *                         @OA\Property(property="created_at",type="string", format="date-time"),
     *                         @OA\Property(property="updated_at",type="string",format="date-time"),
     *                         @OA\Property(
     *                              property="municipio",
     *                               type="array",
     *                              @OA\Items(
     *                               @OA\Property(property="id", type="integer", example="1"),
     *                               @OA\Property(property="nome", type="string", example="Assu"),
     *                               @OA\Property(property="uf_id", type="integer", example="1"),
     *                               @OA\Property(property="created_at",type="string", format="date-time"),
     *                               @OA\Property(property="updated_at",type="string",format="date-time"),
     *                               @OA\Property(
     *                                  property="uf",
     *                                  type="array",
     *                                  @OA\Items(
     *                                       @OA\Property(property="id", type="integer", example="1"),
     *                                       @OA\Property(property="nome", type="string", example="Rio Grande do Norte"),
     *                                       @OA\Property(property="sigla", type="string", example="RN"),
     *                                       @OA\Property(property="codigo_ibge", type="integer", example="24"),
     *                                       @OA\Property(property="regiao_id", type="integer", example="1"),
     *                                       @OA\Property(property="created_at",type="string", format="date-time"),
     *                                       @OA\Property(property="updated_at",type="string",format="date-time"),
     *                                  )
     *                              )
     *                          )
     *                      )
     *                  )
     *               ),
     *              @OA\Property(
     *                  property="faixa_etaria",
     *                  type="array",
     *                  @OA\Items(
     *                       @OA\Property(property="id", type="integer", example="4"),
     *                       @OA\Property(property="classe", type="string", example="36-50"),
     *                       @OA\Property(property="idade_min", type="integer", example="36"),
     *                       @OA\Property(property="idade_max", type="integer", example="50"),
     *                      )
     *                 ),
     *             ),
     *          )
     *     )
     * )
     */
    public function show($id)
    {
        $paciente = Paciente::query()
                                    ->with('pessoa')
                                    ->with('faixaEtaria')
                                    ->with(['pessoa.municipio'])
                                    ->with(['pessoa.municipio.uf'])
                                    ->where('id', $id)->get();

        if(sizeof($paciente)===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        return response()->json($paciente);
    }

    /**
     * @OA\Put (
     *     path="/paciente/{paciente_id}",
     *     tags={"paciente"},
     *     summary="Atualizar paciente",
     *     description="Atualiza os dados do paciente. Retorna o paciente atualizado.",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="paciente_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Registro atualizado com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="pessoa_id",
     *                      type="integer",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="faixa_etaria_id",
     *                      type="integer",
     *                      example="4"
     *                  ),
     *                  @OA\Property(
     *                      property="deleted_at",
     *                      type="string",
     *                      format="date-time"
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
     *                      property="pessoa",
     *                      type="array",
     *                      @OA\Items(
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="nome", type="string", example="Juliana Souza da Costa"),
     *                         @OA\Property(property="cpf", type="string", example="22266655544"),
     *                         @OA\Property(property="data_nascimento", type="string", format="date"),
     *                         @OA\Property(property="sexo", type="string", example="F"),
     *                         @OA\Property(property="municipio_id", type="integer", example="1"),
     *                         @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *                         @OA\Property(property="profissao", type="string", example="Professora"),
     *                         @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *                         @OA\Property(property="telefone", type="string", example="3333-6565"),
     *                         @OA\Property(property="deleted_at",type="string", format="date-time"),
     *                         @OA\Property(property="created_at",type="string", format="date-time"),
     *                         @OA\Property(property="updated_at",type="string",format="date-time"),
     *                      )
     *                  ),
     *             ),
     *          )
     *     ),
     *      @OA\Response(
     *         response="401",
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Registro não encontrado"
     *     ),
     *     @OA\RequestBody(
     *         description="Atualizar paciente",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","cpf", "data_nascimento", "sexo", "municipio_id"},
     *          @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *          @OA\Property(property="cpf", type="string", example="22266655544"),
     *          @OA\Property(property="data_nascimento", type="string", format="date"),
     *          @OA\Property(property="sexo", type="string", example="F"),
     *          @OA\Property(property="municipio_id", type="integer", example="1"),
     *          @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *          @OA\Property(property="profissao", type="string", example="Professora"),
     *          @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *          @OA\Property(property="telefone", type="string", example="3333-6565"),
     *         ),
     *     ),
     *    )
     *  )
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::query()->where('id', $id);

        if(sizeof($paciente->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $pessoa_id = $paciente->get()[0]['pessoa_id'];

        $pessoa = new Pessoa();
        $pessoa->nome = $request->input('nome');
        $pessoa->cpf = $request->input('cpf');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->sexo = $request->input('sexo');
        $pessoa->endereco = $request->input('endereco');
        $pessoa->profissao = $request->input('profissao');
        $pessoa->email = $request->input('email');
        $pessoa->telefone = $request->input('telefone');
        $pessoa->municipio_id = $request->input('municipio_id');

        $hoje = Carbon::now();
        $data_nasc = Carbon::createFromDate($request->input('data_nascimento'));
        $idade_paciente = $hoje->diffInYears($data_nasc);

        $faixa_etaria_id = FaixaEtaria::query()->where('idade_min', '<', $idade_paciente)
            ->where('idade_max', '>', $idade_paciente)
            ->get('id')[0]['id'];

        $pacienteAlteracao = new Paciente();
        $pacienteAlteracao->faixa_etaria_id = $faixa_etaria_id;
        $paciente->update($pacienteAlteracao->toArray());

        Pessoa::query()->where('id', $pessoa_id)->update($pessoa->toArray());

        $paciente = Paciente::query()->where('id', $id)->with('pessoa')->get();
        return response()->json($paciente);
    }

    /**
     * @OA\Delete (
     *     path="/paciente/{paciente_id}",
     *     tags={"paciente"},
     *     summary="Deletar paciente",
     *     description="Deleta o paciente cujo id foi passado pela url.",
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
    public function destroy($id)
    {
        $paciente = Paciente::query()->where("id", $id);

        if(sizeof($paciente->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }
        $paciente->delete();
    }
}

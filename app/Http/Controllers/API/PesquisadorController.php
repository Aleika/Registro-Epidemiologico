<?php

namespace App\Http\Controllers\API;

use App\Models\Pesquisador;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PesquisadorController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *     path="/pesquisador?token=",
     *     tags={"pesquisador"},
     *     summary="Lista de pesquisadores",
     *     description="Retorna uma lista com os pesquisadores cadastrados.",
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
     *                  @OA\Property(property="pessoa_id",type="integer",example="1"),
     *                  @OA\Property(property="CRM",type="integer",example="273647-7"),
     *                  @OA\Property(property="perfil",type="string",example="Médico"),
     *                  @OA\Property(property="especialidade",type="string",example="Oftalmologista"),
     *                  @OA\Property(property="deleted_at",type="string",format="date-time"),
     *                  @OA\Property( property="created_at",type="string",format="date-time"),
     *                  @OA\Property( property="updated_at",type="string",format="date-time"),
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
     *             ),
     *          )
     *     )
     * )
     */
    public function index()
    {
        $pesquisadores = Pesquisador::query()->with(['pessoa'])
            ->with(['pessoa.municipio'])->with(['pessoa.municipio.uf'])->get();
        return response()->json($pesquisadores);
    }

    /**
     * @OA\Post(
     *     path="/pesquisador?token=",
     *     tags={"pesquisador"},
     *     summary="Cadastrar pesquisador",
     *     description="Cadastra pesquisador. Retorna o pesquisador cadastrado.",
     *     operationId="store",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="201",
     *         description="Registro cadastrado com sucesso",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer",example="1"),
     *                  @OA\Property(property="pessoa_id",type="integer",example="1"),
     *                  @OA\Property(property="CRM",type="integer",example="273647-7"),
     *                  @OA\Property(property="perfil",type="string",example="Médico"),
     *                  @OA\Property(property="especialidade",type="string",example="Oftalmologista"),
     *                  @OA\Property( property="created_at",type="string",format="date-time"),
     *                  @OA\Property( property="updated_at",type="string",format="date-time"),
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
     *         description="Cadastrar novo pesquisador",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","cpf", "data_nascimento", "sexo", "municipio_id", "CRM", "perfil"},
     *           @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *           @OA\Property(property="cpf", type="string", example="22266655544"),
     *           @OA\Property(property="data_nacimento", type="string", format="date"),
     *           @OA\Property(property="sexo", type="string", example="F"),
     *           @OA\Property(property="municipio_id", type="integer", example="1"),
     *           @OA\Property(property="CRM",type="integer",example="273647-7"),
     *           @OA\Property(property="perfil",type="string",example="Médico"),
     *           @OA\Property(property="especialidade",type="string",example="Oftalmologista"),
     *           @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *           @OA\Property(property="profissao", type="string", example="Professora"),
     *           @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *           @OA\Property(property="telefone", type="string", example="3333-6565"),
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

        $pesquisador = new Pesquisador();
        $pesquisador->CRM = $request->input('CRM');
        $pesquisador->perfil = $request->input('perfil');
        $pesquisador->especialidade = $request->input('especialidade');
        $pessoa->pesquisador()->save($pesquisador);

        return response()->json($pesquisador, 201);
    }

    /**
     * @OA\Get(
     *     path="/pesquisador/{pesquisador_id}?token=",
     *     tags={"pesquisador"},
     *     summary="Listar pesquisador",
     *     description="Retorna os dados do pesquisador cujo id foi passado pela url.",
     *     operationId="show",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="pesquisador_id",
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
     *                  @OA\Property(property="id",type="integer",example="1"),
     *                  @OA\Property(property="pessoa_id",type="integer",example="1"),
     *                  @OA\Property(property="CRM",type="integer",example="273647-7"),
     *                  @OA\Property(property="perfil",type="string",example="Médico"),
     *                  @OA\Property(property="especialidade",type="string",example="Oftalmologista"),
     *                  @OA\Property(property="deleted_at",type="string",format="date-time"),
     *                  @OA\Property( property="created_at",type="string",format="date-time"),
     *                  @OA\Property( property="updated_at",type="string",format="date-time"),
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
     *             ),
     *          )
     *     )
     * )
     */
    public function show($id)
    {
        $pesquisador = Pesquisador::query()->where('id', $id)
            ->with(['pessoa'])
            ->with(['pessoa.municipio'])
            ->with(['pessoa.municipio.uf'])->get();

        if(sizeof($pesquisador)===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        return response()->json($pesquisador);
    }

    /**
     * @OA\Put(
     *     path="/pesquisador/{pesquisador_id}?token=",
     *     tags={"pesquisador"},
     *     summary="Atualizar pesquisador",
     *     description="Atualiza os dados do pesquisador cujo id foi passado pela url. Retorna o pesquisador atualizado.",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="pesquisador_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Registro atualizado com sucesso",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id",type="integer",example="1"),
     *                  @OA\Property(property="pessoa_id",type="integer",example="1"),
     *                  @OA\Property(property="CRM",type="integer",example="273647-7"),
     *                  @OA\Property(property="perfil",type="string",example="Médico"),
     *                  @OA\Property(property="especialidade",type="string",example="Oftalmologista"),
     *                  @OA\Property(property="deleted_at",type="string",format="date-time"),
     *                  @OA\Property( property="created_at",type="string",format="date-time"),
     *                  @OA\Property( property="updated_at",type="string",format="date-time"),
     *                  @OA\Property(
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
     *                      )
     *                  )
     *              )
     *          ),
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
     *         description="atualizar pesquisador",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"nome","cpf", "data_nascimento", "sexo", "municipio_id", "CRM", "perfil"},
     *           @OA\Property(property="nome", type="string", example="Juliana Souza"),
     *           @OA\Property(property="cpf", type="string", example="22266655544"),
     *           @OA\Property(property="data_nacimento", type="string", format="date"),
     *           @OA\Property(property="sexo", type="string", example="F"),
     *           @OA\Property(property="municipio_id", type="integer", example="1"),
     *           @OA\Property(property="CRM",type="integer",example="273647-7"),
     *           @OA\Property(property="perfil",type="string",example="Médico"),
     *           @OA\Property(property="especialidade",type="string",example="Oftalmologista"),
     *           @OA\Property(property="endereco", type="string", example="Rua Vereador Aldo"),
     *           @OA\Property(property="profissao", type="string", example="Professora"),
     *           @OA\Property(property="email", type="string", format="email",example="juliana@email.com"),
     *           @OA\Property(property="telefone", type="string", example="3333-6565"),
     *         ),
     *     ),
     *    )
     *  )
     */
    public function update(Request $request, $id)
    {
        $pesquisador = Pesquisador::query()->where('id', $id);

        if(sizeof($pesquisador->get())===0){
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $pessoa_id = $pesquisador->get()[0]['pessoa_id'];

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

        $pesquisador = new Pesquisador();
        $pesquisador->CRM = $request->input('CRM');
        $pesquisador->perfil = $request->input('perfil');
        $pesquisador->especialidade = $request->input('especialidade');

        Pessoa::query()->where('id', $pessoa_id)->update($pessoa->toArray());
        $pesquisador_atualizar = Pesquisador::query()->where('id', $id);
        $pesquisador_atualizar->update($pesquisador->toArray());

         return response()->json($pesquisador_atualizar->with('pessoa')->get());
    }

    /**
     * @OA\Delete (
     *     path="/pesquisador/{pesquisador_id}?token=",
     *     tags={"pesquisador"},
     *     summary="Remover pesquisador",
     *     description="Remover o pesquisador cujo id foi passado pela url.",
     *     operationId="destroy",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="pesquisador_id",
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
     *    )
     *  )
     */
    public function destroy($id)
    {
        $pesquisador = Pesquisador::query()->where('id', $id);

        if(sizeof($pesquisador->get()) === 0) {
            return response()->json(['erro'=> 'Registro não encontrado'], 404);
        }

        $pesquisador->delete();
    }
}

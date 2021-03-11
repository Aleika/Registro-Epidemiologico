<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"autenticacao"},
     *     summary="Registra o login do usuário",
     *     description="Faz o login do autenticado para que ele possa ter acesso às funcionalidades que precisam de autenticação. Retorna os dados de acesso.",
     *     operationId="login",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         description="Registra o login do usuário",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"email", "password"},
     *                  @OA\Property(property="email",type="email",example="juliana@email.com"),
     *                  @OA\Property(property="password",type="integer",example="1234"),
     *           ),
     *       ),
     *   @OA\Response(
     *         response="401",
     *         description="Usuário não autorizado"
     *     ),
     *    @OA\Response(
     *         response="400",
     *         description="Erros de validação dos campos passados no request."
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="token",type="string",example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
     *                  eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYxNTMwODQ3OCwi
     *                  ZXhwIjoxNjE1Mzk0ODc4LCJuYmYiOjE2MTUzMDg0NzgsImp0aSI6Ikdwb3Y4UDZhRWszNnJwT24iLCJzdWIiOjMsInBy
     *                  diI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.dQ6TIYmYo25Neveic_BB6-xEno-2BQ1n2pca0oJfyDs"),
     *                  @OA\Property(property="token_type",type="string",example="bearer"),
     *                  @OA\Property(property="token_validity",type="integer",example="86400"),
     *              ),
     *          )
     *     )
     * )
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(),
        [
            'email' => 'required|email',
            'password' => 'required'
        ]
        );

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $token_validity = 24 * 60;
        $this->guard()->factory()->setTTL($token_validity);

        $token = $this->guard()->attempt($validator->validate());

        if(!$token){
            return response()->json(['erro' => 'Usuário não autorizado'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"autenticacao"},
     *     summary="Cadastra novo usuário",
     *     description="Realiza o cadastro do usuário e retorna os dados cadastrados.",
     *     operationId="register",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         description="Cadastra o usuário",
     *         required=true,
     *         @OA\JsonContent(
     *          required={"email", "password"},
     *                  @OA\Property(property="nome",type="string",example="Juliana Alves"),
     *                  @OA\Property(property="email",type="email",example="juliana@email.com"),
     *                  @OA\Property(property="password",type="integer",example="1234"),
     *           ),
     *       ),
     *   @OA\Response(
     *         response="401",
     *         description="Usuário não autorizado"
     *     ),
     *    @OA\Response(
     *         response="400",
     *         description="Erros de validação dos campos passados no request."
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(property="nome",type="string",example="Juliana Alves"),
     *                 @OA\Property(property="email",type="email",example="juliana@email.com"),
     *                 @OA\Property(property="id",type="integer",example="1"),
     *                 @OA\Property(property="created_at",type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string",format="date-time"),
     *              ),
     *          )
     *     )
     * )
     */
    public function register(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json(['erro'=>$validator->errors()], 401);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"autenticacao"},
     *     summary="Faz o logout do usuário",
     *     description="Realiza o logout do usuário.",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(property="message",type="string",example="Usuário deslogado"),
     *              ),
     *          )
     *     )
     * )
     */
    public function logout(){
        $this->guard()->logout();
        return response()->json([
            'message' => 'Usuário deslogado'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/auth/profle",
     *     tags={"autenticacao"},
     *     summary="Retorna usuário.",
     *     description="Retorna os dados do susuário logado.",
     *     operationId="profile",
     *     security={{"bearerAuth":{}}},
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(property="nome",type="string",example="Juliana Alves"),
     *                 @OA\Property(property="email",type="email",example="juliana@email.com"),
     *                 @OA\Property(property="id",type="integer",example="1"),
     *                 @OA\Property(property="created_at",type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string",format="date-time"),
     *              ),
     *          )
     *     )
     * )
     */
    public function profile(){
        return response()->json($this->guard()->user());
    }

    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     tags={"autenticacao"},
     *     summary="Atualiza token",
     *     description="Atualiza os dados de acesso do usuário logado. Retorna os dados de acesso.",
     *     operationId="refresh",
     *     security={{"bearerAuth":{}}},
     *   @OA\Response(
     *         response="401",
     *         description="Usuário não autorizado"
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="token",type="string",example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.
     *                  eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYxNTMwODQ3OCwi
     *                  ZXhwIjoxNjE1Mzk0ODc4LCJuYmYiOjE2MTUzMDg0NzgsImp0aSI6Ikdwb3Y4UDZhRWszNnJwT24iLCJzdWIiOjMsInBy
     *                  diI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.dQ6TIYmYo25Neveic_BB6-xEno-2BQ1n2pca0oJfyDs"),
     *                  @OA\Property(property="token_type",type="string",example="bearer"),
     *                  @OA\Property(property="token_validity",type="integer",example="86400"),
     *              ),
     *          )
     *     )
     * )
     */
    public function refresh(){
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token){
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
    protected function guard(){
        return Auth::guard();
    }
}


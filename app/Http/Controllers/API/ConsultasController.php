<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exports;
use Excel;

class ConsultasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/modulo_transparencia",
     *     tags={"módulo transparência"},
     *     summary="Consulta agregada",
     *     description="Retorna uma lista com a quantidade de pacientes cadastrados, agrupando por Doença, UF, Município, Faixa etária e Sexo",
     *     operationId="consultaAgregada",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="UF",type="integer",example="1"),
     *                  @OA\Property(property="nome_uf",type="string",example="Rio Grande do Norte"),
     *                  @OA\Property(property="municipio",type="integer",example="1"),
     *                  @OA\Property(property="nome_municipio",type="string",example="Natal"),
     *                  @OA\Property(property="faixa_etaria",type="integer",example="4"),
     *                  @OA\Property(property="idade_minima_da_faixa",type="integer",example="36"),
     *                  @OA\Property(property="classe_faixa_etaria",type="string",example="36-50"),
     *                  @OA\Property(property="sexo",type="string",example="F"),
     *              ),
     *          )
     *     )
     * )
     */
    public function consultaAgregada()
    {
        $query = $this->select();

        $query = $query . $this->groupBy();

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/filtrada?doenca={doenca_id}&uf={uf_id}&municipio={municipio_id}&faixaetaria={faixa_etaria_id}&sexo={sexo}",
     *     tags={"módulo transparência"},
     *     summary="Consulta filtrada",
     *     description="Retorna uma lista com a quantidade de pacientes cadastrados filtrando por qualquer combinação de Doença, UF, Município, Faixa etária e Sexo, conforme
        informado na critério de filtro da API. O valor do sexo deve ser 'F' ou 'M'.",
     *     operationId="consultaFiltrada",
     *    @OA\Parameter(
     *         name="doenca_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="uf_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="municipio_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="faixa_etaria_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sexo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="char"
     *         )
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="UF",type="integer",example="1"),
     *                  @OA\Property(property="nome_uf",type="string",example="Rio Grande do Norte"),
     *                  @OA\Property(property="municipio",type="integer",example="1"),
     *                  @OA\Property(property="nome_municipio",type="string",example="Natal"),
     *                  @OA\Property(property="faixa_etaria",type="integer",example="4"),
     *                  @OA\Property(property="idade_minima_da_faixa",type="integer",example="36"),
     *                  @OA\Property(property="classe_faixa_etaria",type="string",example="36-50"),
     *                  @OA\Property(property="sexo",type="string",example="F"),
     *              ),
     *          )
     *     )
     * )
     */
    public function consultaFiltrada(Request $request)
    {
        $doenca = $request->input('doenca');
        $uf = $request->input('uf');
        $municipio = $request->input('municipio');
        $faixa_etaria = $request->input('faixa_etaria');
        $sexo = $request->input('sexo');

        $query = $this->select();

        $query = $this->where($doenca, $uf, $municipio, $faixa_etaria, $sexo, $query);

        $query = $query . $this->groupBy();

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/ordenada?doenca={doenca_id}&doencaordem={doenca_ordem}&uf={ud_id}&ufordem={uf_ordem}&municipio={municipio_id}&municipioordem= {municipio_ordem}
     &faixaetaria={faixa_etaria_id}&$faixaetariaordem={$faixa_etaria_ordem}&sexo={sexo}&sexoordem={sexo_ordem}",
     *     tags={"módulo transparência"},
     *     summary="Consulta Ordenada",
     *     description="Retorna uma lista com a quantidade de pacientes cadastrados filtrando por qualquer combinação de Doença, UF, Município, Faixa etária e Sexo, conforme
    informado no critério de filtro da API. Os parâmetros doenca_ordem, uf_ordem, municipio_ordem, faixa_etaria_ordem e sexo_ordem dever ser 'ASC' ou 'DESC'. Caso a ordem seja nula, ou seja
    não for informada para algum dos parâmetros, a consulta não irá ordenar pelo parâmetro não informado. O valor do sexo deve ser 'F' ou 'M'.",
     *     operationId="consultaOrdenada",
     *    @OA\Parameter(
     *         name="doenca_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="uf_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="municipio_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="faixa_etaria_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sexo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="char"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="doenca_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="uf_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="municipio_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="faixa_etaria_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sexo_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="UF",type="integer",example="1"),
     *                  @OA\Property(property="nome_uf",type="string",example="Rio Grande do Norte"),
     *                  @OA\Property(property="municipio",type="integer",example="1"),
     *                  @OA\Property(property="nome_municipio",type="string",example="Natal"),
     *                  @OA\Property(property="faixa_etaria",type="integer",example="4"),
     *                  @OA\Property(property="idade_minima_da_faixa",type="integer",example="36"),
     *                  @OA\Property(property="classe_faixa_etaria",type="string",example="36-50"),
     *                  @OA\Property(property="sexo",type="string",example="F"),
     *              ),
     *          )
     *     )
     * )
     */
    public function consultaOrdenada(Request $request)
    {

        $doenca = $request->input('doenca');
        $uf = $request->input('uf');
        $municipio = $request->input('municipio');
        $faixa_etaria = $request->input('faixaetaria');
        $sexo = $request->input('sexo');

        $doenca_ordem = $request->input('doencaordem');
        $uf_ordem = $request->input('ufordem');
        $municipio_ordem = $request->input('municipioordem');
        $faixa_etaria_ordem = $request->input('faixaetariaordem');
        $sexo_ordem = $request->input('sexoordem');

        $query = $this->select();

        $query = $this->where($doenca, $uf, $municipio, $faixa_etaria, $sexo, $query);

        $query = $query .  $this->groupBy();

        $query = $query . ' ORDER BY true ';

        if(!empty($doenca_ordem)){
          $query =  $query . ', d.nome ' . $doenca_ordem ;
        }

        if(!empty($uf_ordem)){
            $query =  $query . ', ufs.nome ' . $uf_ordem;
        }

        if(!empty($municipio_ordem)){
            $query =  $query . ', mu.nome ' . $municipio_ordem;
        }

        if(!empty($faixa_etaria_ordem)){
            $query =  $query . ', fe.idade_min ' . $faixa_etaria_ordem;
        }

        if(!empty($sexo_ordem)){
            $query =  $query . ', pe.sexo ' . $sexo_ordem;
        }

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/agregado/doenca",
     *     tags={"módulo transparência"},
     *     summary="Consulta agregada por doença",
     *     description="Retorna uma lista agrupada por doença e com a quantidade de pessoas registradas com cada doença.",
     *     operationId="agregadoDoenca",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *              ),
     *          )
     *     )
     * )
     */
    public function agregadoDoenca(){
        $query = 'SELECT d.id AS "doenca_id", d.nome AS "nome_doenca" , COUNT(pa.id) AS "quantidade_pacientes" ';
        $query = $query . ' FROM paciente_doencas pd ';
        $query = $query . ' INNER JOIN pacientes pa ON pa.id = pd.paciente_id ' ;
        $query = $query . ' INNER JOIN doencas d ON d.id = pd.doenca_id  ' ;
        $query = $query . ' GROUP BY (d.id);' ;

        $result = DB::select( DB::raw($query));

        return response()->json($result);

    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/agregado/doenca/uf",
     *     tags={"módulo transparência"},
     *     summary="Consulta agregada por doença e UF",
     *     description="Retorna uma lista agrupada por doença e UF, com a quantidade de pessoas registradas com cada doença e UF.",
     *     operationId="agregadoDoencaUF",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="uf_id",type="integer",example="1"),
     *                  @OA\Property(property="nome_uf",type="string",example="Rio Grande do Norte"),
     *              ),
     *          )
     *     )
     * )
     */
    public function agregadoDoencaUF(){
        $query = 'SELECT d.id AS "doenca_id", d.nome AS "nome_doenca" , ufs.id AS "uf_id", ufs.nome as "nome_uf", ';
        $query = $query . ' COUNT(pa.id) AS "quantidade_pacientes" ';
        $query = $query . ' FROM paciente_doencas pd ';
        $query = $query . ' INNER JOIN pacientes pa ON pa.id = pd.paciente_id ' ;
        $query = $query . ' INNER JOIN doencas d ON d.id = pd.doenca_id  ' ;
        $query = $query . ' INNER JOIN pessoas pe ON pe.id = pa.pessoa_id  ' ;
        $query = $query . ' INNER JOIN municipios mu ON mu.id = pe.municipio_id  ' ;
        $query = $query . ' INNER JOIN ufs ON ufs.id = mu.uf_id  ' ;
        $query = $query . ' GROUP BY d.id, ufs.id ;' ;

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/agregado/doenca/faixa_etaria",
     *     tags={"módulo transparência"},
     *     summary="Consulta agregada por doença e faixa etária",
     *     description="Retorna uma lista agrupada por doença e faixa etária e conta a quantidade de pessoas registradas com cada doença e faixa etária.",
     *     operationId="agregadoDoencaFaixaEtaria",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="faixa_etaria_id",type="integer",example="1"),
     *                  @OA\Property(property="classe_faixa_etaria",type="string",example="36-50"),
     *              ),
     *          )
     *     )
     * )
     */
    public function agregadoDoencaFaixaEtaria(){
        $query = 'SELECT d.id AS "doenca_id", d.nome AS "nome_doenca" , fe.id AS "faixa_etaria_id", fe.classe AS "classe_faixa_etaria", ';
        $query = $query . ' COUNT(pa.id) AS "quantidade_pacientes" ';
        $query = $query . ' FROM paciente_doencas pd ';
        $query = $query . ' INNER JOIN pacientes pa ON pa.id = pd.paciente_id ' ;
        $query = $query . ' INNER JOIN doencas d ON d.id = pd.doenca_id  ' ;
        $query = $query . ' INNER JOIN faixa_etarias fe ON fe.id = pa.faixa_etaria_id  ' ;
        $query = $query . ' GROUP BY d.id, fe.id ;' ;

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/agregado/doenca/sexo/faixa_etaria",
     *     tags={"módulo transparência"},
     *     summary="Consulta agregada por doença, faixa etária e sexo",
     *     description="Retorna uma lista agrupada por doença, sexo e faixa etária e conta a quantidade de pessoas registradas com cada doença, sexo e faixa etária",
     *     operationId="agregadoDoencaSexoFaixaEtaria",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="faixa_etaria_id",type="integer",example="1"),
     *                  @OA\Property(property="classe_faixa_etaria",type="string",example="36-50"),
     *                  @OA\Property(property="sexo",type="char",example="F"),
     *              ),
     *          )
     *     )
     * )
     */
    public function agregadoDoencaSexoFaixaEtaria(){
        $query = 'SELECT d.id AS "doenca_id", d.nome AS "nome_doenca" , fe.id AS "id_faixa_etaria", fe.classe AS "classe_faixa_etaria", ';
        $query = $query . ' pe.sexo, COUNT(pa.id) AS "quantidade_pacientes" ';
        $query = $query . ' FROM paciente_doencas pd ';
        $query = $query . ' INNER JOIN pacientes pa ON pa.id = pd.paciente_id ' ;
        $query = $query . ' INNER JOIN doencas d ON d.id = pd.doenca_id  ' ;
        $query = $query . ' INNER JOIN pessoas pe ON pe.id = pa.pessoa_id  ' ;
        $query = $query . ' INNER JOIN faixa_etarias fe ON fe.id = pa.faixa_etaria_id  ' ;
        $query = $query . ' GROUP BY d.id, pe.sexo, fe.id ;' ;

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/agregado/doenca/sexo",
     *     tags={"módulo transparência"},
     *     summary="Consulta agregada por doença e sexo",
     *     description="Retorna uma lista agrupada por doença e sexo e conta a quantidade de pessoas registradas com cada doença e sexo",
     *     operationId="agregadoDoencaSexo",
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca_id",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="sexo",type="char",example="F"),
     *              ),
     *          )
     *     )
     * )
     */
    public function agregadoDoencaSexo(){
        $query = 'SELECT d.id AS "doenca_id", d.nome AS "nome_doenca" ,  ';
        $query = $query . ' pe.sexo, COUNT(pa.id) AS "quantidade_pacientes" ';
        $query = $query . ' FROM paciente_doencas pd ';
        $query = $query . ' INNER JOIN pacientes pa ON pa.id = pd.paciente_id ' ;
        $query = $query . ' INNER JOIN doencas d ON d.id = pd.doenca_id  ' ;
        $query = $query . ' INNER JOIN pessoas pe ON pe.id = pa.pessoa_id  ' ;
        $query = $query . ' GROUP BY d.id, pe.sexo ;' ;

        $result = DB::select( DB::raw($query));

        return response()->json($result);
    }

    public function select(){
        $query = 'select count(pe.id) as "quantidade_pacientes", d.id as "doenca", d.nome as "nome_doenca", ufs.id as "UF", ufs.nome as "nome_uf", ';
        $query = $query . ' mu.id as "municipio", mu.nome as "nome_municipio", fe.id as "faixa_etaria", fe.idade_min as "idade_minima_da_faixa", ';
        $query = $query . ' fe.classe as "classe_faixa_etaria", pe.sexo as "sexo" ';
        $query = $query . ' from paciente_doencas pd ';
        $query = $query . ' inner join pacientes pa on pa.id = pd.paciente_id ';
        $query = $query . ' inner join doencas d on d.id = pd.doenca_id ';
        $query = $query . ' inner join pessoas pe on pe.id = pa.pessoa_id ';
        $query = $query . ' inner join municipios mu on mu.id = pe.municipio_id ';
        $query = $query . ' inner join ufs on ufs.id = mu.uf_id ';
        $query = $query . ' inner join faixa_etarias fe on fe.id = pa.faixa_etaria_id ';
        $query = $query . ' WHERE true ';
        return $query;
    }
    public function where($doenca,$uf,$municipio, $faixa_etaria, $sexo, $query){

        if(!empty($doenca)){
            $query = $query . ' and d.id = ' . $doenca;
        }
        if(!empty($uf)){
            $query = $query . ' and ufs.id = ' . $uf ;
        }
        if(!empty($municipio)){
            $query = $query . ' and mu.id = ' . $municipio;
        }
        if(!empty($faixa_etaria)){
            $query = $query . ' and fe.id = ' . $faixa_etaria;
        }
        if(!empty($sexo)){
            $query = $query . ' and pe.sexo = \'' . $sexo . '\'';
        }
        return $query;
    }

    public function groupBy(){
        return  ' group by (d.id, ufs.id, mu.id, fe.id, pe.sexo) ';
    }

    /**
     * @OA\Get(
     *     path="/modulo_transparencia/ordenada/export-csv?doenca={doenca_id}&doencaordem={doenca_ordem}&uf={ud_id}&ufordem={uf_ordem}&municipio={municipio_id}&municipioordem= {municipio_ordem}
    &faixaetaria={faixa_etaria_id}&$faixaetariaordem={$faixa_etaria_ordem}&sexo={sexo}&sexoordem={sexo_ordem}",
     *     tags={"módulo transparência"},
     *     summary="Consulta Ordenada - CSV",
     *     description="Retorna um .csv com a quantidade de pacientes cadastrados filtrando por qualquer combinação de Doença, UF, Município, Faixa etária e Sexo, conforme
    informado no critério de filtro da API. Os parâmetros doenca_ordem, uf_ordem, municipio_ordem, faixa_etaria_ordem e sexo_ordem dever ser 'ASC' ou 'DESC'. Caso a ordem seja nula, ou seja
    não for informada para algum dos parâmetros, a consulta não irá ordenar pelo parâmetro não informado. O valor do sexo deve ser 'F' ou 'M'.",
     *     operationId="exportIntoCSV",
     *    @OA\Parameter(
     *         name="doenca_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="uf_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="municipio_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="faixa_etaria_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sexo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="char"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="doenca_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="uf_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="municipio_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="faixa_etaria_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sexo_ordem",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *          response=200,
     *          description="Operação realizada com sucesso",
     *          @OA\MediaType(
     *              mediaType="text/plain",
     *              @OA\Schema(
     *                  @OA\Property(property="quantidade_pacientes",type="integer",example="4"),
     *                  @OA\Property(property="doenca",type="integer",example="1"),
     *                  @OA\Property(property="nome_doenca",type="string",example="Esclerose Lateral Amiotrófica - ELA"),
     *                  @OA\Property(property="UF",type="integer",example="1"),
     *                  @OA\Property(property="nome_uf",type="string",example="Rio Grande do Norte"),
     *                  @OA\Property(property="municipio",type="integer",example="1"),
     *                  @OA\Property(property="nome_municipio",type="string",example="Natal"),
     *                  @OA\Property(property="faixa_etaria",type="integer",example="4"),
     *                  @OA\Property(property="idade_minima_da_faixa",type="integer",example="36"),
     *                  @OA\Property(property="classe_faixa_etaria",type="string",example="36-50"),
     *                  @OA\Property(property="sexo",type="string",example="F"),
     *              ),
     *          )
     *     )
     * )
     */
    public function exportIntoCSV(Request $request){
        $doenca = $request->input('doenca');
        $uf = $request->input('uf');
        $municipio = $request->input('municipio');
        $faixa_etaria = $request->input('faixaetaria');
        $sexo = $request->input('sexo');

        $doenca_ordem = $request->input('doencaordem');
        $uf_ordem = $request->input('ufordem');
        $municipio_ordem = $request->input('municipioordem');
        $faixa_etaria_ordem = $request->input('faixaetariaordem');
        $sexo_ordem = $request->input('sexoordem');

        return Excel::download(new Exports\ConsultaExport($doenca, $doenca_ordem, $uf, $uf_ordem,$municipio, $municipio_ordem, $faixa_etaria, $faixa_etaria_ordem, $sexo, $sexo_ordem), 'consulta_ordenada.csv');
    }
}

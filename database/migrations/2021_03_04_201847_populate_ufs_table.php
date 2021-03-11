<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class PopulateUfsTablee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('ufs')->insert([
            ['nome' => 'Acre', 'sigla' => 'AC', 'codigo_ibge' => 12, 'region_id' => 2],
            ['nome' => 'Alagoas', 'sigla' => 'AL', 'codigo_ibge' => 27 , 'region_id' => 1],
            ['name' => 'Amapá', 'sigla' => 'AP', 'codigo_ibge'=> 16, 'region_id' => 2],
            ['name' => 'Amazonas', 'sigla' => 'AM','codigo_ibge'=> 13, 'region_id' => 2],
            ['name' => 'Bahia', 'sigla' => 'BA','codigo_ibge'=> 29, 'region_id' => 1],
            ['name' => 'Ceará', 'sigla' => 'CE','codigo_ibge'=> 23, 'region_id' => 1],
            ['name' => 'Distrito Federal', 'sigla' => 'DF','codigo_ibge'=> 53, 'region_id' => 5],
            ['name' => 'Espírito Santo', 'sigla' => 'ES','codigo_ibge'=> 32, 'region_id' => 4],
            ['name' => 'Goiás', 'sigla' => 'GO','codigo_ibge'=> 52, 'region_id' => 5],
            ['name' => 'Maranhão', 'sigla' => 'MA','codigo_ibge'=> 21, 'region_id' => 1],
            ['name' => 'Mato Grosso', 'sigla' => 'MT','codigo_ibge'=> 51, 'region_id' => 5],
            ['name' => 'Mato Grosso do Sul', 'sigla' => 'MS','codigo_ibge'=> 50, 'region_id' => 5],
            ['name' => 'Minas Gerais', 'sigla' => 'MG','codigo_ibge'=> 31, 'region_id' => 4],
            ['name' => 'Pará', 'sigla' => 'PA','codigo_ibge'=> 15, 'region_id' => 2],
            ['name' => 'Paraíba', 'sigla' => 'PB','codigo_ibge'=> 25, 'region_id' => 1],
            ['name' => 'Paraná', 'sigla' => 'PR','codigo_ibge'=> 41, 'region_id' => 3],
            ['name' => 'Pernambuco', 'sigla' => 'PE','codigo_ibge'=> 26, 'region_id' => 1],
            ['name' => 'Piauí', 'sigla' => 'PI','codigo_ibge'=> 22, 'region_id' => 1],
            ['name' => 'Rio de Janeiro', 'sigla' => 'RJ','codigo_ibge'=> 33, 'region_id' => 4],
            ['name' => 'Rio Grande do Norte', 'sigla' => 'RN','codigo_ibge'=> 24, 'region_id' => 1],
            ['name' => 'Rio Grande do Sul', 'sigla' => 'RS','codigo_ibge'=> 43, 'region_id' => 3],
            ['name' => 'Rondônia', 'sigla' => 'RO','codigo_ibge'=> 11, 'region_id' => 2],
            ['name' => 'Roraima', 'sigla' => 'RR','codigo_ibge'=> 14, 'region_id' => 2],
            ['name' => 'Santa Catarina', 'sigla' => 'SC','codigo_ibge'=> 42, 'region_id' => 3],
            ['name' => 'São Paulo', 'sigla' => 'SP','codigo_ibge'=> 35, 'region_id' => 4],
            ['name' => 'Sergipe', 'sigla' => 'SE','codigo_ibge'=> 28, 'region_id' => 1],
            ['name' => 'Tocantins', 'sigla' => 'TO','codigo_ibge'=> 17, 'region_id' => 2],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('ufs')->delete();
    }
}

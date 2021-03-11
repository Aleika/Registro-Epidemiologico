<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PopulateRegioesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('regioes')->insert([
            ['nome' => 'Nordeste', 'sigla' => 'NE'],
            ['nome' => 'Norte', 'sigla' => 'N'],
            ['nome' => 'Sul', 'sigla' => 'S'],
            ['nome' => 'Sudeste', 'sigla' => 'SE'],
            ['nome' => 'Centro-Oeste', 'sigla' => 'CO'],
        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('regioes')->delete();
    }
}

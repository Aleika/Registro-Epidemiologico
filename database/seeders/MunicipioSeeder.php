<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table("ufs")->insert([
            'nome' => "Rio Grande do Norte",
            'sigla' => "RN",
            'codigo_ibge' => 24,
            'regiao_id' => 1,
        ]);

        DB::table("municipios")->insert([
            [ 'nome' => "Natal", 'uf_id' => 1,],
            [ 'nome' => "Angicos", 'uf_id' => 1,],
            [ 'nome' => "Mossoro", 'uf_id' => 1,],
        ]);
    }
}

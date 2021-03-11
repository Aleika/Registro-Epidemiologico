<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegioesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regioes')->insert([
            ['nome' => 'Nordeste', 'sigla' => 'NE'],
            ['nome' => 'Norte', 'sigla' => 'N'],
            ['nome' => 'Sul', 'sigla' => 'S'],
            ['nome' => 'Sudeste', 'sigla' => 'SE'],
            ['nome' => 'Centro-Oeste', 'sigla' => 'CO'],
        ]);

    }
}

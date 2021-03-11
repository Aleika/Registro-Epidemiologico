<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaixaEtariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faixa_etarias')->insert([
            [
                'classe' => '00-18',
                'idade_min' => 0,
                'idade_max' => 18,
            ],
            [
                'classe' => '19-25',
                'idade_min' => 19,
                'idade_max' => 25,
            ],
            [
                'classe' => '26-35',
                'idade_min' => 26,
                'idade_max' => 35,
            ],
            [
                'classe' => '36-50',
                'idade_min' => 36,
                'idade_max' => 50,
            ],
            [
                'classe' => '51-60',
                'idade_min' => 51,
                'idade_max' => 60,
            ],
            [
                'classe' => '61-70',
                'idade_min' => 61,
                'idade_max' => 70,
            ],
            [
                'classe' => '71-80',
                'idade_min' => 71,
                'idade_max' => 80,
            ],
            [
                'classe' => '81-100',
                'idade_min' => 81,
                'idade_max' => 100,
            ]
        ]);
    }
}

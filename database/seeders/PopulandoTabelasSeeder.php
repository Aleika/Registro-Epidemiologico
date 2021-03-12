<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulandoTabelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('municipios')->insert([
            ['nome' => 'Natal', 'uf_id' => 20],
            ['nome' => 'Angicos', 'uf_id' => 20],
            ['nome' => 'João Pessoa', 'uf_id' => 15]
        ]);

        DB::table('pessoas')->insert([
            ['nome' => 'Maria Souza', 'cpf' => '99922233344', 'data_nascimento' => '1991-02-17',
                'sexo' => 'F', 'municipio_id' => 1, 'endereco' => 'Rua da Esperança, 65', 'profissao' => 'Enfermeira',
                'email' => 'mariasouza@email.com', 'telefone' => '3232-3232'],
            ['nome' => 'João Cardoso', 'cpf' => '11122255577', 'data_nascimento' => '1985-07-13',
                'sexo' => 'M', 'municipio_id' => 2, 'endereco' => 'Rua do Alto, 54', 'profissao' => 'Taxista',
                'email' => 'joao@email.com', 'telefone' => '5656-5656'],
            ['nome' => 'Juliana Damasceno', 'cpf' => '33355577799', 'data_nascimento' => '1995-08-06',
                'sexo' => 'M', 'municipio_id' => 3, 'endereco' => 'Av. Julio Cesar, 04', 'profissao' => 'Médica',
                'email' => 'julia@email.com', 'telefone' => '4444-5656'],
        ]);


        DB::table('pesquisadores')->insert([
            [ 'pessoa_id' => 1, 'CRM' => 'F054008', 'perfil' => 'Médico', 'especialidade' => '']
        ]);

        DB::table('pacientes')->insert([
           [ 'pessoa_id' => 2, 'faixa_etaria_id' => 3 ],
            [ 'pessoa_id' => 3, 'faixa_etaria_id' => 4 ],
        ]);

        DB::table('doencas')->insert([
            ['nome' => 'Esclerose Lateral Amiotrófica - ELA', 'descricao' => 'Afeta o sistema nervoso e acarreta paralisia motora progressiva, irreversível, de maneira limitante'],
            ['nome' => 'Síndrome de Proteus', 'descricao' => 'Rara síndrome hamartomatosa, congênita, de origem genética']
        ]);

        DB::table('paciente_doencas')->insert([
            ['doenca_id' => 1, 'paciente_id' => 1, 'data_inicio_sintomas' => '2021-01-05',
                'local_inicio_sintomas'=> 'mãe esquerda', 'data_diagnostico' => '2019-11-25', 'observacoes' => ''],
            ['doenca_id' => 2, 'paciente_id' => 2, 'data_inicio_sintomas' => '2018-05-05',
                'local_inicio_sintomas'=> 'não se aplica', 'data_diagnostico' => '2018-06-25', 'observacoes' => ''],
        ]);
    }

}

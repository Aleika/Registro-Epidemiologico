<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf', 11)->unique();
            $table->date('data_nascimento');
            $table->char('sexo', 1);
            $table->integer('municipio_id');
            $table->string('endereco')->nullable();
            $table->string('profissao')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telefone')->nullable();

            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}

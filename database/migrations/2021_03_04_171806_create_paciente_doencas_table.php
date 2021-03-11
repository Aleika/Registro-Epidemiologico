<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacienteDoencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_doencas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doenca_id');
            $table->integer('paciente_id');
            $table->date('data_inicio_sintomas');
            $table->string('local_inicio_sintomas');
            $table->date('data_diagnostico');
            $table->string('observacoes')->nullable();

            $table->foreign('doenca_id')->references('id')->on('doencas')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');

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
        Schema::dropIfExists('paciente_doencas');
    }
}

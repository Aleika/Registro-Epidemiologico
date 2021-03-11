<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesquisadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesquisadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pessoa_id');
            $table->string('CRM');
            $table->string('perfil');
            $table->string('especialidade')->nullable();

            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade');

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
        Schema::dropIfExists('pesquisadores');
    }
}

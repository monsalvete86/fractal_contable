<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdicionalesContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adicionales_contrato', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('contratos');
            $table->string('nombre');
            $table->integer('documento')->unique();
            $table->string('tipo_documento');
            $table->string('parentesco');
            $table->date('fecha_nacimiento');
            $table->integer('usu_crea')->unsigned();
            $table->foreign('usu_crea')->references('id')->on('users');
            $table->integer('usu_edita')->unsigned();
            $table->foreign('usu_edita')->references('id')->on('users');
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
        Schema::dropIfExists('adicionales_contrato');
    }
}

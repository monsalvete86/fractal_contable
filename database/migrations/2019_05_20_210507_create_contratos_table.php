<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('n_contrato')->unique();
            $table->integer('id_tercero')->unsigned();
            $table->foreign('id_tercero')->references('id')->on('personas');
            $table->string('lugar_cedula',300);
            $table->string('barrio');
            $table->string('tel');
            $table->string('cel');
            $table->integer('id_ocupacion');
            $table->string('referencias',300);
            $table->string('tel_referencia');
            $table->boolean('estado')->default(1);
            $table->date('fecha_contrato');
            $table->time('hora_contrato');
            $table->double('vr_mensual');
            $table->double('vr_semestre');
            $table->double('vr_año');
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
        Schema::dropIfExists('contratos');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoslapazTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagoslapaz', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contrato')->unsigned();
            $table->foreign('id_contrato')->references('id')->on('contratos');
            $table->date('fecha_vence');
            $table->double('valor_pago');
            $table->integer('cant_adicionales');
            $table->integer('estado');
            $table->date('fecha_pago');
            $table->string('observacion',100);
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
        Schema::dropIfExists('pagoslapaz');
    }
}

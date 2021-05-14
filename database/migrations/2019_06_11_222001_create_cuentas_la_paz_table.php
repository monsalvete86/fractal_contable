<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasLaPazTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_la_paz', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cuenta1');
            $table->integer('id_cuenta2');
            $table->integer('id_formato');
            $table->integer('usu_crea')->unsigned();
            $table->foreign('usu_crea')->references('id')->on('users');
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
        Schema::dropIfExists('cuentas_la_paz');
    }
}

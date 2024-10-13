<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', array('INGRESADO', 'CONCTATADO',"NUEVO CLIENTE"));
            $table->string('nombre', 100);
            $table->string('email', 100);
            $table->string('topic', 100);
            $table->text('mensaje');
            $table->text('conceptos');
            $table->bigInteger('user_id');
            //$table->bigInteger('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('clientes');
    }
}

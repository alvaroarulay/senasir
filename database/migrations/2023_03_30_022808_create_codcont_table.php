<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codcont', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('unidad')->unsigned();
            $table->string('nombre')->nullable();
            $table->integer('vidautil')->nullable();
            $table->string('observ')->nullable(); 
            $table->boolean('depreciar')->nullable(); 
            $table->boolean('actualizar')->nullable();
            $table->string('usuar')->nullable();
            $table->timestamps();

            $table->foreign('unidad')->references('id')->on('unidadadmin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codcont');
    }
};

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
        Schema::create('actual', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->string('codsec')->nullable();
            $table->string('codarpro')->nullable();
            $table->integer('codaux')->unsigned();
            $table->integer('vidautil')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('costo')->nullable();
            $table->integer('codresp')->unsigned();
            $table->string('observ')->nullable();
            $table->string('estado')->nullable();
            $table->string('codbien')->nullable();
            $table->string('nroconv')->nullable();
            $table->integer('orgfin')->unsigned();
            $table->string('usuar')->nullable();
            $table->integer('estadoasignacion')->default(0);
            $table->date('incorporacion')->nullable();
            $table->timestamps();

            $table->foreign('codaux')->references('id')->on('auxiliar');
            $table->foreign('codresp')->references('id')->on('resp');
            $table->foreign('orgfin')->references('id')->on('organismo_fin');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actual');
    }
};

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
        Schema::create('oficina', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('unidad')->unsigned();
            $table->string('nomofic');
            $table->string('observ')->nullable();
            $table->string('usuar');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('oficina');
    }
};

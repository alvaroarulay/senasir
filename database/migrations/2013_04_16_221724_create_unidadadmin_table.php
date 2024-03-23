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
        Schema::create('unidadadmin', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('entidad')->unsigned();
            $table->string('unidad')->nullable();
            $table->string('descrip')->nullable();
            $table->string('ciudad')->nullable();
            $table->boolean('estado')->nullable();
            $table->timestamps();

            $table->foreign('entidad')->references('id')->on('entidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidadadmin');
    }
};

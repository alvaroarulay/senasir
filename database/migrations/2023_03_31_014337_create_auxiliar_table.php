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
        Schema::create('auxiliar', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('codcont')->unsigned();
            $table->string('nomaux')->nullable();
            $table->string('observ')->nullable();
            $table->string('usuar')->nullable();
            $table->timestamps();

            $table->foreign('codcont')->references('id')->on('codcont');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auxiliar');
    }
};

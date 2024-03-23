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
        Schema::create('resp', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('codofic')->unsigned();
            $table->string('nomresp')->nullable();
            $table->string('cargo')->nullable();
            $table->string('observ')->nullable();
            $table->string('ci')->nullable();
            $table->string('usuar')->nullable();
            $table->string('expedicion')->nullable();
            $table->boolean('estado')->default(1);
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
            $table->timestamps();

            $table->foreign('codofic')->references('id')->on('oficina');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resp');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReparatieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reparatie', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('merk');
            $table->string('model');
            $table->string('provider')->nullable();
            $table->string('eerderGerepareerd');
            $table->longText('schades');
            $table->longText('beschrijving');
            $table->string('kosten');
            $table->integer('userID');
            $table->integer('handtekeningID')->nullable();
            $table->integer('klantID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparatie');
    }
}

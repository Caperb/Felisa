<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAanvraagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('merk');
            $table->string('model');
            $table->string('contractType');
            $table->string('provider');
            $table->integer('userID');
            $table->string('prijs');
            $table->string('state');
            $table->date('due')->nullable();
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
        Schema::dropIfExists('aanvraag');
    }
}

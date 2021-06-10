<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
          $table->id();
          $table->timestamps();
          $table->string('merk');
          $table->string('model');
          $table->string('contractType')->nullable();
          $table->string('provider');
          $table->integer('userID');
          $table->string('prijs');
          $table->string('type');
          $table->string('state')->nullable();
          $table->date('due')->nullable();
          $table->integer('handtekeningID');
          $table->integer('klantID');
          $table->string('eerderGerepareerd')->nullable();
          $table->longText('schades')->nullable();
          $table->longText('beschrijving')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}

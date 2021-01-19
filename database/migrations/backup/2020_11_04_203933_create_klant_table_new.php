<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlantTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klant', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('voornaam');
            $table->string('tussenvoegsel')->nullable();
            $table->string('achternaam');
            $table->string('telefoonNummer');
            $table->string('emailAdres');
            $table->string('postcode');
            $table->string('huisNummer');
            $table->string('contractStatus');
            $table->date('geboortedatum')->nullable();
            $table->string('soortID')->nullable();
            $table->string('IDnummer')->nullable();
            $table->string('IBAN')->nullable();
            $table->string('merk')->nullable();
            $table->string('model')->nullable();
            $table->date('aanschafdatum')->nullable();
            $table->string('contractType')->nullable();
            $table->date('uitgeefDatumAbbonement')->nullable();
            $table->string('duurAbbonement')->nullable();
            $table->date('verloopDatumAbbonement')->nullable();
            $table->string('maandelijkseKosten')->nullable();
            $table->string('provider')->nullable();
            $table->boolean('afgeslotenViaOns')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klant');
    }
}

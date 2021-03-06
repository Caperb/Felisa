<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderID');
            $table->string('paymentID')->nullable();
            $table->string('refunded')->nullable();
            $table->string('status');
            $table->string('deliveryStatus');
            $table->string('naam');
            $table->string('email');
            $table->string('adres');
            $table->string('postcode');
            $table->string('plaats');
            $table->string('land');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

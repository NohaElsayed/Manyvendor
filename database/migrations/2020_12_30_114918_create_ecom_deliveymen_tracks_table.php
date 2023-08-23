<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomDeliveymenTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_deliveymen_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('deliverymen_id');
            $table->unsignedBigInteger('deliver_assign_id'); // deliver assign id;
            $table->unsignedBigInteger('order_id'); // order id
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
        Schema::dropIfExists('ecom_deliveymen_tracks');
    }
}

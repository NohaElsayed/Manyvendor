<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveymenTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveymen_tracks', function (Blueprint $table) {
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
        Schema::dropIfExists('deliveymen_tracks');
    }
}

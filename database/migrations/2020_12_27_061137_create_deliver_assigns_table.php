<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deliver_user_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('pick')->default(false);
            $table->dateTime('pick_date')->nullable();
            $table->dateTime('duration')->nullable();
            $table->string('status')->default('confirm'); // Unreceived , received
            $table->boolean('delivered')->default(false);
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
        Schema::dropIfExists('deliver_assigns');
    }
}

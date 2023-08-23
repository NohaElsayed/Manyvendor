<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vpvs_id'); //vendor product variant stock id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_product_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('variant')->nullable();
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
        Schema::dropIfExists('carts');
    }
}

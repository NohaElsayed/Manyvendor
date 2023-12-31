<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('booking_code');
            $table->unsignedBigInteger('order_number');
            $table->string('email');
            $table->string('phone');
            $table->unsignedBigInteger('product_id');
            $table->string('sku');
            $table->unsignedBigInteger('shop_id')->nullable(); //when ecommerce is active shop id must be null
            $table->unsignedBigInteger('logistic_id')->nullable();
            $table->string('product_price');
            $table->string('quantity');
            $table->enum('payment_type',['cod','stripe','paypal']);
            $table->enum('status',['pending','delivered','canceled','follow_up','processing','quality_check','product_dispatched','confirmed']);
            $table->longText('review')->nullable();
            $table->integer('review_star')->nullable();
            $table->longText('comment')->nullable();
            $table->unsignedBigInteger('commentedBy')->nullable();
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
        Schema::dropIfExists('order_products');
    }
}

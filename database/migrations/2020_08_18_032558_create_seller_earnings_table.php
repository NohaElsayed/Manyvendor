<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_earnings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->nullable();
            $table->unsignedBigInteger('order_product_id');
            $table->unsignedBigInteger('category_id'); //commission category id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('vendor_product_stock_id');
            $table->unsignedBigInteger('vendor_product_id');
            $table->unsignedBigInteger('product_id');
            $table->double('commission_pay')->nullable(); //pay admin
            $table->double('get_amount')->nullable(); // get payable amount after product deliver
            $table->double('price')->nullable(); // get payable amount after product deliver
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
        Schema::dropIfExists('seller_earnings');
    }
}

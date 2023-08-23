<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->longText('address');
            $table->integer('division_id');
            $table->json('area_id');
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('logistic_id')->nullable();
            $table->string('logistic_charge')->nullable();
            $table->string('order_number')->unique();
            $table->string('applied_coupon')->nullable();
            $table->string('pay_amount')->nullable();
            $table->enum('payment_type',['cod','stripe','paypal']);
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
        Schema::dropIfExists('ecom_orders');
    }
}

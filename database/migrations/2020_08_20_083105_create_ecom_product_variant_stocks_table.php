<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomProductVariantStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_product_variant_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); //vendor id
            $table->unsignedBigInteger('product_id'); //admin product id
            $table->longText('product_variants_id')->nullable(); //this is for admin product variant id array
            $table->longText('product_variants')->nullable(); //this is admin product variant array

            /*vendor product variant */
            $table->integer('quantity'); //all like variant, without variant product quantity
            $table->double('extra_price')->default(0); // variant extra price only plus minus from sale price
            $table->integer('alert_quantity')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('is_published')->default(true);
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
        Schema::dropIfExists('ecom_product_variant_stocks');
    }
}

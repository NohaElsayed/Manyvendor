<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
            $table->double('product_price');
            $table->double('purchase_price')->nullable();
            $table->boolean('is_discount')->nullable();
            $table->enum('discount_type',['flat','per'])->nullable();
            $table->double('discount_price')->nullable();
            $table->double('discount_percentage',3)->nullable();
            $table->boolean('have_variant')->default(false);
            $table->integer('stock')->nullable();
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
        Schema::dropIfExists('vendor_products');
    }
}

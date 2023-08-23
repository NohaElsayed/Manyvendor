<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->bigInteger('sku')->nullable()->unique();
            $table->longText('short_desc')->nullable();
            $table->longText('big_desc')->nullable();
            $table->longText('mobile_desc')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('provider',['youtube','vimeo'])->nullable();
            $table->longText('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->string('meta_image')->nullable();
            $table->longText('tags')->nullable();
            $table->boolean('is_request')->default(false);
            $table->boolean('have_variant')->default(false);
            $table->boolean('is_published')->default(true);
            $table->double('tax')->default(0);

            //this for ecommerce setting
            $table->double('product_price')->default(0);
            $table->double('purchase_price')->nullable();
            $table->boolean('is_discount')->nullable();
            $table->enum('discount_type',['flat','per'])->nullable();
            $table->double('discount_price')->nullable();
            $table->double('discount_percentage',3)->nullable();
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
        Schema::dropIfExists('products');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->string('icon')->nullable(); //this icon class
            $table->string('image')->nullable();

            $table->boolean('is_popular')->default(false);
            $table->boolean('top')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_requested')->default(false);
            $table->integer('parent_category_id')->default(0);
            /*if parent_category_id is 0 then category group FK*/
            $table->unsignedBigInteger('cat_group_id')->nullable();

            $table->longText('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            /*only for parent category*/
            $table->double('start_percentage')->nullable();
            $table->double('end_percentage')->nullable();
            $table->double('start_amount')->nullable();
            $table->double('end_amount')->nullable();
            /*only for child category*/
            /*this is for sub category commission FK*/
            $table->unsignedBigInteger('commission_id')->nullable();

            /*creator id*/
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('categories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            $table->boolean('is_published')->default(true);
            $table->boolean('is_requested')->default(false);
//            $table->unsignedBigInteger('user_id')->nullable();

            $table->longText('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->softDeletes();
            $table->timestamps();

//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}

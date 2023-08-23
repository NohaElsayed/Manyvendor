<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfopagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infopages', function (Blueprint $table) {
            $table->id();
            $table->enum('section',['top','bottom']);
            $table->string('icon')->nullable();
            $table->string('header')->nullable();
            $table->string('desc')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
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
        Schema::dropIfExists('infopages');
    }
}

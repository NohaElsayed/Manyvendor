<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->double('balance')->default(0);
            $table->string('phone')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('trade_licence')->nullable();
            $table->longText('address')->nullable();
            $table->longText('about')->nullable();
            $table->string('facebook')->nullable();
            $table->longText('shop_logo')->default('vendor-store.jpg');
            $table->boolean('approve_status')->default(false);
            $table->bigInteger('user_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('vendors');
    }
}

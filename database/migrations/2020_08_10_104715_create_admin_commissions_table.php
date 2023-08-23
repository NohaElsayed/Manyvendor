<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->nullable();
            $table->unsignedBigInteger('order_product_id');
            $table->unsignedBigInteger('category_id'); //commission category id
            $table->unsignedBigInteger('confirm_by');
            $table->double('price');
            $table->float('percentage');
            $table->double('commission');
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
        Schema::dropIfExists('admin_commissions');
    }
}

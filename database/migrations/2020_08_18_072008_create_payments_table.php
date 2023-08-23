<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->double('current_balance')->nullable();
            $table->enum('process',['Bank','Paypal','Stripe']);
            $table->unsignedBigInteger('account_id');
            $table->string('description')->nullable();
            $table->enum('status',['Request','Confirm']);
            $table->dateTime('status_change_date')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned();
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
        Schema::dropIfExists('payments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('gender');
            $table->longText('permanent_address');
            $table->longText('present_address')->nullable();
            $table->string('phone_num')->nullable();
            $table->string('document')->nullable();
            $table->string('pic')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('confirm')->default(false);
            $table->unsignedBigInteger('confirm_by')->nullable();
            $table->dateTime('confirm_at')->nullable();
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
        Schema::dropIfExists('deliver_users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('tel_number')->nullable();
            $table->enum('genders',['Male','Female','Other'])->nullable();
            $table->boolean('banned')->default(false); // User cannot login if banned
            $table->string('avatar')->default('images/avatar.png');
            $table->timestamp('login_time')->nullable();
            $table->string('provider_id')->nullable(); //for social login
            $table->string('provider')->nullable(); //for social login
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('fcode')->nullable();
            $table->string('nationality')->nullable();
            $table->enum('user_type',['Admin','Customer','Vendor']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        Schema::disableForeignKeyConstraints();
    }
}

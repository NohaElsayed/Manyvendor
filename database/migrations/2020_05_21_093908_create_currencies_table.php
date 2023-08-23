<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); //it's create by flaug like languages
            $table->string('code')->unique(); //
            $table->string('symbol')->nullable(); //$
            $table->double('rate');//1 USD = 87 BTD
            $table->boolean('is_published')->default(true);
            $table->boolean('align')->default(false); //if true right if false left
            $table->string('image')->nullable();
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
        Schema::dropIfExists('currencies');
    }
}

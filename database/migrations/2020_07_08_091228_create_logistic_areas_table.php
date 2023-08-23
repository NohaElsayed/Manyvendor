<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logistic_id');
            $table->unsignedBigInteger('division_id');
            $table->longText('area_id');
            $table->double('rate');
            $table->integer('min');
            $table->integer('max');
            $table->boolean('is_active');
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
        Schema::dropIfExists('logistic_areas');
    }
}

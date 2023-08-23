<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('banner');
            $table->unsignedBigInteger('offer');
            $table->dateTime('start_from');
            $table->dateTime('end_at');
            $table->boolean('active_for_seller')->default(1);
            $table->boolean('active_for_customer')->default(0);
            $table->string('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->string('meta_image')->nullable();
            $table->boolean('is_requested')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}

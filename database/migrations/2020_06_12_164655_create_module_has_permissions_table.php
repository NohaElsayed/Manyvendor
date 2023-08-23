<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('permission_id',false,true);
            $table->foreign('permission_id')
                ->on('permissions')
                ->references('id')->onDelete('cascade');
            $table->bigInteger('module_id',false,true);
            $table->foreign('module_id')
                ->on('modules')
                ->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('module_has_permissions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceToMeterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_to_meter', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('abonent_id');
            $table->integer('service_id');
            $table->integer('meter_id');
            $table->integer('archived')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_to_meter');
    }
}

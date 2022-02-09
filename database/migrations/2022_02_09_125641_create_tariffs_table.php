<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
            $table->float('value');
            $table->integer('city_id')->nullable();
            $table->integer('service_id');
            $table->integer('provider_id')->default(1);
            $table->integer('abonent_type')->default(0);
            $table->integer('virtual')->default(0);
            $table->integer('multiplier')->default(1);
            $table->timestamps()->default('current_timestamp()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->integer('id')->index()->primary();
            $table->string('name', 128)->nullable()->index('name');
            $table->string('type', 32)->nullable();
            $table->boolean('counters')->default(1);
            $table->integer('city_id')->nullable();
            $table->integer('provider_id')->default(0);
            
            $table->index(['id', 'name', 'type', 'city_id'], 'id_2');
            $table->index(['id', 'name', 'type', 'city_id'], 'id_3');
            $table->index(['name', 'type', 'city_id'], 'name_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}

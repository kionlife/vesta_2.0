<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('abonent_id');
            $table->integer('service_id');
            $table->integer('meter_id')->default(0);
            $table->integer('author_id');
            $table->integer('archived')->default(0);
            $table->integer('value');
            $table->dateTime('added_at')->default('current_timestamp()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counters');
    }
}

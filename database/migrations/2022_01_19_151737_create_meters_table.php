<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title', 128);
            $table->integer('abonent_id')->index('abonent_id');
            $table->integer('tariff_id')->default(1);
            $table->string('service_id', 10)->default('0');
            $table->bigInteger('code')->default(0);
            $table->integer('code_plomb')->default(0);
            $table->integer('counter')->default(0);
            $table->date('last_check')->nullable();
            $table->date('next_check')->nullable();
            $table->integer('archived')->default(0);
            $table->dateTime('created_at')->default('current_timestamp()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meters');
    }
}

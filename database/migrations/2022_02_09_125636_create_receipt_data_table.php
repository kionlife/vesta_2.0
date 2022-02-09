<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_data', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('receipt_id');
            $table->integer('service_id');
            $table->integer('last_counters_id');
            $table->integer('current_counters_id');
            $table->decimal('balance', 10, 2);
            $table->decimal('to_pay', 10, 2);
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
        Schema::dropIfExists('receipt_data');
    }
}

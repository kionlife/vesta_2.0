<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('abonent_id');
            $table->integer('author_id')->default(0);
            $table->integer('meter_id')->default(0);
            $table->integer('service_id');
            $table->string('title')->default('Списання');
            $table->decimal('value', 10, 2)->nullable();
            $table->integer('archived')->default(0);
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
        Schema::dropIfExists('costs');
    }
}

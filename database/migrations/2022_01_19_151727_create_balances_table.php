<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('abonent_id');
            $table->integer('service_id');
            $table->float('value');
            $table->integer('status')->default(1);
            $table->integer('archived')->default(0);
            $table->date('last_update')->default('current_timestamp()');
            
            $table->foreign('service_id', 'balances_ibfk_2')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}

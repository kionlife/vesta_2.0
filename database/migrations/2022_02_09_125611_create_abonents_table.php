<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAbonentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonents', function (Blueprint $table) {
            $table->integer('id')->index()->primary();
            $table->string('personal_account', 5)->nullable();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 13)->nullable();
            $table->string('email')->default('0');
            $table->integer('peoples')->default(1);
            $table->integer('city_id')->default(0);
            $table->integer('status')->default(0);
            $table->integer('archived')->nullable()->default(0);
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonents');
    }
}

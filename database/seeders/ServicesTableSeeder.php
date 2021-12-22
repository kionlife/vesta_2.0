<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        \DB::table('services')->delete();

        \DB::table('services')->insert(array (
            0 =>
            array (
                'id' => 1,
            'name' => 'Холодна вода (водопостачання)',
                'type' => 'water',
                'counters' => 1,
                'city_id' => 1,
                'provider_id' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Вивіз сміття',
                'type' => 'waste',
                'counters' => 1,
                'city_id' => 0,
                'provider_id' => 2,
            ),
            2 =>
            array (
                'id' => 3,
            'name' => 'Холодна вода (водовідведення)',
                'type' => 'water',
                'counters' => 1,
                'city_id' => 0,
                'provider_id' => 1,
            ),
        ));


    }
}

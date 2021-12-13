<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('city')->delete();
        
        \DB::table('city')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Миколаївка',
                'code' => 'mklvk',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Улянівка',
                'code' => 'ulnvk',
            ),
        ));
        
        
    }
}
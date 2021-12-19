<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InspectorToServiceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('inspector_to_service')->delete();
        
        \DB::table('inspector_to_service')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 5,
                'service_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 5,
                'service_id' => 3,
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 2,
                'service_id' => 2,
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 5,
                'service_id' => 4,
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 2511,
                'service_id' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 2511,
                'service_id' => 3,
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 2512,
                'service_id' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'user_id' => 2512,
                'service_id' => 3,
            ),
            8 => 
            array (
                'id' => 9,
                'user_id' => 2513,
                'service_id' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'user_id' => 2513,
                'service_id' => 3,
            ),
            10 => 
            array (
                'id' => 11,
                'user_id' => 2514,
                'service_id' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'user_id' => 2514,
                'service_id' => 3,
            ),
        ));
        
        
    }
}
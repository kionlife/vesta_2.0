<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('type')->delete();
        
        \DB::table('type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Фізична особа',
                'created_at' => '2021-09-17 13:48:16',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Юридична особа',
                'created_at' => '2021-09-17 13:48:16',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Державна установа',
                'created_at' => '2021-09-17 13:48:16',
            ),
        ));
        
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SourcesOfIncomeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sources_of_income')->delete();
        
        \DB::table('sources_of_income')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Внесення через касу',
                'description' => 'Платіж здійснено в установі сервісного центру',
                'added_at' => '2022-01-18 12:06:41',
            ),
        ));
        
        
    }
}
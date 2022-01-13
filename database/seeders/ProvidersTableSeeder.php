<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('providers')->delete();
        
        \DB::table('providers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'КП МСР "БЛАГОУСТРІЙ"',
                'director' => 'ГАНЖАЛА МИХАЙЛО СЕРГІЙОВИЧ',
                'current_account' => 'UA923204780000026000924423851',
                'edrpou' => '41142080',
                'address' => '41854, Сумська обл., Білопільський район, селище міського типу Миколаївка, ВУЛИЦЯ ПОПОВИЧА, будинок 33',
                'phone' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'КП МСР "ЗЕЛЕНБУД"',
                'director' => 'ТИМЧЕНКО АНАТОЛІЙ МИКОЛАЙОВИЧ',
                'current_account' => 'UA723204780000026008924864898',
                'edrpou' => '42952859',
                'address' => '41854, Сумська обл., Білопільський район, селище міського типу Миколаївка, ВУЛИЦЯ ПОПОВИЧА, будинок 33',
                'phone' => NULL,
            ),
        ));
        
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReceiptStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('receipt_status')->delete();
        
        \DB::table('receipt_status')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Сформовано',
                'updated_at' => '2021-10-05 18:15:12',
                'created_at' => '2021-10-05 18:15:12',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Надруковано',
                'updated_at' => '2021-10-05 18:58:32',
                'created_at' => '2021-10-05 18:58:32',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Помилкова',
                'updated_at' => '2021-10-06 17:08:46',
                'created_at' => '2021-10-06 17:08:46',
            ),
        ));
        
        
    }
}
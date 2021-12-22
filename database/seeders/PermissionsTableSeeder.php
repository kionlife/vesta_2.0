<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'add counters',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 12:50:30',
                'updated_at' => '2021-05-31 12:50:30',
            ),
            1 =>
            array (
                'id' => 4,
                'name' => 'page home',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 13:38:10',
                'updated_at' => '2021-05-31 13:38:10',
            ),
            2 =>
            array (
                'id' => 5,
                'name' => 'page operations',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 13:39:51',
                'updated_at' => '2021-05-31 13:39:51',
            ),
            3 =>
            array (
                'id' => 6,
                'name' => 'page payments',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 13:40:04',
                'updated_at' => '2021-05-31 13:40:04',
            ),
            4 =>
            array (
                'id' => 7,
                'name' => 'page services',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 13:40:16',
                'updated_at' => '2021-05-31 13:40:16',
            ),
            5 =>
            array (
                'id' => 8,
                'name' => 'page reports payments',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 16:30:34',
                'updated_at' => '2021-05-31 16:30:34',
            ),
            6 =>
            array (
                'id' => 9,
                'name' => 'page abonents',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 16:34:35',
                'updated_at' => '2021-05-31 16:34:35',
            ),
            7 =>
            array (
                'id' => 10,
                'name' => 'edit balance',
                'guard_name' => 'web',
                'created_at' => '2021-08-09 13:43:19',
                'updated_at' => '2021-08-09 13:43:19',
            ),
            8 =>
            array (
                'id' => 11,
                'name' => 'page corrections',
                'guard_name' => 'web',
                'created_at' => '2021-08-09 13:43:19',
                'updated_at' => '2021-08-09 13:43:19',
            ),
        ));


    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('roles')->delete();

        \DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'inspector',
                'guard_name' => 'web',
                'created_at' => '2021-05-30 22:09:56',
                'updated_at' => '2021-05-30 22:09:56',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'abonent',
                'guard_name' => 'web',
                'created_at' => '2021-05-30 22:11:33',
                'updated_at' => '2021-05-30 22:11:33',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2021-05-30 22:12:20',
                'updated_at' => '2021-05-30 22:12:20',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'employee',
                'guard_name' => 'web',
                'created_at' => '2021-05-31 09:42:16',
                'updated_at' => '2021-05-31 09:42:16',
            ),
        ));


    }
}

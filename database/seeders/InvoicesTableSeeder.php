<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('invoices')->delete();
        
        \DB::table('invoices')->insert(array (
            0 => 
            array (
                'id' => 9,
                'abonent_id' => 118,
                'month' => 6,
                'year' => 2021,
                'data' => '{"month":"06","year":"2021","data":{"abonent":{"abonent_id":118,"name":"\\u041a\\u0443\\u0434\\u0456\\u043d \\u0420\\u043e\\u043c\\u0430\\u043d \\u041e\\u043b\\u0435\\u043a\\u0441\\u0430\\u043d\\u0434\\u0440\\u043e\\u0432\\u0438\\u0447","address":"\\u041a\\u043e\\u0432\\u043f\\u0430\\u043a\\u0430 17\\/4"},"services":[{"id":1,"name":"\\u041a\\u041f \\"\\u0412\\u041e\\u0414\\u041e\\u041a\\u0410\\u041d\\u0410\\u041b-\\u0423\\u041b\\u042f\\u041d\\u0406\\u0412\\u041a\\u0410\\"","type":"water","counters":"1","city_id":"1","balance":"1336","last_counters":"113","meters":[{"id":15,"title":"Test","abonent_id":"118","service_id":"1","code":"8888","counter":"888","last_check":null,"next_check":"2021-06-10"},{"id":16,"title":"test","abonent_id":"118","service_id":"1","code":"4444444","counter":"4444444","last_check":null,"next_check":"2022-01-01"},{"id":19,"title":"\\u043f\\u0430\\u0440\\u0430\\u0448\\u0430","abonent_id":"118","service_id":"1","code":"500","counter":"777","last_check":null,"next_check":"2021-06-16"}]},{"id":2,"name":"\\u041a\\u041f \\"\\u0421\\u043c\\u0456\\u0442\\u0442\\u044f\\"","type":"default","counters":"0","city_id":"0","balance":"60"}]}}',
            ),
        ));
        
        
    }
}
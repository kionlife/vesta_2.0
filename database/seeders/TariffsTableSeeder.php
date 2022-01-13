<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TariffsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tariffs')->delete();
        
        \DB::table('tariffs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Тариф водопостачання фіз. особа Миколаївка',
                'value' => 14.0,
                'city_id' => 1,
                'service_id' => 1,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Тариф водовідведення фіз. особа Миколаївка',
                'value' => 11.2,
                'city_id' => 1,
                'service_id' => 3,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Тариф вивіз сміття фіз. особа Миколаївка',
                'value' => 15.0,
                'city_id' => 1,
                'service_id' => 2,
                'provider_id' => 2,
                'abonent_type' => 1,
                'virtual' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Тариф водопостачання фіз. особа Улянівка',
                'value' => 17.7,
                'city_id' => 2,
                'service_id' => 1,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Тариф вивіз сміття фіз. особа Улянівка',
                'value' => 15.0,
                'city_id' => 2,
                'service_id' => 2,
                'provider_id' => 2,
                'abonent_type' => 1,
                'virtual' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Тариф водовідведення фіз. особа Улянівка',
                'value' => 11.0,
                'city_id' => 2,
                'service_id' => 3,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Тариф водопостачання юр. особа Улянівка',
                'value' => 19.4,
                'city_id' => 2,
                'service_id' => 1,
                'provider_id' => 1,
                'abonent_type' => 2,
                'virtual' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Тариф водовідведення юр. особа Улянівка',
                'value' => 11.5,
                'city_id' => 2,
                'service_id' => 3,
                'provider_id' => 1,
                'abonent_type' => 2,
                'virtual' => 0,
            ),
            8 => 
            array (
                'id' => 9,
            'name' => 'Тариф водопостачання фіз. особа Миколаївка (віртуальний лічильник)',
                'value' => 56.0,
                'city_id' => 1,
                'service_id' => 1,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 1,
            ),
            9 => 
            array (
                'id' => 10,
            'name' => 'Тариф водовідведення фіз. особа Миколаївка (віртуальний лічильник)',
                'value' => 44.8,
                'city_id' => 1,
                'service_id' => 3,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 1,
            ),
            10 => 
            array (
                'id' => 11,
            'name' => 'Тариф водопостачання фіз. особа Улянівка (віртуальний лічильник)',
                'value' => 70.8,
                'city_id' => 2,
                'service_id' => 1,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 1,
            ),
            11 => 
            array (
                'id' => 12,
            'name' => 'Тариф водовідведення фіз. особа Улянівка (віртуальний лічильник)',
                'value' => 44.0,
                'city_id' => 2,
                'service_id' => 3,
                'provider_id' => 1,
                'abonent_type' => 1,
                'virtual' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Тариф водопостачання юр. особа Миколаївка',
                'value' => 21.6,
                'city_id' => 1,
                'service_id' => 1,
                'provider_id' => 1,
                'abonent_type' => 2,
                'virtual' => 0,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Тариф водовідведення юр. особа Миколаївка',
                'value' => 16.6,
                'city_id' => 1,
                'service_id' => 3,
                'provider_id' => 1,
                'abonent_type' => 2,
                'virtual' => 0,
            ),
            14 => 
            array (
                'id' => 15,
            'name' => 'Тариф вивіз сміття юр. особа Улянівка (віртуальний)',
                'value' => 15.0,
                'city_id' => 2,
                'service_id' => 2,
                'provider_id' => 2,
                'abonent_type' => 2,
                'virtual' => 1,
            ),
            15 => 
            array (
                'id' => 16,
            'name' => 'Тариф вивіз сміття юр. особа Миколаївка (віртуальний)',
                'value' => 15.0,
                'city_id' => 1,
                'service_id' => 2,
                'provider_id' => 2,
                'abonent_type' => 2,
                'virtual' => 1,
            ),
        ));
        
        
    }
}
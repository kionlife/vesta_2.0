<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArchiveTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('archive')->delete();
        
        \DB::table('archive')->insert(array (
            0 => 
            array (
                'id' => 9,
                'abonent_id' => 323,
                'title' => 'Скорик Галина Сергіївна',
                'data' => '{"user":[{"id":1818,"name":"Скорик Галина Сергіївна","email":"00323","email_verified_at":null,"created_at":"2021-08-06T22:11:07.000000Z","updated_at":"2021-08-06T22:11:07.000000Z"}],"balance":[{"id":3625,"abonent_id":"323","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":3626,"abonent_id":"323","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":4954,"abonent_id":"323","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":314,"abonent_id":"323","provider_id":"1","title":"","date":"0000-00-00"},{"id":4409,"abonent_id":"323","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":323,"user_id":"1818","name":"Скорик Галина Сергіївна","address":"смт. Миколаївка, Шевченка, буд № 48","phone":"0","email":"0","peoples":"4","updated_at":"2021-08-06T22:11:07.000000Z","created_at":"2021-08-06T22:11:07.000000Z"}}',
            ),
            1 => 
            array (
                'id' => 10,
                'abonent_id' => 287,
                'title' => 'Паун Віталій Сергійович',
                'data' => '{"user":[{"id":1476,"name":"Паун Віталій Сергійович","email":"00287","email_verified_at":null,"created_at":"2021-08-06T22:10:48.000000Z","updated_at":"2021-08-06T22:10:48.000000Z"}],"balance":[{"id":2941,"abonent_id":"287","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":2942,"abonent_id":"287","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":4920,"abonent_id":"287","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":280,"abonent_id":"287","provider_id":"1","title":"","date":"0000-00-00"},{"id":4375,"abonent_id":"287","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":287,"user_id":"1476","name":"Паун Віталій Сергійович","address":"смт. Миколаївка, Шевченка, буд № 25\\/3","phone":"0950069421","email":"0","peoples":"3","updated_at":"2021-08-06T22:10:48.000000Z","created_at":"2021-08-06T22:10:48.000000Z"}}',
            ),
            2 => 
            array (
                'id' => 11,
                'abonent_id' => 7076,
                'title' => 'Столова Школа',
                'data' => '{"user":[{"id":1882,"name":"Столова Школа","email":"7076","email_verified_at":null,"created_at":"2021-08-06T22:11:10.000000Z","updated_at":"2021-08-06T22:11:10.000000Z"}],"balance":[{"id":3753,"abonent_id":"7076","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":3754,"abonent_id":"7076","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6899,"abonent_id":"7076","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2261,"abonent_id":"7076","provider_id":"1","title":"","date":"0000-00-00"},{"id":6356,"abonent_id":"7076","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7076,"user_id":"1882","name":"Столова Школа","address":null,"phone":"0","email":"0","peoples":"0","updated_at":"2021-08-06T22:11:10.000000Z","created_at":"2021-08-06T22:11:10.000000Z"}}',
            ),
            3 => 
            array (
                'id' => 12,
                'abonent_id' => 7410,
                'title' => 'Школа',
                'data' => '{"user":[{"id":2216,"name":"Школа","email":"7410","email_verified_at":null,"created_at":"2021-08-06T22:11:29.000000Z","updated_at":"2021-08-06T22:11:29.000000Z"}],"balance":[{"id":4421,"abonent_id":"7410","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":4422,"abonent_id":"7410","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6932,"abonent_id":"7410","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2294,"abonent_id":"7410","provider_id":"1","title":"","date":"0000-00-00"},{"id":6389,"abonent_id":"7410","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7410,"user_id":"2216","name":"Школа","address":"с. Бобрик","phone":"0","email":"0","peoples":"0","updated_at":"2021-08-06T22:11:29.000000Z","created_at":"2021-08-06T22:11:29.000000Z"}}',
            ),
            4 => 
            array (
                'id' => 13,
                'abonent_id' => 7411,
                'title' => 'Школа',
                'data' => '{"user":[{"id":2217,"name":"Школа","email":"7411","email_verified_at":null,"created_at":"2021-08-06T22:11:29.000000Z","updated_at":"2021-08-06T22:11:29.000000Z"}],"balance":[{"id":4423,"abonent_id":"7411","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":4424,"abonent_id":"7411","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6933,"abonent_id":"7411","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2295,"abonent_id":"7411","provider_id":"1","title":"","date":"0000-00-00"},{"id":6390,"abonent_id":"7411","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7411,"user_id":"2217","name":"Школа","address":"с.Тучне.","phone":"0956114561","email":"0","peoples":"0","updated_at":"2021-08-06T22:11:29.000000Z","created_at":"2021-08-06T22:11:29.000000Z"}}',
            ),
            5 => 
            array (
                'id' => 14,
                'abonent_id' => 7412,
                'title' => 'Школа',
                'data' => '{"user":[{"id":2218,"name":"Школа ","email":"7412","email_verified_at":null,"created_at":"2021-08-06T22:11:29.000000Z","updated_at":"2021-08-06T22:11:29.000000Z"}],"balance":[{"id":4425,"abonent_id":"7412","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":4426,"abonent_id":"7412","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6934,"abonent_id":"7412","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2296,"abonent_id":"7412","provider_id":"1","title":"","date":"0000-00-00"},{"id":6391,"abonent_id":"7412","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7412,"user_id":"2218","name":"Школа ","address":null,"phone":"0509892256","email":"0","peoples":"0","updated_at":"2021-08-06T22:11:29.000000Z","created_at":"2021-08-06T22:11:29.000000Z"}}',
            ),
            6 => 
            array (
                'id' => 15,
                'abonent_id' => 7413,
                'title' => 'Школа їдальня',
                'data' => '{"user":[{"id":2219,"name":"Школа їдальня","email":"7413","email_verified_at":null,"created_at":"2021-08-06T22:11:29.000000Z","updated_at":"2021-08-06T22:11:29.000000Z"}],"balance":[{"id":4427,"abonent_id":"7413","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":4428,"abonent_id":"7413","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6935,"abonent_id":"7413","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2297,"abonent_id":"7413","provider_id":"1","title":"","date":"0000-00-00"},{"id":6392,"abonent_id":"7413","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7413,"user_id":"2219","name":"Школа їдальня","address":"с. Бобрик","phone":"0684602944","email":"0","peoples":"0","updated_at":"2021-08-06T22:11:29.000000Z","created_at":"2021-08-06T22:11:29.000000Z"}}',
            ),
            7 => 
            array (
                'id' => 16,
                'abonent_id' => 6511,
                'title' => 'Музикальна школа',
                'data' => '{"user":[{"id":1317,"name":"Музикальна школа","email":"6511","email_verified_at":null,"created_at":"2021-08-06T22:10:39.000000Z","updated_at":"2021-08-06T22:10:39.000000Z"}],"balance":[{"id":2623,"abonent_id":"6511","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":2624,"abonent_id":"6511","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6883,"abonent_id":"6511","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2246,"abonent_id":"6511","provider_id":"1","title":"","date":"0000-00-00"},{"id":6341,"abonent_id":"6511","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":6511,"user_id":"1317","name":"Музикальна школа","address":"смт. Миколаївка, вул. Шкільна","phone":"0991528654","email":"0","peoples":"0","updated_at":"2021-08-06T22:10:39.000000Z","created_at":"2021-08-06T22:10:39.000000Z"}}',
            ),
            8 => 
            array (
                'id' => 17,
                'abonent_id' => 6461,
                'title' => 'Медичний пункт',
                'data' => '{"user":[{"id":1267,"name":"Медичний пункт","email":"6461","email_verified_at":null,"created_at":"2021-08-06T22:10:36.000000Z","updated_at":"2021-08-06T22:10:36.000000Z"}],"balance":[{"id":2523,"abonent_id":"6461","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":2524,"abonent_id":"6461","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6876,"abonent_id":"6461","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2239,"abonent_id":"6461","provider_id":"1","title":"","date":"0000-00-00"},{"id":6334,"abonent_id":"6461","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":6461,"user_id":"1267","name":"Медичний пункт","address":"с. Бобрик","phone":"0508833832","email":"0","peoples":"0","updated_at":"2021-08-06T22:10:36.000000Z","created_at":"2021-08-06T22:10:36.000000Z"}}',
            ),
            9 => 
            array (
                'id' => 18,
                'abonent_id' => 248,
                'title' => 'Бабаєвський Сергій  Федорович',
                'data' => '{"user":[{"id":36,"name":"Бабаєвський Сергій  Федорович","email":"00248","email_verified_at":null,"created_at":"2021-08-06T22:09:27.000000Z","updated_at":"2021-08-06T22:09:27.000000Z"}],"balance":[{"id":61,"abonent_id":"248","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":62,"abonent_id":"248","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":4883,"abonent_id":"248","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":243,"abonent_id":"248","provider_id":"1","title":"","date":"0000-00-00"},{"id":4338,"abonent_id":"248","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":248,"user_id":"36","name":"Бабаєвський Сергій Федорович","address":"смт. Миколаївка, Каштанова, буд № 2\\/6","phone":"0","email":"0","peoples":"2","updated_at":"2021-08-06T22:09:27.000000Z","created_at":"2021-08-06T22:09:27.000000Z"}}',
            ),
            10 => 
            array (
                'id' => 20,
                'abonent_id' => 5007,
                'title' => 'Дунзенко Катерина Михайлівна',
                'data' => '{"user":[{"id":571,"name":"Дунзенко Катерина Михайлівна","email":"5007","email_verified_at":null,"created_at":"2021-08-06T22:09:57.000000Z","updated_at":"2021-08-06T22:09:57.000000Z"}],"balance":[{"id":1131,"abonent_id":"5007","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":1132,"abonent_id":"5007","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6783,"abonent_id":"5007","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2162,"abonent_id":"5007","provider_id":"1","title":"","date":"0000-00-00"},{"id":6258,"abonent_id":"5007","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5007,"user_id":"571","name":"Дунзенко Катерина Михайлівна","address":"смт. Ульянівка, вул. Г. Долгозвяш, буд 27","phone":"0","email":"0","peoples":"0","updated_at":"2021-08-06T22:09:57.000000Z","created_at":"2021-08-06T22:09:57.000000Z"}}',
            ),
            11 => 
            array (
                'id' => 21,
                'abonent_id' => 5010,
                'title' => 'Пелічева Іван Іванович',
                'data' => '{"user":[{"id":1484,"name":"Пелічева Іван Іванович","email":"5010","email_verified_at":null,"created_at":"2021-08-06T22:10:48.000000Z","updated_at":"2021-08-06T22:10:48.000000Z"}],"balance":[{"id":2957,"abonent_id":"5010","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":2958,"abonent_id":"5010","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":6786,"abonent_id":"5010","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2165,"abonent_id":"5010","provider_id":"1","title":"","date":"0000-00-00"},{"id":6261,"abonent_id":"5010","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5010,"user_id":"1484","name":"Пелічева Іван Іванович","address":"смт. Ульянівка, вул. Д. Бєлих, буд 14","phone":"0","email":"0","peoples":"10","updated_at":"2021-08-06T22:10:48.000000Z","created_at":"2021-08-06T22:10:48.000000Z"}}',
            ),
            12 => 
            array (
                'id' => 22,
                'abonent_id' => 5001,
                'title' => 'Чистоклет Петро Михайлович',
                'data' => '{"user":[{"id":2147,"name":"Чистоклет Петро Михайлович","email":"5001","email_verified_at":null,"created_at":"2021-08-06T22:11:25.000000Z","updated_at":"2021-08-06T22:11:25.000000Z"}],"balance":[{"id":4283,"abonent_id":"5001","service_id":"1","value":"-224","status":"1","last_update":"2021-08-07"},{"id":4284,"abonent_id":"5001","service_id":"3","value":"0","status":"0","last_update":"2021-08-07"},{"id":6777,"abonent_id":"5001","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":2159,"abonent_id":"5001","provider_id":"1","title":"1119","date":"2019-06-01"},{"id":6255,"abonent_id":"5001","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5001,"user_id":"2147","name":"Чистоклет Петро Михайлович","address":"с,Верхосулка,вул  Миру, буд № 39","phone":"0662208628","email":"0","peoples":"2","updated_at":"2021-08-23T10:34:54.000000Z","created_at":"2021-08-06T22:11:25.000000Z"}}',
            ),
            13 => 
            array (
                'id' => 23,
                'abonent_id' => 910,
                'title' => 'Балінова Любов Валеріївна',
                'data' => '{"user":[{"id":84,"name":"Балінова Любов Валеріївна","email":"00910","email_verified_at":null,"created_at":"2021-08-06T22:09:30.000000Z","updated_at":"2021-08-06T22:09:30.000000Z"}],"balance":[{"id":157,"abonent_id":"910","service_id":"1","value":"0","status":"1","last_update":"2021-08-07"},{"id":158,"abonent_id":"910","service_id":"3","value":"0","status":"1","last_update":"2021-08-07"},{"id":5521,"abonent_id":"910","service_id":"2","value":"0","status":"1","last_update":"2021-08-11"}],"contract":[{"id":880,"abonent_id":"910","provider_id":"1","title":"","date":"0000-00-00"},{"id":4975,"abonent_id":"910","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":910,"user_id":"84","name":"Балінова Любов Валеріївна","address":"смт.Миколаївка, Шкільна, буд № 29","phone":"0959159577","email":"0","peoples":"0","updated_at":"2021-08-06T22:09:30.000000Z","created_at":"2021-08-06T22:09:30.000000Z"}}',
            ),
            14 => 
            array (
                'id' => 25,
                'abonent_id' => 9999,
                'title' => 'Абонент Для Тестів',
            'data' => '{"user":[{"id":2363,"name":"Абонент Для Тестів","email":"9999","email_verified_at":null,"created_at":"2021-08-12T15:42:56.000000Z","updated_at":"2021-08-12T15:42:56.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2304,"abonent_id":"9999","provider_id":"1","title":"","date":"0000-00-00"},{"id":6399,"abonent_id":"9999","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":9999,"user_id":"2363","name":"Абонент Для Тестів","address":"Тестова адреса 12","phone":"0679743846","email":"0","peoples":"1","updated_at":"2021-08-16T11:28:47.000000Z","created_at":"2021-08-12T15:42:56.000000Z"}}',
            ),
            15 => 
            array (
                'id' => 26,
                'abonent_id' => 5059,
                'title' => 'Стеценко Олена Василівна',
            'data' => '{"user":[{"id":1878,"name":"Стеценко Олена Василівна","email":"5059","email_verified_at":null,"created_at":"2021-08-06T22:11:10.000000Z","updated_at":"2021-08-06T22:11:10.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2193,"abonent_id":"5059","provider_id":"1","title":"","date":"0000-00-00"},{"id":6288,"abonent_id":"5059","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5059,"user_id":"1878","name":"Стеценко Олена Василівна","address":"смт. Миколаївка,Ювілейна, буд № 21, кв.4","phone":"0992804340","email":"0","peoples":"2","updated_at":"2021-08-06T22:11:10.000000Z","created_at":"2021-08-06T22:11:10.000000Z"}}',
            ),
            16 => 
            array (
                'id' => 27,
                'abonent_id' => 323,
                'title' => 'Скорик Галина Сергіївна',
            'data' => '{"user":[{"id":1818,"name":"Скорик Галина Сергіївна","email":"00323","email_verified_at":null,"created_at":"2021-08-06T22:11:07.000000Z","updated_at":"2021-08-06T22:11:07.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":314,"abonent_id":"323","provider_id":"1","title":"","date":"0000-00-00"},{"id":4409,"abonent_id":"323","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":323,"user_id":"1818","name":"Скорик Галина Сергіївна","address":"смт. Миколаївка, Шевченка, буд № 48","phone":"0","email":"0","peoples":"4","updated_at":"2021-08-06T22:11:07.000000Z","created_at":"2021-08-06T22:11:07.000000Z"}}',
            ),
            17 => 
            array (
                'id' => 28,
                'abonent_id' => 287,
                'title' => 'Паун Віталій Сергійович',
            'data' => '{"user":[{"id":1476,"name":"Паун Віталій Сергійович","email":"00287","email_verified_at":null,"created_at":"2021-08-06T22:10:48.000000Z","updated_at":"2021-08-06T22:10:48.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":280,"abonent_id":"287","provider_id":"1","title":"","date":"0000-00-00"},{"id":4375,"abonent_id":"287","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":287,"user_id":"1476","name":"Паун Віталій Сергійович","address":"смт. Миколаївка, Шевченка, буд № 25\\/3","phone":"0950069421","email":"0","peoples":"3","updated_at":"2021-08-06T22:10:48.000000Z","created_at":"2021-08-06T22:10:48.000000Z"}}',
            ),
            18 => 
            array (
                'id' => 29,
                'abonent_id' => 2006,
                'title' => 'Буштаренко Сусана Петрівна',
            'data' => '{"user":[{"id":232,"name":"Буштаренко Сусана Петрівна","email":"02006","email_verified_at":null,"created_at":"2021-08-06T22:09:38.000000Z","updated_at":"2021-08-06T22:09:38.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1928,"abonent_id":"2006","provider_id":"1","title":"2055","date":"2021-02-01"},{"id":6024,"abonent_id":"2006","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":2006,"user_id":"232","name":"Буштаренко Сусана Петрівна","address":"смт. Улянівка, вул. Касяна буд 35","phone":"0","email":"0","peoples":"8","status":"0","updated_at":"2021-08-27T05:09:36.000000Z","created_at":"2021-08-06T22:09:38.000000Z"}}',
            ),
            19 => 
            array (
                'id' => 30,
                'abonent_id' => 1799,
                'title' => 'Сакун Віталій Анатолійович',
            'data' => '{"user":[{"id":1705,"name":"Сакун Віталій Анатолійович","email":"01799","email_verified_at":null,"created_at":"2021-08-06T22:11:00.000000Z","updated_at":"2021-08-06T22:11:00.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1730,"abonent_id":"1799","provider_id":"1","title":"","date":"0000-00-00"},{"id":5825,"abonent_id":"1799","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1799,"user_id":"1705","name":"Сакун Віталій Анатолійович","address":"смт. Улянівка, площ. В. Колесніка, буд 36\\/8","phone":"0","email":"0","peoples":"4","status":"0","updated_at":"2021-08-18T11:59:51.000000Z","created_at":"2021-08-06T22:11:00.000000Z"}}',
            ),
            20 => 
            array (
                'id' => 31,
                'abonent_id' => 1651,
                'title' => 'Ляшко Олександр Васильович',
            'data' => '{"user":[{"id":1193,"name":"Ляшко Олександр Васильович","email":"01651","email_verified_at":null,"created_at":"2021-08-06T22:10:32.000000Z","updated_at":"2021-08-06T22:10:32.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1583,"abonent_id":"1651","provider_id":"1","title":"1651","date":"2021-02-01"},{"id":5678,"abonent_id":"1651","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1651,"user_id":"1193","name":"Ляшко Олександр Васильович","address":"смт. Улянівка, вул. Садова, 5","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-25T06:17:31.000000Z","created_at":"2021-08-06T22:10:32.000000Z"}}',
            ),
            21 => 
            array (
                'id' => 32,
                'abonent_id' => 2032,
                'title' => 'невідомо2',
            'data' => '{"user":[{"id":1341,"name":"невідомо2","email":"02032","email_verified_at":null,"created_at":"2021-08-06T22:10:40.000000Z","updated_at":"2021-08-06T22:10:40.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1953,"abonent_id":"2032","provider_id":"1","title":"2081","date":"2021-02-01"},{"id":6049,"abonent_id":"2032","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":2032,"user_id":"1341","name":"невідомо2","address":"смт. Улянівка, вул. Кооперативна, буд 41","phone":"0","email":"0","peoples":"0","status":"1","updated_at":"2021-08-27T06:29:39.000000Z","created_at":"2021-08-06T22:10:40.000000Z"}}',
            ),
            22 => 
            array (
                'id' => 33,
                'abonent_id' => 885,
                'title' => 'Шкурат Олексій Олексійович',
            'data' => '{"user":[{"id":2220,"name":"Шкурат  Олексій Олексійович","email":"00885","email_verified_at":null,"created_at":"2021-08-06T22:11:29.000000Z","updated_at":"2021-08-06T22:11:29.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":858,"abonent_id":"885","provider_id":"1","title":"","date":"0000-00-00"},{"id":4953,"abonent_id":"885","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":885,"user_id":"2220","name":"Шкурат Олексій Олексійович","address":"с. Марківка, Центральна, буд № 38","phone":"0990313583","email":"0","peoples":"2","status":"0","updated_at":"2021-08-06T22:11:29.000000Z","created_at":"2021-08-06T22:11:29.000000Z"}}',
            ),
            23 => 
            array (
                'id' => 34,
                'abonent_id' => 6346,
                'title' => 'Лісовенко Ніна Іванівна',
            'data' => '{"user":[{"id":1152,"name":"Лісовенко Ніна Іванівна","email":"6346","email_verified_at":null,"created_at":"2021-08-06T22:10:30.000000Z","updated_at":"2021-08-06T22:10:30.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2237,"abonent_id":"6346","provider_id":"1","title":"","date":"0000-00-00"},{"id":6332,"abonent_id":"6346","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":6346,"user_id":"1152","name":"Лісовенко Ніна Іванівна","address":"смт. Миколаївка,Заводська, буд № 24, кв.2","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:10:30.000000Z","created_at":"2021-08-06T22:10:30.000000Z"}}',
            ),
            24 => 
            array (
                'id' => 35,
                'abonent_id' => 5055,
                'title' => 'Лукашенко Володимир Іванович',
            'data' => '{"user":[{"id":1181,"name":"Лукашенко Володимир Іванович","email":"5055","email_verified_at":null,"created_at":"2021-08-06T22:10:31.000000Z","updated_at":"2021-08-06T22:10:31.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2190,"abonent_id":"5055","provider_id":"1","title":"","date":"0000-00-00"},{"id":6285,"abonent_id":"5055","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5055,"user_id":"1181","name":"Лукашенко Володимир Іванович","address":"смт. Миколаївка,Заводська, буд № 34, кв.6","phone":"0668870784","email":"0","peoples":"2","status":"0","updated_at":"2021-08-06T22:10:31.000000Z","created_at":"2021-08-06T22:10:31.000000Z"}}',
            ),
            25 => 
            array (
                'id' => 36,
                'abonent_id' => 1729,
                'title' => 'невідомо',
            'data' => '{"user":[{"id":1340,"name":"невідомо","email":"01729","email_verified_at":null,"created_at":"2021-08-06T22:10:40.000000Z","updated_at":"2021-08-06T22:10:40.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1661,"abonent_id":"1729","provider_id":"1","title":"1661","date":"2021-02-01"},{"id":5756,"abonent_id":"1729","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1729,"user_id":"1340","name":"невідомо","address":"смт. Ульянівка, вул. Заверчанська, буд 79","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-25T09:55:03.000000Z","created_at":"2021-08-06T22:10:40.000000Z"}}',
            ),
            26 => 
            array (
                'id' => 37,
                'abonent_id' => 1732,
                'title' => 'Пятаченко Андрій Павлович',
            'data' => '{"user":[{"id":1623,"name":"Пятаченко Андрій Павлович","email":"01732","email_verified_at":null,"created_at":"2021-08-06T22:10:56.000000Z","updated_at":"2021-08-06T22:10:56.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1664,"abonent_id":"1732","provider_id":"1","title":"","date":"1970-01-01"},{"id":5759,"abonent_id":"1732","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1732,"user_id":"1623","name":"Пятаченко Андрій Павлович","address":"смт. Улянівка, вул. Заверчанська, буд 84","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-25T09:56:54.000000Z","created_at":"2021-08-06T22:10:56.000000Z"}}',
            ),
            27 => 
            array (
                'id' => 38,
                'abonent_id' => 1796,
                'title' => 'Молошна Вікторія Іванівна',
            'data' => '{"user":[{"id":1307,"name":"Молошина Вікторія Іванівна","email":"01796","email_verified_at":null,"created_at":"2021-08-06T22:10:38.000000Z","updated_at":"2021-08-06T22:10:38.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1727,"abonent_id":"1796","provider_id":"1","title":"","date":"0000-00-00"},{"id":5822,"abonent_id":"1796","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1796,"user_id":"1307","name":"Молошна Вікторія Іванівна","address":"смт. Улянівка, площ. В. Колесніка, буд 34,кв.4","phone":"0","email":"0","peoples":"3","status":"0","updated_at":"2021-08-18T11:42:19.000000Z","created_at":"2021-08-06T22:10:38.000000Z"}}',
            ),
            28 => 
            array (
                'id' => 39,
                'abonent_id' => 1537,
                'title' => 'Дика Ольга Володимирівна',
            'data' => '{"user":[{"id":493,"name":"Дико Ольга Володимирівна","email":"01537","email_verified_at":null,"created_at":"2021-08-06T22:09:53.000000Z","updated_at":"2021-08-06T22:09:53.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1469,"abonent_id":"1537","provider_id":"1","title":"1582","date":"2021-02-01"},{"id":5564,"abonent_id":"1537","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1537,"user_id":"493","name":"Дика Ольга Володимирівна","address":"смт. Улянівка, вул. Свободи, 6","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-23T10:26:12.000000Z","created_at":"2021-08-06T22:09:53.000000Z"}}',
            ),
            29 => 
            array (
                'id' => 40,
                'abonent_id' => 1543,
                'title' => 'Галіна Ганна Миколаївна',
            'data' => '{"user":[{"id":2396,"name":"Галіна Ганна Миколаївна","email":"1543","email_verified_at":null,"created_at":"2021-08-13T13:03:39.000000Z","updated_at":"2021-08-13T13:03:39.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1475,"abonent_id":"1543","provider_id":"1","title":"1589","date":"2021-02-01"},{"id":5570,"abonent_id":"1543","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1543,"user_id":"2396","name":"Галіна Ганна Миколаївна","address":"смт. Улянівка, вул. Свободи 21","phone":"0","email":"0","peoples":"1","status":"0","updated_at":"2021-08-23T10:35:15.000000Z","created_at":"2021-08-13T13:03:39.000000Z"}}',
            ),
            30 => 
            array (
                'id' => 41,
                'abonent_id' => 1574,
                'title' => 'Середа Іван Петрович',
            'data' => '{"user":[{"id":1759,"name":"Середа Іван Петрович","email":"01574","email_verified_at":null,"created_at":"2021-08-06T22:11:03.000000Z","updated_at":"2021-08-06T22:11:03.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1506,"abonent_id":"1574","provider_id":"1","title":"1672","date":"2021-02-01"},{"id":5601,"abonent_id":"1574","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1574,"user_id":"1759","name":"Середа Іван Петрович","address":"смт. Улянівка, вул. Шевченка, 18","phone":"0","email":"0","peoples":"1","status":"1","updated_at":"2021-08-30T08:09:48.000000Z","created_at":"2021-08-06T22:11:03.000000Z"}}',
            ),
            31 => 
            array (
                'id' => 42,
                'abonent_id' => 6986,
                'title' => 'Сичева Олена Валеріївна',
            'data' => '{"user":[{"id":1792,"name":"Сичева Олена Валеріївна","email":"6986","email_verified_at":null,"created_at":"2021-08-06T22:11:05.000000Z","updated_at":"2021-08-06T22:11:05.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2256,"abonent_id":"6986","provider_id":"1","title":"","date":"0000-00-00"},{"id":6351,"abonent_id":"6986","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":6986,"user_id":"1792","name":"Сичева Олена Валеріївна","address":"смт. Миколаївка, Шевченка, буд № 17\\/9","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:11:05.000000Z","created_at":"2021-08-06T22:11:05.000000Z"}}',
            ),
            32 => 
            array (
                'id' => 43,
                'abonent_id' => 7028,
                'title' => 'Скусинець Микола Володимирович',
            'data' => '{"user":[{"id":1834,"name":"Скусинець Микола Володимирович","email":"7028","email_verified_at":null,"created_at":"2021-08-06T22:11:07.000000Z","updated_at":"2021-08-06T22:11:07.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2258,"abonent_id":"7028","provider_id":"1","title":"","date":"0000-00-00"},{"id":6353,"abonent_id":"7028","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7028,"user_id":"1834","name":"Скусинець Микола Володимирович","address":"с. Калинівка, Молодіжна, буд № 15, корп. кв.8","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:11:07.000000Z","created_at":"2021-08-06T22:11:07.000000Z"}}',
            ),
            33 => 
            array (
                'id' => 44,
                'abonent_id' => 7474,
                'title' => 'Ярмак Валентина Іванувна',
            'data' => '{"user":[{"id":2280,"name":"Ярмак Валентина Іванувна","email":"7474","email_verified_at":null,"created_at":"2021-08-06T22:11:32.000000Z","updated_at":"2021-08-06T22:11:32.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2300,"abonent_id":"7474","provider_id":"1","title":"","date":"0000-00-00"},{"id":6395,"abonent_id":"7474","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7474,"user_id":"2280","name":"Ярмак Валентина Іванувна","address":"смт. Миколаївка, Гончаренка, буд № 36","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:11:32.000000Z","created_at":"2021-08-06T22:11:32.000000Z"}}',
            ),
            34 => 
            array (
                'id' => 45,
                'abonent_id' => 5050,
                'title' => 'Редька Валентина Василівна',
            'data' => '{"user":[{"id":1638,"name":"Редька  Валентина  Василівна","email":"5050","email_verified_at":null,"created_at":"2021-08-06T22:10:57.000000Z","updated_at":"2021-08-06T22:10:57.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2186,"abonent_id":"5050","provider_id":"1","title":"","date":"0000-00-00"},{"id":6281,"abonent_id":"5050","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5050,"user_id":"1638","name":"Редька Валентина Василівна","address":"смт. Миколаївка, Центральна, буд № 155","phone":"0660149945","email":"0","peoples":"1","status":"0","updated_at":"2021-08-06T22:10:57.000000Z","created_at":"2021-08-06T22:10:57.000000Z"}}',
            ),
            35 => 
            array (
                'id' => 46,
                'abonent_id' => 5508,
                'title' => 'Герун Лариса Володимирівна',
            'data' => '{"user":[{"id":314,"name":"Герун Лариса Володимирівна","email":"5508","email_verified_at":null,"created_at":"2021-08-06T22:09:43.000000Z","updated_at":"2021-08-06T22:09:43.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2213,"abonent_id":"5508","provider_id":"1","title":"","date":"0000-00-00"},{"id":6308,"abonent_id":"5508","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":5508,"user_id":"314","name":"Герун Лариса Володимирівна","address":"смт. Улянівка, вул. Суворова, 27\\/5","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-23T06:44:50.000000Z","created_at":"2021-08-06T22:09:43.000000Z"}}',
            ),
            36 => 
            array (
                'id' => 47,
                'abonent_id' => 1067,
                'title' => 'Сірик Ольга Федорівна',
            'data' => '{"user":[{"id":1803,"name":"Сірик Ольга Федорівна","email":"01067","email_verified_at":null,"created_at":"2021-08-06T22:11:06.000000Z","updated_at":"2021-08-06T22:11:06.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":1021,"abonent_id":"1067","provider_id":"1","title":"","date":"0000-00-00"},{"id":5116,"abonent_id":"1067","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":1067,"user_id":"1803","name":"Сірик Ольга Федорівна","address":"с. Калинівка, Молодіжна, буд № 21\\/5","phone":"0668114639","email":"0","peoples":"0","status":"0","updated_at":"2021-08-25T08:28:38.000000Z","created_at":"2021-08-06T22:11:06.000000Z"}}',
            ),
            37 => 
            array (
                'id' => 48,
                'abonent_id' => 7255,
                'title' => 'ФОП Шумейко Інна Борисівна',
            'data' => '{"user":[{"id":2061,"name":"ФОП Шумейко Інна Борисівна","email":"7255","email_verified_at":null,"created_at":"2021-08-06T22:11:20.000000Z","updated_at":"2021-08-06T22:11:20.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2291,"abonent_id":"7255","provider_id":"1","title":"","date":"0000-00-00"},{"id":6386,"abonent_id":"7255","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":7255,"user_id":"2061","name":"ФОП Шумейко Інна Борисівна","address":null,"phone":"0661104412","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:11:20.000000Z","created_at":"2021-08-06T22:11:20.000000Z"}}',
            ),
            38 => 
            array (
                'id' => 49,
                'abonent_id' => 6472,
                'title' => 'Миколаївська ЗОШ 1-3 ступенів',
            'data' => '{"user":[{"id":1278,"name":"Миколаївська ЗОШ 1-3 ступенів","email":"6472","email_verified_at":null,"created_at":"2021-08-06T22:10:37.000000Z","updated_at":"2021-08-06T22:10:37.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2241,"abonent_id":"6472","provider_id":"1","title":"","date":"0000-00-00"},{"id":6336,"abonent_id":"6472","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":6472,"user_id":"1278","name":"Миколаївська ЗОШ 1-3 ступенів","address":"смт. Миколаївка, вул. Шкільна, 6","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:10:37.000000Z","created_at":"2021-08-06T22:10:37.000000Z"}}',
            ),
            39 => 
            array (
                'id' => 50,
                'abonent_id' => 6473,
                'title' => 'Миколаївська ЗОШ 1-3 ступенів',
            'data' => '{"user":[{"id":1279,"name":"Миколаївська ЗОШ 1-3 ступенів","email":"6473","email_verified_at":null,"created_at":"2021-08-06T22:10:37.000000Z","updated_at":"2021-08-06T22:10:37.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2242,"abonent_id":"6473","provider_id":"1","title":"","date":"0000-00-00"},{"id":6337,"abonent_id":"6473","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":6473,"user_id":"1279","name":"Миколаївська ЗОШ 1-3 ступенів","address":"смт. Миколаївка, вул. Шкільна, 6","phone":"0955201587","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:10:37.000000Z","created_at":"2021-08-06T22:10:37.000000Z"}}',
            ),
            40 => 
            array (
                'id' => 51,
                'abonent_id' => 2295,
                'title' => 'Голеша Віталій Микитович',
            'data' => '{"user":[{"id":326,"name":"Голеша Віталій Микитович","email":"2295","email_verified_at":null,"created_at":"2021-08-06T22:09:43.000000Z","updated_at":"2021-08-06T22:09:43.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2154,"abonent_id":"2295","provider_id":"1","title":"","date":"0000-00-00"},{"id":6250,"abonent_id":"2295","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":2295,"user_id":"326","name":"Голеша Віталій Микитович","address":"смт. Миколаївка, Кисленка № 14","phone":"0951782946","email":"0","peoples":"2","status":"0","updated_at":"2021-08-06T22:09:43.000000Z","created_at":"2021-08-06T22:09:43.000000Z"}}',
            ),
            41 => 
            array (
                'id' => 52,
                'abonent_id' => 2297,
                'title' => 'Чернявська Лія Вадимівна',
            'data' => '{"user":[{"id":2136,"name":"Чернявська Лія Вадимівна","email":"2297","email_verified_at":null,"created_at":"2021-08-06T22:11:24.000000Z","updated_at":"2021-08-06T22:11:24.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2155,"abonent_id":"2297","provider_id":"1","title":"","date":"0000-00-00"},{"id":6251,"abonent_id":"2297","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":2297,"user_id":"2136","name":"Чернявська Лія Вадимівна","address":"смт. Миколаївка, Горіхова, буд № 102","phone":"0664390460","email":"0","peoples":"0","status":"0","updated_at":"2021-08-06T22:11:24.000000Z","created_at":"2021-08-06T22:11:24.000000Z"}}',
            ),
            42 => 
            array (
                'id' => 53,
                'abonent_id' => 2297,
                'title' => 'ФОП Дронь Марія Прокопівна',
            'data' => '{"user":[{"id":2483,"name":"ФОП Дронь Марія Прокопівна","email":"2297","email_verified_at":null,"created_at":"2021-09-15T12:06:47.000000Z","updated_at":"2021-09-15T12:06:47.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":6442,"abonent_id":"2297","provider_id":"1","title":"","date":"0000-00-00"}],"counters":[],"abonent":{"id":2297,"user_id":"2483","name":"ФОП Дронь Марія Прокопівна","address":"смт.Улянівка,вул.Центральна,4","phone":"0950814454","email":"0","peoples":"0","status":"1","updated_at":"2021-09-15T12:06:47.000000Z","created_at":"2021-09-15T12:06:47.000000Z"}}',
            ),
            43 => 
            array (
                'id' => 54,
                'abonent_id' => 7171,
                'title' => 'ТОВ "Біта"',
            'data' => '{"user":[{"id":1977,"name":"ТОВ \\"Біта\\"","email":"7171","email_verified_at":null,"created_at":"2021-08-06T22:11:15.000000Z","updated_at":"2021-08-06T22:11:15.000000Z"}],"balance":[{"id":1,"name":"Холодна вода (водопостачання)","type":"water","counters":"1","city_id":"1","provider_id":"1"},{"id":2,"name":"Вивіз сміття","type":"waste","counters":"0","city_id":"0","provider_id":"2"},{"id":3,"name":"Холодна вода (водовідведення)","type":"water","counters":"0","city_id":"0","provider_id":"1"}],"contract":[{"id":2262,"abonent_id":"7171","provider_id":"1","title":"002\\/36","date":"2021-05-01"},{"id":6357,"abonent_id":"7171","provider_id":"2","title":"","date":"0000-00-00"}],"counters":[{"id":1968,"abonent_id":"7171","service_id":"1","meter_id":"1634","author_id":"5","value":"0","added_at":"2021-09-14 12:44:34"}],"abonent":{"id":7171,"user_id":"1977","name":"ТОВ \\"Біта\\"","address":"смт. Миколаївка, вул. Заводська (територія завода)","phone":"0","email":"0","peoples":"0","status":"0","updated_at":"2021-09-14T09:44:08.000000Z","created_at":"2021-08-06T22:11:15.000000Z"}}',
            ),
        ));
        
        
    }
}
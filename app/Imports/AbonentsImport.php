<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;
use App\Models\Abonent;
use App\Models\Balance;
use App\Models\Meters;


class AbonentsImport implements ToArray, WithHeadingRow
{
    public function array(array $rows)
    {

/*        foreach ($rows as $row) {
            $field = array(
                'abonent_id' => $row['or'],
                'name'       => $row['pib'],
                'address'    => $row['adresa'],
                'phone'      => $row['telefon'],
                'email'      => $row['email'],
                'meter'      => array(
                    'code_plomb'  => $row['nomer_plombi'],
                    'code'        => $row['nomer_licilnika'],
                    'title'       => $row['komentar_do_licilnika']
                ),
                'peoples'     => $row['k_t_propisanix_osib'],
                'counters'    => array(
                        'january'  => array(
                            'abonent_id' => $row['or'],
                            'service_id' => 1,
                            '',
                            'author_id' => 1,
                            'value'     => $row[10],
                            'added_at'  => '15.01.2021'
                        ),
                        'february' => array(),
                        'march'    => array(),
                        'april'    => array(),
                        'may'      => array(),
                        'june'     => array(),
                        'july'     => array()
                    )
            );
            array_push($fields, $field);
        }*/

        /* TODO База даних
            Змінити поле email в users на login
         */
        /*
            $n = 5200;
            foreach ($rows as $row) {
                $userReg = new User();
                $userReg->name = $row['pib'];
                $userReg->email = $row['or'];

                if ($userReg->email == null) {
                    $userReg->email = $n;
                }

                $userReg->password = bcrypt($userReg->email);
                $userReg->save();
                $user_id = $userReg->id;

                $abonent_id = $row['or'];
                if ($abonent_id == null) {
                    $abonent_id = $n;
                }

                $peoples = $row['k_t_propisanix_osib'];
                if ($peoples == null) {
                    $peoples = 0;
                }
                $phone = $row['telefon'];
                if ($phone == null) {
                    $phone = 0;
                }

                $field = array(
                    'id' => $abonent_id,
                    'user_id' => $user_id,
                    'name' => $row['pib'],
                    'address' => $row['adresa'],
                    'phone' => $phone,
                    'peoples' => $peoples
                );

                Abonent::create($field);

                $services = array(1,3);
                foreach ($services as $service) {
                    $balance = array(
                        'abonent_id' => $abonent_id,
                        'service_id' => $service,
                        'value'      => 0
                    );

                    Balance::create($balance);
                }


                $n++;
            }*/

        foreach ($rows as $row) {
                $meter = array(
                    'title' => 'Лічильник',
                    'abonent_id' => $row['id'],
                    'service_id' => 1,
                    'code' => 0,
                    'code_plomb' => 0,
                    'counter' => 0,
                    'last_check' => '2021-08-01',
                    'next_check' => '2021-08-20'
                );
                Meters::create($meter);
        }


    }

    public function headingRow(): int
    {
        return 1;
    }
}

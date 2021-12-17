<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
		* {
			font-size: 8.5px;
		}

        p {
            font-size: 10px;
        }

		body {
			font-family: DejaVu Sans, sans-serif;
            margin: 0;
		}

        td {
            padding: 1px;
        }

        img {
            width: 100%;
        }

		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}

        .img__td {
            padding: 0px;
        }

         .page-break {
             page-break-after: always;
         }
    </style>
</head>
<body>

<table style="margin-bottom: 15px">
    <tr>
        <td colspan="9">
            Сплатити за послуги до 7 числа наступного місяця. Квитанція сформована на основі даних станом на <b>{{ $receipt['created_at']->format('d.m.Y') }}</b>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            Повідомлення про нарахування за <b>{{ $receipt['last_month'] }} {{ $receipt['last_month_year'] }} р. </b> <br>
            <b>{{ $receipt['abonent']['name'] }} (О/Р <span style="background: #c4c4c4; padding: 5px 15px;">{{ $receipt['abonent']['personal_account'] }} </span>)  <br>
                {{ $receipt['abonent']['address'] }}</b>
        </td>
        <td colspan="4">Сумський обласний розрахунково-обліковий сервіс</td>
    </tr>
    <tr>
        <td rowspan="2">Стаття нарахувань, <br>одиниці виміру</td>
        <td rowspan="2">Баланс <br> (на {{ $receipt['created_at']->format('d.m.Y') }})</td>
        <td colspan="2" style="text-align: center;">Показники</td>
        <td rowspan="2">Обсяг</td>
        <td rowspan="2">Тариф</td>
        <td rowspan="2">Нараховано за <b>{{ $receipt['last_month'] }}</b></td>
        <td rowspan="2">Сплачено у розрах. період</td>
        <td rowspan="2">До сплати</td>
    </tr>
    <tr>
        <td>Попередні</td>
        <td>Поточні</td>
    </tr>
        @foreach ($receipt['services'] as $provider => $value)
            {{ $total = 0 }}
            <tr>
                <td colspan="9" style="text-align: center; font-weight: 700;">{{ $provider }} </td>
            </tr>
            <tr>
                <td colspan="9">
                    Адреса: {{ $value[0]['service_provider'][0]['address'] }} <br>
                        ЄДРПОУ: {{ $value[0]['service_provider'][0]['edrpou'] }} <br>
                        Розрахунковий рахунок: {{ $value[0]['service_provider'][0]['current_account'] }} <br>
                        Призначення платежу: <span style="background: #c4c4c4; padding: 5px 15px;">Сплата за послуги {{ $receipt['abonent']['personal_account'] }} </span>

                </td>
            </tr>
            @foreach ($value as $service)
                <tr>
                    <td>{{ $service['service_title'] }}</td>
                    <td>{{ $service['balance'] }} грн.</td>
                    <td>{{ $service['last_counters'] }}</td>
                    <td>{{ $service['current_counters'] }}</td>
                    <td>{{ $service['used_counter'] }}</td>
                    <td>{{ $service['tariff']  }} </td>
                    <td>{{ $service['generated'] }} грн.</td>
                    <td>@money($service['last_payment']) грн.</td>
                    <td>{{ $service['to_pay'] }} грн.</td>
                    {{ $total += $service['to_pay'] }}
                </tr>
		    @endforeach
            <tr>
                <td colspan="8">
                    <b>Всього по надавачу послуг</b>
                </td>
                <td>
                    <b>@money($total) грн. </b>
                </td>
            </tr>
		@endforeach


    </table>


    <p><b>Шановні мешканці Миколаївської громади.</b> <br> З 01.12.21 року в громаді впроваджується єдина платіжка за комунальні послуги. Ви матимете змогу контролювати витрати, оплачувати рахунки через банк, та матимете доступ до особистого кабінету.
        <br> <b>Передавати показники за водопостачання потрібно буде з 23 до кінця місяця кожного місяця. Сплатити за послуги Ви повинні до 7 числа наступного місяця.</b></p>

</body>
</html>

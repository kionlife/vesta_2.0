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
               Сплатити за послуги до 16 числа наступного місяця
           </td>
        </tr>
        <tr>
            <td colspan="5">
{{--                Повідомлення про нарахування за розрахунковий період з (<b>{{ $receipt['last_month'] }} {{ $receipt['last_month_year'] }} р. </b>) <br>--}}
                Повідомлення про нарахування за розрахунковий період з <b>01.11.2021 по 30.11.2021 р.</b> <br>
                <b>{{ $receipt['abonent']['name'] }} (О/Р <span style="background: #c4c4c4; padding: 5px 15px;">{{ $receipt['abonent']['personal_account'] }} </span>)  <br>
                {{ $receipt['abonent']['address'] }}</b>
            </td>
            <td colspan="4">Сумський обласний розрахунково-обліковий сервіс</td>
        </tr>
        <tr>
            <td>Стаття нарахувань, <br>одиниці виміру</td>
            <td>Залишок на початок розрахункового періоду</td>
            <td>Показники на початок періоду</td>
            <td>Показники на кінець періоду</td>
            <td>Обсяг</td>
            <td>Тариф</td>
            <td>Нараховано за розрахунковий період</td>
            <td>Сплачено у розрахунковий період</td>
            <td>До сплати на 30.11.2021 р.</td>
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
                    <td>{{ $service['last_payment'] }} грн.</td>
                    <td>{{ $service['to_pay'] }} грн.</td>
                    {{ $total += $service['to_pay'] }}
                </tr>
		    @endforeach
            <tr>
                <td colspan="8">
                    <b>Всього по надавачу послуг</b>
                </td>
                <td>
                    <b>{{ $total }} грн. </b>
                </td>
            </tr>
		@endforeach


    </table>

    <p><b>Шановні мешканці Миколаївської громади.</b> <br> З 01.11.21 року в громаді впроваджується єдина платіжка за комунальні послуги. Ви матимете змогу контролювати витрати, оплачувати рахунки через банк, та матимете доступ до особистого кабінету.
        <br> <b>Передавати показники за водопостачання потрібно буде з 5 по 15 число кожного місяця. Сплатити за послуги Ви повинні до кінця місяця.</b></p>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-size: 11px;
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
        <td colspan="4"></td>
    </tr>
    @foreach ($receipt['services'] as $value)
        @foreach ($value as $item)
            @foreach ($item as $service)
                @if (isset($service['meter']))
                    @if ($service['meter'][0]['title'] != 'virtual')
                <tr>
                    <td colspan="4"></td>
                    <td>{{ $service['meter'][0]['title'] }}</td>
                    <td>{{ $service['last_counters'] }}</td>
                    <td>{{ $service['current_counters'] }}</td>
                </tr>
                @endif
                @endif
            @endforeach
        @endforeach
    @endforeach
    <tr>
        <td colspan="7">
            Квитанція сформована на основі даних станом на
            <b>{{ $receipt['created_at']->format('d.m.Y') }}</b>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            Повідомлення про нарахування за <b>{{ $receipt['last_month'] }} {{ $receipt['last_month_year'] }} р. </b>
            <br>
            <b>{{ $receipt['abonent']['name'] }} (О/Р <span
                    style="background: #c4c4c4; padding: 5px 15px;">{{ $receipt['abonent']['personal_account'] }} </span>)
                <br>
                {{ $receipt['abonent']['address'] }}</b>
        </td>
        <td colspan="3">Сумський обласний розрахунково-обліковий сервіс</td>
    </tr>
    <tr>
        <td>Стаття нарахувань, <br>одиниці виміру</td>
        <td>Баланс <br> (на {{ $receipt['created_at']->format('d.m.Y') }})</td>
        <td>Обсяг</td>
        <td>Тариф</td>
        <td>Нараховано за <b>{{ $receipt['last_month'] }}</b></td>
        <td>Сплачено у розрах. період</td>
        <td>До сплати</td>
    </tr>
    @foreach ($receipt['services'] as $provider => $value)
        {{ $total = 0 }}
        <tr>
            <td colspan="7" style="text-align: center; font-weight: 700;">{{ $provider }} </td>
        </tr>
@foreach($value as $serv)
                    <tr>
        <td colspan="7">
                            Адреса: {{ $serv[0]['service_provider'][0]['address'] }} <br>
                                ЄДРПОУ: {{ $serv[0]['service_provider'][0]['edrpou'] }} |
                                Розрахунковий рахунок: {{ $serv[0]['service_provider'][0]['current_account'] }} <br>
                                Призначення платежу: <span style="background: #c4c4c4; padding: 5px 15px;">Сплата за послуги {{ $receipt['abonent']['personal_account'] }} </span>

                        </td>
            </tr>
            @break
        @endforeach
        @foreach ($value as $item)

            <tr>
                <td>{{ $item->first()['service_title'] }}</td>
                <td>{{ $item->first()['balance'] }} грн</td>
                <td>{{ $receipt['total_used'][$provider][$item->first()['service_id']] }}</td>
                <td>{{ $item->first()['tariff'] }}</td>
                <td>{{ $receipt['total_generated'][$provider][$item->first()['service_id']] }} грн</td>
                <td>@money($item->first()['last_payment']) грн</td>
                <td>{{ $item->first()['to_pay'] }} грн</td>
                {{ $total += $item->first()['to_pay'] }}
            </tr>

        @endforeach
        <tr>
            <td colspan="6">
                <b>Всього по надавачу послуг</b>
            </td>
            <td>
                <b>@money($total) грн</b>
            </td>
        </tr>
    @endforeach


</table>



</body>
</html>

@extends('layouts.app')

@section('content')



    <div class="inner-content">
        <div class="outter-wp">
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Квитанції</li>
                </ol>
            </div>
            <div class="graph-visual tables-main">

                <div class="row">
                    <div class="col-md-6">
                        <h3 class="inner-tittle two">Квитанції</h3>
                    </div>

                    <div class="col-md-6 text-right">
                        <a href="/receipts/preview" class="btn btn-primary"><i class="fa fa-user"></i><span> Сформувати квитанції</span></a>
                    </div>
                </div>
                <div class="graph">
                    <div class="tables">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Абонент</th>
                                <th>Послуга</th>
                                <th>Тариф</th>
                                <th>Попередні показники</th>
                                <th>До нарахування</th>
                                <th>Попередній баланс</th>
                                <th>До сплати</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($receipts as $reseipt)
                                <tr>
                                    <td>{{ $reseipt['abonent_name']}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>@foreach ($reseipt['services'] as $service)
                                            {{ $service['balance']}}<br>
                                        @endforeach</td>
                                    <td>@foreach ($reseipt['services'] as $service)
                                            {{ $service['to_pay']}}<br>
                                        @endforeach</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>



@endsection

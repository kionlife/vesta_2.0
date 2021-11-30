@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Абоненти</li>
                </ol>
            </div>
            <div class="graph-visual tables-main">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="inner-tittle two">Абоненти</h3>
                    </div>

                    <div class="col-md-6 text-right">
                        <a class="btn btn-primary" href="/abonents/create"><i class="fa fa-user"></i><span> Додати абонента</span></a>
                    </div>
                </div>

                <div class="graph">
                    <div class="tables">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>О/р</th>
                                <th>Тип абонента</th>
                                <th>ПІБ</th>
                                <th>Баланс, грн</th>
                                <th>Адреса</th>
                                <th>Телефон</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($abonents as $abonent)
                                    <tr>
                                        <td><a href="/abonents/{{ $abonent['id'] }}">{{ $abonent['personal_account'] }}</a></td>
                                        <td>{{ $abonent['type'][0]['title'] }}</td>
                                        <td>{{ $abonent['name'] }}</td>
                                        <td></td>
                                        <td>{{ $abonent['address'] }}</td>
                                        <td>{{ $abonent['phone'] }}</td>
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

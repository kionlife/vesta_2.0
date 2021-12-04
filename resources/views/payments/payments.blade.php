@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Платежі</li>
                </ol>
            </div>
            <div class="stats-info graph">
                <div class="stats">
                    <form method="post" action="/payments">
                        @csrf
                        <div class="vali-form payment_form">
                            <div class="row">
                                <div class="col-md-5 form-group1">
                                    <label class="control-label">Абонент</label>
                                    <select class="form-control1" id="abonent_search" name="abonent_id">
                                    </select>
                                </div>
                                <div class="col-sm-4 form-group1">
                                    <label class="control-label">Послуга</label>
                                    <select class="form-control1" name="service_id" id="abonent_services">
                                    </select>
                                </div>
                                <div class="col-md-1 form-group1">
                                    <label class="control-label">Сума</label>
                                    <input type="text" name="value" placeholder="" required="">
                                </div>

                            </div>

                            <div class="row margin-top">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary" type="submit" value="">Додати платіж</button>
                                </div>
                            </div>


                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="graph-visual tables-main">
                <h3 class="inner-tittle two">Платежі</h3>
                <div class="graph">
                    <div class="tables">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Надавач послуг</th>
                                <th>Сума</th>
                                <th>Автор</th>
                                <th>Абонент</th>
                                <th>Дата, час</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment['id'] }}</td>
                                    <td>{{ $payment['service'][0]['name']}}</td>
                                    <td>{{ $payment['value'] }}</td>
                                    <td>{{ $payment['author']['name'] }}</td>
                                    <td>{{ $payment['abonent']['name']}}</td>
                                    <td>{{ $payment['created_at'] }}</td>
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

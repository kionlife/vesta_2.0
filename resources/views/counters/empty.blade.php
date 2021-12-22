@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
            @if(!empty($alert))
                @include('elements/notify', ['response' => $alert])
            @endif
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Показники</li>
                </ol>
            </div>
            <div class="stats-grid">
                <div class="stats-head">
                    <h4 class="title3">Внесення показників</h4>
                </div>
                <div class="stats-info graph">
                    <div class="stats">
                        <form method="POST" action="/counters">
                            @csrf
                            <div class="vali-form payment_form">
                                <div class="row">


                                    <div class="col-md-6 form-group1">
                                        <label class="control-label">Особовий рахунок</label>
                                        <select class="form-control1" id="abonent_search" name="abonent_id">
                                        </select>
                                    </div>
                                    <div class="col-sm-6 form-group1">
                                        <label class="control-label">Послуга</label>
                                        <select class="form-control1" name="service_id" id="abonent_services">
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group1">
                                        <label class="control-label">Лічильник</label>
                                        <select class="form-control1" name="meter_id" id="abonent_services_meters">
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group1">
                                        <label class="control-label">Попередній</label>
                                        <input id="last_counter" type="text" disabled required="">
                                    </div>
                                    <div class="col-md-3 form-group1">
                                        <label class="control-label">Поточний</label>
                                        <input id="current_counter" type="text" name="value" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 form-group1">
                                        <label class="control-label">Використано м³</label>
                                        <input id="used_counter" type="text" disabled required="">
                                    </div>
                                    <div class="col-md-2 form-group1">
                                        <label class="control-label">Дата</label>
                                        <input id="added_at" type="date" name="added_at" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="">
                                    </div>
                                </div>

                                <div class="row margin-top">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary" type="submit" value="+">Додати показник</button>
                                    </div>
                                </div>


                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="graph-visual tables-main">
                <h3 class="inner-tittle two">Показники</h3>
                <div class="graph">
                    <div class="tables">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Вид послуги</th>
                                <th>Лічильник</th>
                                <th>Значення</th>
                                <th>Автор</th>
                                <th>Абонент</th>
                                <th>Дата, час</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($counters as $counter)
                                <tr>
                                    <td>{{ $counter['service'][0]['name']}}</td>
                                    <td>{{ $counter['meter'][0]['title'] }}</td>
                                    <td>{{ $counter['value'] }}</td>
                                    <td>{{ $counter['author']['name'] }}</td>
                                    <td><a href="/abonents/{{ $counter['abonent']['id'] }}">{{ $counter['abonent']['name'] }}</a></td>
                                    <td>{{ $counter['added_at'] }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{ $counters->links('pagination::bootstrap-4') }}
                </div>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>

@endsection

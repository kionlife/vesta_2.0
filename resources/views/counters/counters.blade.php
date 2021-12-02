@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Показники</li>
                </ol>
            </div>
            <div class="stats-grid">
                <div class="stats-head">
                    <h4 class="title3">Внесення платежу</h4>
                </div>
                <div class="stats-info graph">
                    <div class="stats">
                        <form method="POST" action="/counters">
                            <div class="vali-form payment_form">
                                <div class="row">


                                    <div class="col-md-6 form-group1">
                                        <label class="control-label">Особовий рахунок</label>
                                        <input type="text" placeholder="Firstname" required="">
                                    </div>
                                    <div class="col-sm-6 form-group1">
                                        <label class="control-label">Послуга</label>
                                        <select class="form-control1" name="city_id" id="">
                                            @foreach($services as $service)
                                                <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group1">
                                        <label class="control-label">Лічильник</label>
                                        <input type="text" placeholder="Lastname" required="">
                                    </div>
                                    <div class="col-md-3 form-group1">
                                        <label class="control-label">Попередній</label>
                                        <input type="text" display="hidden" required="">
                                    </div>
                                    <div class="col-md-3 form-group1">
                                        <label class="control-label">Поточний</label>
                                        <input type="text" placeholder="" required="">
                                    </div>
                                    <div class="col-md-3 form-group1">
                                        <label class="control-label">Використано м³</label>
                                        <input type="text" display="hidden" required="">
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
                                    <td>{{ $counter['abonent']['name'] }}</td>
                                    <td>{{ $counter['added_at'] }}</td>
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

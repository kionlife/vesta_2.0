@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
                @if(session()->has('alert'))
                    <div class="alert alert-success">
                        {{ session()->get('alert') }}
                    </div>
                @endif
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/">Головна</a></li>
                    <li class="active">Платежі</li>
                </ol>
            </div>
            <div class="stats-info graph">
                <div class="stats">
                    <form id="paymentAddForm" method="post" action="javascript:void(null);" onsubmit="payment.add()">
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
                                <div class="col-sm-2 form-group1">
                                    <label class="control-label">Джерело надходження</label>
                                    <select class="form-control1" name="source_id" id="">
                                        @foreach($sources as $source)
                                            <option selected value="{{ $source['id'] }}">{{ $source['name'] }}</option>
                                        @endforeach
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
                                <th>Тип</th>
                                <th>Джерело надходження</th>
                                <th>Сума</th>
                                <th>Автор</th>
                                <th>Абонент</th>
                                <th>Дата, час</th>
                                <th>Операції</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $payment)
                                <tr id="payment_{{ $payment['id'] }}">
                                    <td>{{ $payment['id'] }}</td>
                                    <td>{{ $payment['service'][0]['name']}}</td>
                                    <td>{{ $payment['title'] }}</td>
                                    <td>{{ $payment['source']['name'] }}</td>
                                    <td>{{ $payment['value'] }}</td>
                                    <td>{{ $payment['author']['name'] }}</td>
                                    <td><a href="/abonents/{{ $payment['abonent']['id'] }}">{{ $payment['abonent']['name']}}</td>
                                    <td>{{ $payment['created_at'] }}</td>
                                    <td>
                                        <button onclick="payment.delete({{ $payment['id'] }})" class="tooltips @if ($payment['allow_cancel'] === 0) disabled @endif" href="#"><span>Скасувати платіж</span><i class="lnr lnr-undo"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="row">
                    {{ $payments->links('pagination::bootstrap-4') }}
                </div>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>


@endsection

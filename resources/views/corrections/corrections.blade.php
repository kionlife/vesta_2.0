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
                    <li class="active">Коригування балансів</li>
                </ol>
            </div>
            <div class="stats-grid">
                <div class="stats-head">
                    <h4 class="title3">Коригування балансу</h4>
                </div>
                <div class="stats-info graph">
                    <div class="stats">
                        <form method="POST" action="/corrections">
                            @csrf
                            <div class="vali-form payment_form">
                                <div class="row">


                                    <div class="col-md-4 form-group1">
                                        <label class="control-label">Особовий рахунок</label>
                                        <select class="form-control1" id="abonent_search" name="abonent_id">
                                        </select>
                                    </div>
                                    <div class="col-sm-4 form-group1">
                                        <label class="control-label">Послуга</label>
                                        <select class="form-control1" name="service_id" id="abonent_services">
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group1">
                                        <label class="control-label">Поточний баланс</label>
                                        <input id="current_balance" type="text" disabled required="">
                                    </div>
                                    <div class="col-md-2 form-group1">
                                        <label class="control-label">Коригуюче значення</label>
                                        <input id="correct_balance" type="text" name="value" placeholder="" required="">
                                    </div>

                                </div>

                                <div class="row margin-top">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary" type="submit" value="+">Зберегти</button>
                                    </div>
                                </div>


                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="graph-visual tables-main">
                <div class="graph">
                    <div class="tables">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Вид послуги</th>
                                <th>Баланс</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="correction_service"></td>
                                <td id="correction_balance"></td>
                            </tr>


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

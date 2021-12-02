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
                        <button data-toggle="modal" data-target="#add_abonent" type="button" class="btn btn-primary"><i class="fa fa-user"></i><span> Додати абонента</span></button>
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



    <div class="modal fade modalCustom" id="add_abonent" tabindex="-1" role="dialog" aria-labelledby="add_abonent" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form class="modal-content" action="javascript:void(null);" onsubmit="abonent.add()" method="post">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Додавання абонента</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">ПІБ</label>
                                        <div class="col-sm-8">
                                            <input required
                                                name="name"
                                                type="text"
                                                class="form-control"
                                                placeholder="ПІБ"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Адреса</label>
                                        <div class="col-sm-8">
                                            <input required
                                                name="address"
                                                type="text"
                                                class="form-control"
                                                placeholder="Адреса"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Телефон</label>
                                        <div class="col-sm-8">
                                            <input required
                                                name="phone"
                                                type="tel"
                                                class="form-control"
                                                placeholder="Телефон"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Кількість прописаних людей</label>
                                        <div class="col-sm-8">
                                            <input required
                                                name="peoples"
                                                type="number"
                                                class="form-control"
                                                placeholder="Кількість прописаних людей"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Особовий рахунок</label>
                                        <div class="col-sm-8">
                                            <input required
                                                name="personal_account"
                                                type="number"
                                                class="form-control"
                                                placeholder="Особовий рахунок"
                                                value="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Додати</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Скасувати</button>
                </div>
            </form>
        </div>
    </div>

@endsection

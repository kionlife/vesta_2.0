@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
            @if(!empty($alert))
                @include('elements/notify', ['response' => $alert])
            @endif
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/">Головна</a></li>
                    <li><a href="/abonents">Абоненти</a></li>
                    <li class="active">{{ $abonent['name'] }}</li>
                </ol>
            </div>


            <form action="/abonents/{{ $abonent['id'] }}" method="post" class="forms-main">
                @csrf
                <h2 class="inner-tittle">Основна інформація</h2>
                <div class="grid-1">
                    <div class="col-md-5">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input name="name" type="text" class="form-control bigFont" placeholder="ПІБ"
                                               value="{{ $abonent['name'] }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Адреса</label>
                                    <div class="col-sm-9">
                                        <input name="address" type="text" class="form-control" placeholder="Адреса"
                                               value="{{ $abonent['address'] }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Телефон</label>
                                    <div class="col-sm-9">
                                        <input name="phone" type="tel" class="form-control" placeholder="Телефон"
                                               value="{{ $abonent['phone'] }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">О/Р</label>
                                    <div class="col-sm-9">
                                        <input name="personal_account" type="tel" class="form-control bigFont"
                                               placeholder="Особовий рахунок"
                                               value="{{ $abonent['personal_account'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Місто</label>
                                    <div class="col-sm-8">

                                        <select class="form-control1" name="city_id" id="">
                                            @foreach($cities as $city)
                                                <option @if ($abonent['city_id'] == $city['id']) selected @endif value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Тип абонента</label>
                                    <div class="col-sm-8">
                                        <select class="form-control1" name="type_id" id="">
                                            @foreach($types as $type)

                                                <option @if ($abonent['type'][0]['id'] == $type['id']) selected @endif value="{{ $type['id'] }}">{{ $type['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Кількість прописаних осіб</label>
                                    <div class="col-sm-8">
                                        <input name="peoples" type="number" class="form-control"
                                               placeholder="Кількість прописаних осіб"
                                               value="{{ $abonent['peoples'] }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="living" class="col-sm-4 control-label">Не проживає</label>
                                    <div class="col-sm-8">
                                        <input id="living" name="status" type="checkbox"
                                               @if ($abonent['status'] == 1) checked @endif
                                               value="{{ $abonent['status'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                </div>

                <h2 class="inner-tittle">Послуги</h2>
                <div id="card_services" class="grid-1">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        @foreach($abonent['providers'] as $balance)
                                            <div class="col-md-12 text-left">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-md-4 text-left">{{ $balance['provider']['title'] }}</label>
                                                        <div class="col-md-6 text-left">
                                                            <p class="@if($balance['balance'] < 0) balanceMinus @else balancePlus @endif">@money($balance['balance']) грн.</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        @foreach($abonent['services'] as $service)
                                            <div
                                                class="servicesTabs wrap-{{ $service['id'] }} ">

                                                <label onclick="tabShow('tab-{{ $service['id'] }}')"
                                                       class="serv @if ( $service['status'] != 1) notActive @endif"
                                                       for="tab-{{ $service['id'] }}">
                                                    <div>
                                                        <p>{{ $service['name'] }}</p>
                                                        <span class="balance">Баланс: {{ $service['balance'] }}</span>
                                                    </div>
                                                    <div class="cross"></div>
                                                </label>

                                                <div id="tab-{{ $service['id'] }}" class="content">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="control-label">Тариф</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @isset ($service['tariff']['id'])
                                                            <select disabled="" class="form-control1" name="" id="">
                                                                @foreach ($service['available_tariffs'] as $av_tariff)
                                                                    <option @if ($av_tariff['id'] == $service['tariff']['id']) selected @endif value="{{ $av_tariff['id'] }}">
                                                                        (@money($av_tariff['value'])) {{ $av_tariff['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @endisset
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary" onclick="modal.payment({{ $service }})"><i class="fa fa-dollar"></i> <span>Внести оплату</span></button>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="switch-main">
                                                                <div class="onoffswitch">
                                                                    <input type="hidden"
                                                                           name="services[{{ $service['id'] }}][id]"
                                                                           value="{{ $service['id'] }}">

                                                                    <input type="hidden"
                                                                           name="services[{{ $service['id'] }}][status]"
                                                                           value="0">

                                                                    <input type="checkbox"
                                                                           name="services[{{ $service['id'] }}][status]"
                                                                           class="onoffswitch-checkbox"
                                                                           id="myonoffswitch-{{ $service['id'] }}"
                                                                           @if ( $service['status'] == 1) checked
                                                                           @endif value="1">
                                                                    <label class="onoffswitch-label"
                                                                           for="myonoffswitch-{{ $service['id'] }}">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h2 class="tableTitle">Історія</h2>
                                                            <div class="overflowBlock">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Дата</th>
                                                                        <th>Тип операції</th>
                                                                        <th>Джерело надходження</th>
                                                                        <th>Сума</th>
                                                                        <th>Автор</th>
                                                                        <th>Операції</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    {{--
                                                                    TODO Додати перевірку на наявність записів по послузі
                                                                    --}}
                                                                    @if($abonent['history']->isNotEmpty())
                                                                    @isset($abonent['history'][$service['id']])
                                                                        @foreach($abonent['history'][$service['id']] as $item)
                                                                            <tr id="payment_{{ $item['id'] }}" class="@if ($item['title'] == 'Списання') outcome @else income @endif">
                                                                                <td>@date($item['created_at'])</td>
                                                                                <td>{{ $item['title'] }}</td>
                                                                                <td>@if ($item['title'] == 'Списання' || $item['title'] == 'Корекція')  @else {{ $item['source']['name'] }} @endif</td>
                                                                                <td>{{ $item['value'] }}</td>
                                                                                <td>{{ $item->author['name'] }}</td>
                                                                                <td>
                                                                                    @isset($item['allow_cancel'])
                                                                                        <button type="button" onclick="payment.delete({{ $item['id'] }})" class="tooltips @if ($item['allow_cancel'] === 0) disabled @endif" href="#"><span>Скасувати платіж</span><i class="lnr lnr-undo"></i></button>
                                                                                    @endisset
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endisset
                                                                    @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="row-flex">
                    <div class="flex-child-50">
                        <h2 class="inner-tittle">Прописані особи</h2>
                    </div>
                    <div class="flex-child-50 text-right">
                        <button data-toggle="modal" data-target="#add_person" type="button" class="btn btn-primary">
                            Додати особу
                        </button>
                    </div>
                </div>

                <div class="grid-1">
                    <div class="col-md-12">
                        <div class="overflowBlock" id="family_list">
                            <table class="table" id="family_content">
                                <thead>
                                <tr>
                                    <th>Дата формування</th>
                                    <th>Прізвище</th>
                                    <th>Ім'я</th>
                                    <th>По батькові</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($family as $person)
                                    <input type="hidden"
                                           name="persons[{{ $person['id'] }}][id]"
                                           value="{{ $person['id'] }}">
                                    <tr>
                                        <td>{{$person['created_at']}}</td>
                                        <td><input
                                                name="persons[{{ $person['id'] }}][last_name]"
                                                type="text"
                                                class="form-control"
                                                placeholder="Прізвище"
                                                value="{{$person['last_name']}}"></td>
                                        <td><input
                                                name="persons[{{ $person['id'] }}][first_name]"
                                                type="text"
                                                class="form-control"
                                                placeholder="Ім'я"
                                                value="{{$person['first_name']}}"></td>
                                        <td><input
                                                name="persons[{{ $person['id'] }}][second_name]}}"
                                                type="text"
                                                class="form-control"
                                                placeholder="По батькові"
                                                value="{{$person['second_name']}}"></td>
                                        <td><div class="col-md-1">
                                                <button type="button"
                                                        onclick="person.remove({{ $person['id'] }}, {{ $person['abonent_id'] }})"
                                                        class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                                </button>
                                            </div></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <h2 class="inner-tittle">Договори</h2>
                <div class="grid-1">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        @foreach($abonent['contracts'] as $contract)
                                            <input type="hidden"
                                                   name="contracts[{{ $contract['provider_id'] }}][provider_id]"
                                                   value="{{ $contract['provider_id'] }}">
                                            <div class="row">
                                                <h3 class="text-center">{{ $contract['provider_name'] }}</h3>
                                                <hr>
                                                <div class="col-md-6 text-left">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Номер
                                                                договору</label>
                                                            <div class="col-sm-8">
                                                                <input
                                                                    name="contracts[{{ $contract['provider_id'] }}][title]"
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="Номер договору"
                                                                    value="{{ $contract['title'] }}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-left">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Дата
                                                                заключення</label>
                                                            <div class="col-sm-8">
                                                                <input
                                                                    name="contracts[{{ $contract['provider_id'] }}][date]"
                                                                    type="date"
                                                                    class="form-control"
                                                                    placeholder="Дата заключення"
                                                                    value="{{ $contract['date'] }}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row-flex">
                    <div class="flex-child-50">
                        <h2 class="inner-tittle">Лічильники</h2>
                    </div>
                    <div class="flex-child-50 text-right">
                        <button data-toggle="modal" data-target="#add_meter" type="button" class="btn btn-primary">
                            Додати лічильник
                        </button>
                    </div>
                </div>


                <div class="grid-1">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group" id="card_meters">
                                    <div class="col-sm-12" id="meters_content">
                                        @foreach($abonent['meters'] as $meter)
                                            <input type="hidden" value="{{ $meter['meter_id'] }}"
                                                   name="meters[{{ $meter['meter_id'] }}][meter_id]">
                                            <div
                                                class="servicesTabs wrap-{{ $meter['meter_id'] }} @if ( $meter['archived'] == 1) notActive @endif">

                                                <label onclick="tabShow('tab-{{ $meter['meter_id'] }}')" class="serv"
                                                       for="">

                                                    <div>{{ $meter['title'] }}
                                                        <span
                                                            class="balance">Поточний показник: {{ $meter['counter'] }}</span>
                                                    </div>
                                                    <div class="cross"></div>
                                                </label>

                                                <div id="tab-{{ $meter['meter_id'] }}" class="content">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-body">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Номер
                                                                            лічильника</label>
                                                                        <div class="col-sm-8">
                                                                            <input
                                                                                name="meters[{{ $meter['meter_id'] }}][code]"
                                                                                type="text"
                                                                                class="form-control"
                                                                                placeholder="Номер лічильника"
                                                                                value="{{ $meter['code'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Код
                                                                            пломби</label>
                                                                        <div class="col-sm-8">
                                                                            <input
                                                                                name="meters[{{ $meter['meter_id'] }}][code_plomb]"
                                                                                type="text"
                                                                                class="form-control"
                                                                                placeholder="Код пломби"
                                                                                value="{{ $meter['code_plomb'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Розташування
                                                                            лічильника</label>
                                                                        <div class="col-sm-8">
                                                                            <input
                                                                                name="meters[{{ $meter['meter_id'] }}][title]"
                                                                                type="tel"
                                                                                class="form-control"
                                                                                placeholder="Розташування лічильника"
                                                                                value="{{ $meter['title'] }}">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="form-body">
                                                                <div class="form-horizontal">

                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Дата
                                                                            останньої повірки</label>
                                                                        <div class="col-sm-8">
                                                                            <input
                                                                                name="meters[{{ $meter['meter_id'] }}][last_check]"
                                                                                type="date"
                                                                                class="form-control"
                                                                                placeholder="Дата останньої повірки"
                                                                                value="{{ $meter['last_check'] }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Дата
                                                                            наступної повірки</label>
                                                                        <div class="col-sm-8">
                                                                            <input
                                                                                name="meters[{{ $meter['meter_id'] }}][next_check]"
                                                                                type="date"
                                                                                class="form-control"
                                                                                placeholder="Дата наступної повірки"
                                                                                value="{{ $meter['next_check'] }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            class="col-sm-4 control-label">Послуги</label>
                                                                        <div class="col-sm-8">
                                                                            @foreach($meter['services'] as $m_service)
                                                                                <div class="meter_service">
                                                                                    <input
                                                                                        name="meters[{{ $meter['meter_id'] }}][services][{{ $m_service->pivot->service_id }}][service_id]"
                                                                                        type="hidden"
                                                                                        value="{{ $m_service->pivot->service_id }}">
                                                                                    <input
                                                                                        name="meters[{{ $meter['meter_id'] }}][services][{{ $m_service->pivot->service_id }}][status]"
                                                                                        type="hidden"
                                                                                        value="0">
                                                                                    <input
                                                                                        name="meters[{{ $meter['meter_id'] }}][services][{{ $m_service->pivot->service_id }}][status]"
                                                                                        type="checkbox"
                                                                                        id="m_service_{{ $m_service->pivot->service_id }}_{{ $meter['meter_id'] }}"
                                                                                        value="1"
                                                                                        @if ($m_service->pivot->status == 1) checked @endif>
                                                                                    <label
                                                                                        for="m_service_{{ $m_service->pivot->service_id }}_{{ $meter['meter_id'] }}">{{ $m_service['name'] }}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <button type="button"
                                                                    onclick="meter.remove({{ $meter['meter_id'] }}, {{ $abonent['id'] }})"
                                                                    class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </div>


                                                        <div class="clearfix"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h2 class="tableTitle">Показники</h2>
                                                            <div class="overflowBlock">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Дата</th>
                                                                        <th>Значення</th>
                                                                        <th>Автор</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($meter['counters'] as $counter)
                                                                        <tr>
                                                                            <td>@date($counter['created_at'])</td>
                                                                            <td>{{ $counter['value'] }}</td>
                                                                            <td>{{ $counter['author']['name'] }}</td>
                                                                        </tr>
                                                                    @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <h2 class="inner-tittle">Квитанції</h2>
                <div class="grid-1">

                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="tableTitle">Перелік квитанцій</h2>
                            <div class="overflowBlock">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Дата формування</th>
                                        <th>Статус</th>
                                        <th>Автор</th>
                                        <th>Остання зміна</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($abonent['receipts'] as $receipt)
                                        <tr>
                                            <td>@date($receipt['created_at'])</td>
                                            <td>{{ $receipt['status']['title'] }}</td>
                                            <td>{{ $receipt['author']['name'] }}</td>
                                            <td>@date($receipt['updated_at'])</td>
                                            <td><a class="tooltips" href="/receipts/{{ $receipt['id'] }}"><span>Переглянути</span><i
                                                        class="fa fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="clearfix"></div>
                </div>




        <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-success" type="submit">Зберегти</button>
            </div>
            <div class="col-md-6 text-right">
                <button data-toggle="modal" data-target="#delete_abonent" class="btn btn-danger" type="button">Перемістити у архів</button>
            </div>
        </div>
        </div>
            </form>
                <!--//forms-->
        </div>
    </div>



    <div class="modal fade modalCustom" id="delete_abonent" tabindex="-1" role="dialog" aria-labelledby="delete_abonent" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">
            <form class="modal-content" action="/abonents/delete/{{ $abonent['id'] }}" method="post">
                @csrf
                <input type="hidden" value="{{ $abonent['id'] }}" name="abonent_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Підтвердження дії</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <p>Ви дійсно хочете перемістити абонента {{ $abonent['name'] }} до архіву?</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Так</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ні</button>
                </div>
            </form>
        </div>
    </div>




    <div class="modal fade modalCustom" id="add_meter" tabindex="-1" role="dialog" aria-labelledby="add_meter"
         aria-hidden="true" style="display: none;">

        <div class="modal-dialog">
            <form class="modal-content" action="javascript:void(null);" onsubmit="meter.add()" method="post">
                @csrf
                <input type="hidden" value="{{ $abonent['id'] }}" name="abonent_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Додавання лічильника</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Номер
                                            лічильника</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="code"
                                                type="text"
                                                class="form-control"
                                                placeholder="Номер лічильника"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Код
                                            пломби</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="code_plomb"
                                                type="text"
                                                class="form-control"
                                                placeholder="Код пломби"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Розташування
                                            лічильника</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="title"
                                                type="tel"
                                                class="form-control"
                                                placeholder="Розташування лічильника"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Початковий показник</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="counter"
                                                type="tel"
                                                class="form-control"
                                                placeholder="Початковий показник"
                                                value="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Дата
                                            останньої повірки</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="last_check"
                                                type="date"
                                                class="form-control"
                                                placeholder="Дата останньої повірки"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Дата
                                            наступної повірки</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="next_check"
                                                type="date"
                                                class="form-control"
                                                placeholder="Дата наступної повірки"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            class="col-sm-4 control-label">Послуги</label>
                                        <div class="col-sm-8">
                                            @foreach($services as $service)
                                                <div class="meter_service">
                                                    <input
                                                        name="services[{{ $service['id'] }}][service_id]"
                                                        type="hidden"
                                                        value="{{ $service['id'] }}">
                                                    <input type="hidden" value="{{ $abonent['id'] }}"
                                                           name="services[{{ $service['id'] }}][abonent_id]">

                                                    <input
                                                        name="services[{{ $service['id'] }}][status]"
                                                        type="hidden"
                                                        value="0">
                                                    <input
                                                        name="services[{{ $service['id'] }}][status]"
                                                        type="checkbox"
                                                        id="m_service_{{ $service['id'] }}"
                                                        value="1">
                                                    <label
                                                        for="m_service_{{ $service['id'] }}">{{ $service['name'] }}</label>
                                                </div>
                                            @endforeach
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

    <div class="modal fade modalCustom" id="add_person" tabindex="-1" role="dialog" aria-labelledby="add_people"
         aria-hidden="true" style="display: none;">

        <div class="modal-dialog">
            <form class="modal-content" action="javascript:void(null);" onsubmit="person.add()" method="post">
                @csrf
                <input type="hidden" value="{{ $abonent['id'] }}" name="abonent_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Додавання особи</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Прізвище</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="last_name"
                                                type="text"
                                                class="form-control"
                                                placeholder="Прізвище"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Ім'я</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="first_name"
                                                type="text"
                                                class="form-control"
                                                placeholder="Ім'я"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">По батькові</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="second_name"
                                                type="tel"
                                                class="form-control"
                                                placeholder="По батькові"
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




    <div class="modal fade modalCustom" id="add_payment" tabindex="-1" role="dialog" aria-labelledby="add_payment"
         aria-hidden="true" style="display: none;">

        <div class="modal-dialog">
            <form id="paymentAddForm" class="modal-content" action="javascript:void(null);" onsubmit="payment.add()" method="post">
                @csrf
                <input type="hidden" value="{{ $abonent['id'] }}" name="abonent_id">
                <input type="hidden" value="{{ $user['id'] }}" name="author_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Оплата</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">
                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Послуга</label>
                                        <div class="col-sm-8">
                                            <input id="service_name"
                                                name="service_name"
                                                type="text"
                                                class="form-control"
                                                disabled="disabled"
                                                value="">
                                            <input id="service_id"
                                                name="service_id"
                                                type="hidden"
                                                class="form-control"
                                                value="">
                                        </div>
                                        </div>
                                        <div class="form-group">

                                        <label class="col-sm-4 control-label">Джерело надходження</label>
                                        <div class="col-sm-8">
                                            <select class="form-control1" name="source_id" id="">
                                                @foreach($sources as $source)
                                                    <option selected value="{{ $source['id'] }}">{{ $source['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                        <div class="form-group">

                                        <label class="col-sm-4 control-label">Сума</label>
                                        <div class="col-sm-8">
                                            <input
                                                name="value"
                                                type="text"
                                                class="form-control"
                                                placeholder="Сума платежу"
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

@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">

            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
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
                                        <input name="name" type="text" class="form-control" placeholder="ПІБ"
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
                                        <input name="personal_account" type="tel" class="form-control"
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
                                                <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Тип абонента</label>
                                    <div class="col-sm-8">
                                        <select class="form-control1" name="type_id" id="">
                                            @foreach($types as $type)
                                                <option value="{{ $type['id'] }}">{{ $type['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Кількість прописаних осіб</label>
                                    <div class="col-sm-8">
                                        <input name="peoples" type="number" class="form-control"
                                               placeholder="Кількість прописаних осіб"
                                               value="{{ $abonent['peoples'] }}">
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
                <div class="grid-1">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        @foreach($abonent['services'] as $service)
                                            <div
                                                class="servicesTabs wrap-{{ $service['id'] }} ">

                                                <label class="serv @if ( $service['status'] != 1) notActive @endif" for="tab-{{ $service['id'] }}">
                                                    <div>{{ $service['name'] }} <span
                                                            class="balance">Баланс: {{ $service['balance'] }}</span>
                                                    </div>
                                                    <div class="cross"></div>
                                                </label>

                                                <div class="content">
                                                    <div class="row">

                                                        <div class="col-md-10">
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
                                                                           @endif value="{{ $service['status'] }}">
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
                                                                        <th>Сума</th>
                                                                        <th>Автор</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($abonent['history'][$service['id']] as $item)
                                                                        <tr class="@if ($item['title'] == 'Списання') outcome @else income @endif">
                                                                            <td>{{ $item['created_at'] }}</td>
                                                                            <td>{{ $item['title'] }}</td>
                                                                            <td>{{ $item['value'] }}</td>
                                                                            <td>{{ $item->author['name'] }}</td>
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

                                </div>
                            </div>
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
                                            <input type="hidden" name="contracts[{{ $contract['provider_id'] }}][provider_id]" value="{{ $contract['provider_id'] }}">
                                        <div class="row">
                                            <h3 class="text-center">{{ $contract['provider_name'] }}</h3>
                                            <hr>
                                            <div class="col-md-6 text-left">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Номер
                                                            договору</label>
                                                        <div class="col-sm-8">
                                                            <input name="contracts[{{ $contract['provider_id'] }}][title]"
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
                                                        <label class="col-sm-4 control-label">Дата заключення</label>
                                                        <div class="col-sm-8">
                                                            <input name="contracts[{{ $contract['provider_id'] }}][date]"
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
                        <button class="btn btn-primary" onclick="meter.add({{ $abonent['id'] }})">Додати лічильник</button>
                    </div>
                </div>


                <div class="grid-1">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group" id="card_meters">
                                    <div class="col-sm-12" id="meters_content">
                                        @foreach($abonent['meters'] as $meter)
                                            <input type="hidden" value="{{ $meter['meter_id'] }}" name="meters[{{ $meter['meter_id'] }}][meter_id]">
                                            <div
                                                class="servicesTabs wrap-{{ $meter['meter_id'] }} @if ( $meter['archived'] == 1) notActive @endif">

                                                <label class="serv" for="tab-{{ $meter['meter_id'] }}">

                                                    <div>{{ $meter['title'] }}
                                                        <span class="balance">Поточний показник: {{ $meter['counter'] }}</span>
                                                    </div>
                                                    <div class="cross"></div>
                                                </label>

                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-body">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group">
                                                                        <label class="col-sm-5 control-label">Номер
                                                                            лічильника</label>
                                                                        <div class="col-sm-7">
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
                                                                                        value="1" @if ($m_service->pivot->status == 1) checked @endif>
                                                                                    <label
                                                                                        for="m_service_{{ $m_service->pivot->service_id }}_{{ $meter['meter_id'] }}">{{ $m_service['name'] }}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label
                                                                            class="col-sm-4 control-label">Тариф лічильника</label>
                                                                        <div class="col-sm-8">
                                                                                <div class="meter_service">
                                                                                    <select class="form-control1" name="meters[{{ $meter['meter_id'] }}][tariff_id]" id="">
                                                                                            <option selected
                                                                                                value="{{ $meter['tariff']['current']['id'] }}">({{ $meter['tariff']['current']['value'] }}) {{ $meter['tariff']['current']['name'] }}</option>

                                                                                        @foreach($meter['tariff']['available'] as $tariff)
                                                                                            <option value="{{ $tariff['id'] }}">({{ $tariff['value'] }}) {{ $tariff['name'] }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <button type="button" onclick="meter.remove({{ $meter['meter_id'] }})" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
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
                                                                            <td>{{ $counter['added_at'] }}</td>
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
                                            <td>{{ \Carbon\Carbon::parse($receipt['created_at'])->format('d.m.Y H:i:s') }}</td>
                                            <td>{{ $receipt['status_id'] }}</td>
                                            <td>{{ $receipt['author_id'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($receipt['updated_at'])->format('d.m.Y H:i:s') }}</td>
                                            <td><a class="tooltips" href="/receipts/{{ $receipt['id'] }}"><span>Переглянути</span><i
                                                        class="fa fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit">Зберегти</button>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>


            </form>
            <!--//forms-->
        </div>
    </div>

@endsection

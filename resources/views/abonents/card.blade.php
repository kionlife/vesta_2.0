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


            <div class="forms-main">

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
                                        <input name="phone" type="tel" class="form-control"
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
                                                class="servicesTabs wrap-{{ $service['id'] }} @if ( $service['status'] != 1) notActive @endif">
                                                <input class="hidden" type="radio" id="tab-{{ $service['id'] }}"
                                                       name="tabs">
                                                <label class="serv" for="tab-{{ $service['id'] }}">
                                                    <div>{{ $service['name'] }} <span
                                                            class="balance">Баланс: {{ $service['balance'] }}</span>
                                                    </div>
                                                    <div class="cross"></div>
                                                </label>

                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <p class="balanceService">Баланс: <span>{{ $service['balance'] }} грн</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="switch-main">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" name="onoffswitch"
                                                                           class="onoffswitch-checkbox"
                                                                           id="myonoffswitch-{{ $service['id'] }}"
                                                                           @if ( $service['status'] == 1) checked @endif>
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
                                                                        <tr>
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

                <h2 class="inner-tittle">Лічильники</h2>
                <div class="grid-1">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        @foreach($abonent['meters'] as $meter)
                                            <div
                                                class="servicesTabs wrap-{{ $meter['meter_id'] }} @if ( $meter['archived'] == 1) notActive @endif">
                                                <input class="hidden" type="radio" id="tab-{{ $meter['meter_id'] }}"
                                                       name="tabs">
                                                <label class="serv" for="tab-{{ $meter['meter_id'] }}">

                                                    <div>{{ $meter['title'] }} <span
                                                            class="balance">Поточний показник: {{ $meter['counter'] }}</span>
                                                    </div>
                                                    <div class="cross"></div>
                                                </label>

                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-body">
                                                                <div class="form-horizontal">
                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Номер
                                                                            лічильника</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="name" type="text"
                                                                                   class="form-control"
                                                                                   placeholder="Номер лічильника"
                                                                                   value="{{ $meter['code'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Код
                                                                            пломби</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="address" type="text"
                                                                                   class="form-control"
                                                                                   placeholder="Код пломби"
                                                                                   value="{{ $meter['code_plomb'] }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Розташування
                                                                            лічильника</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="phone" type="tel"
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
                                                                            <input name="phone" type="date"
                                                                                   class="form-control"
                                                                                   placeholder="Дата останньої повірки"
                                                                                   value="{{ $meter['last_check'] }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-sm-4 control-label">Дата
                                                                            наступної повірки</label>
                                                                        <div class="col-sm-8">
                                                                            <input name="phone" type="date"
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
                                                                                    <input type="checkbox"
                                                                                           id="m_service_{{ $m_service['service_id'] }}"
                                                                                           value="{{ $m_service['service_id'] }}">
                                                                                    <label
                                                                                        for="m_service_{{ $m_service['service_id'] }}">{{ $m_service['name'] }}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <h2 class="inner-tittle">Квитанції</h2>
                <div class="grid-1">
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="ПІБ"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="ПІБ"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="ПІБ"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="ПІБ"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="ПІБ"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ПІБ</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="ПІБ"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>


            </div>
            <!--//forms-->
        </div>
    </div>

@endsection

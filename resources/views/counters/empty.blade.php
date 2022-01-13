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
                    <li class="active">Показники</li>
                </ol>
            </div>
            <div class="stats-grid">
                <div class="stats-head">
                    <h4 class="title3">Абоненти без показників</h4>
                </div>
            </div>
            <div class="graph-visual tables-main">
                <h3 class="inner-tittle two">Показники</h3>
                <form action="/counters/empty/generate" class="graph">
                    <div class="tables">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Абонент</th>
                                <th>Вид послуги</th>
                                <th>Лічильник</th>
                                <th>Останній показник</th>
                                <th>Новий показник</th>
                                <th>Буде списано коштів</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($counters as $counter)
                                <input type="hidden" name="abonent[{{ $counter['abonent']['id'] }}][id]">
                                <input type="hidden" name="abonent[{{ $counter['abonent']['id'] }}][service_id]">
                                <input type="hidden" name="abonent[{{ $counter['abonent']['id'] }}][meter_id]">
                                <tr>
                                    <td>
                                        <a href="/abonents/{{ $counter['abonent']['id'] }}">{{ $counter['abonent']['name'] }}</a>
                                    </td>
                                    <td>{{ $counter['service'][0]['name']}}</td>
                                    <td>{{ $counter['meter'][0]['title'] }}</td>
                                    <td>{{ $counter['last_value'] }}</td>
                                    <td><input class="editableInput" type="text"
                                               name="abonent[{{ $counter['abonent']['id'] }}][newCounter]"
                                               value="{{ $counter['value'] }}"></td>
                                    <td></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="form-group-fixed">
                        <button class="btn btn-success" type="submit">Внести всі</button>
                    </div>
                    {{--                    {{ $counters->links('pagination::bootstrap-4') }}--}}
                </form>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>

@endsection

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
                    <h4 class="title3">Абоненти без показників ({{ $count }})</h4>
                </div>
            </div>
            <div class="graph-visual tables-main">
                @if(!empty($counters))
                <form action="/counters/empty/generate" method="post" class="graph">
                    @csrf
                    <div class="tables">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Абонент</th>
                                <th>Вид послуги</th>
                                <th>Лічильник</th>
                                <th>Останній показник</th>
                                <th>Новий показник</th>
                                <th>Кількість</th>
                                <th>Буде списано коштів</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($counters as $counter)
                                <input type="hidden" value="{{ $counter['meter_id'] }}" name="abonent[{{ $counter['abonent']['id'] }}][meter_id]">

                                <tr>
                                    <td>
                                        <a href="/abonents/{{ $counter['abonent']['id'] }}">{{ $counter['abonent']['name'] }}</a>
                                    </td>
                                    <td>
                                        {{ $counter['service_id'] }}
                                    </td>
                                    <td>{{ $counter['meter'][0]['title'] }}</td>
                                    <td>{{ $counter['last_value'] }}</td>
                                    <td>{{ $counter['value'] }}</td>
                                    <td>{{ $counter['used'] }}</td>
                                    <td>@money($counter['to_pay']) грн.</td>
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
@endif

            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>

@endsection

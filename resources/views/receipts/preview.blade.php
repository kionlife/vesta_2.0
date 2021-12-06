@extends('layouts.app')

@section('content')

    <div class="inner-content">
        <div class="outter-wp">
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Квитанції</li>
                </ol>
            </div>
            <div class="graph-visual tables-main">
                <h3 class="inner-tittle two">Квитанції</h3>

                <form class="graph" id="receipts_preview_form" action="/receipts/save" method="post">
                    @csrf
                        <div class="receiptHead">
                            <div class="row">
                                <div class="col-md-3">
                                    Абонент
                                </div>
                                <div class="col-md-9">
                                        <div class="col-md-3 col">Послуга</div>
                                        <div class="col-md-1 col">Тариф</div>
                                        <div class="col-md-3 col">
                                            <div class="col-md-12">Показники</div>
                                            <div class="col-md-4">Останній</div>
                                            <div class="col-md-4">Поточний</div>
                                            <div class="col-md-4">Спожито</div>
                                        </div>

                                        <div class="col-md-2 col">Нараховано</div>
                                        <div class="col-md-1 col">Баланс</div>
                                        <div class="col-md-2 col">До сплати</div>
                                </div>
                            </div>
                        </div>


                        @foreach ($receipts as $reсeipt)
                            <div class="row receiptRow">
                                <div class="col-md-3">
                                    <input id="ab_{{ $reсeipt['abonent_id']}}" type="checkbox"
                                           value="{{ $reсeipt['abonent_id']}}" name="abonents[]">
                                    <label for="ab_{{ $reсeipt['abonent_id']}}">({{ $reсeipt['abonent_personal_account']}}) {{ $reсeipt['abonent_name']}}</label>
                                </div>
                                <div class="col-md-9">
                                    @foreach ($reсeipt['services'] as $service)
                                            <div class="receiptCol col-md-3">{{ $service['service_title'] }}</div>
                                            <div class="receiptCol col-md-1">@money($service['tariff'])</div>
                                            <div class="receiptCol col-md-1">{{ $service['last_counter'] }}</div>
                                            <div class="receiptCol col-md-1">{{ $service['current_counter']}}</div>
                                            <div class="receiptCol col-md-1">{{ $service['used_counter']}}</div>
                                            <div class="receiptCol col-md-2">@money($service['generated'])</div>
                                            <div class="receiptCol col-md-1">@money($service['balance'])</div>
                                            <div class="receiptCol col-md-2">@money($service['to_pay'])</div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    <div class="form-group-fixed">
                        <button onclick="checkAll('receipts_preview_form')" type="button" class="btn btn-primary">Відмітити всі</button>
                        <button class="btn btn-success" type="submit">Зберегти квитанції</button>
                    </div>
                </form>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>

    <script>
        $(document).ready(function() {
            $(".sidebar-icon").click();
        })
    </script>
@endsection

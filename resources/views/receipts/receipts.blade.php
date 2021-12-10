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

                <div class="row">
                    <div class="col-md-6">
                        <h3 class="inner-tittle two">Квитанції</h3>
                    </div>

                    <div class="col-md-6 text-right">
                        <a href="/receipts/preview" class="btn btn-primary"><i class="fa fa-user"></i><span> Сформувати квитанції</span></a>
                    </div>
                </div>
                <div class="graph">
                    <div class="receiptHead">
                        <div class="row">
                            <div class="col-md-4">
                                Абонент
                            </div>
                            <div class="col-md-2 col">Статус</div>
                            <div class="col-md-6">
                                <div class="col-md-4 col">Баланс</div>
                                <div class="col-md-4 col">До сплати</div>
                                <div class="col-md-4 col">Дата формування</div>
                            </div>
                        </div>
                    </div>


                    @foreach ($receipts as $reсeipt)
                        <div class="row receiptRow">
                            <div class="col-md-4">
                                <p>({{ $reсeipt['abonent_personal_account']}}) {{ $reсeipt['abonent_name']}}</p>
                            </div>
                            <div class="col-md-2">
                                <p>{{ $reсeipt['status']['title'] }}</p>
                            </div>
                            <div class="col-md-6">
                                @foreach ($reсeipt['services'] as $service)
                                    <div class="receiptCol col-md-4">{{ $service['balance'] }}</div>
                                    <div class="receiptCol col-md-4">@money($service['to_pay'])</div>
                                    <div class="receiptCol col-md-4">@date($service['created_at'])</div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                   {{-- <div class="form-group-fixed">
                        <button onclick="checkAll('receipts_preview_form')" type="button" class="btn btn-primary">Відмітити всі</button>
                        <button class="btn btn-success" type="submit">Зберегти квитанції</button>
                    </div>--}}
                </div>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>



@endsection

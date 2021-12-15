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
                @isset($result['not_full'])
                <div class="graph">
                    <div class="tables">
                        <p>Квитанції не було сформовано через недостатню кількість даних:</p>

                        @foreach($result['not_full'] as $item)
                            @foreach($item as $service)
                                <p>
                                    <a href="/abonents/{{ $service['abonent']['id'] }}">{{ $service['abonent']['name'] }}</a>:
                                    відсутні дані по послузі - {{ $service['error_service']['name'] }}</p>
                            @endforeach
                        @endforeach
                    </div>

                </div>
                @endisset

                @isset($result['success'])
                <div class="graph">
                    <div class="tables">
                        <p>Квитанції було сформовано:</p>

                        @foreach($result['success'] as $item)
                            @foreach($item as $service)
                                <p>
                                    <a href="/abonents/{{ $service['abonent']['id'] }}">{{ $service['abonent']['name'] }}</a>:
                                    {{ $service['service']['name'] }}</p>
                                <a href="/receipt/">Переглянути квитанцію</a>
                            @endforeach
                        @endforeach
                    </div>

                </div>
                @endisset


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>



@endsection

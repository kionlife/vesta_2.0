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
                    <li class="active">Налаштування</li>
                </ol>
            </div>

                <div class="inner-content" style="overflow-x: hidden;">
                    <div class="custom-widgets">
                        <div class="row-one">


                            <div class="col-md-3">
                                <a href="/settings/abonents" class="settingsBtn">Абоненти</a>
                            </div>

                            <div class="col-md-3">
                                <a href="#" class="settingsBtn">Платежі</a>
                            </div>

                            <div class="col-md-3">
                                <a href="#" class="settingsBtn">Права та користувачі</a>
                            </div>

                            <div class="col-md-3">
                                <a href="#" class="settingsBtn">Тарифи</a>
                            </div>


                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!--//custom-widgets-->


                </div>

            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>


@endsection

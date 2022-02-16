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
                    <li><a href="/settings">Налаштування</a></li>
                    <li class="active">Абоненти</li>
                </ol>
            </div>

                <div class="inner-content" style="overflow-x: hidden;">
                    <div class="custom-widgets">
                        <div class="row-one">
                            <div class="stats-info graph">
                                <div class="stats">
                                    <form method="post" action="/payments">
                                        @csrf
                                        <div class="vali-form payment_form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Типи абонентів</label>
                                                </div>

                                                <div class="col-sm-4 form-group1">
                                                    <label class="control-label">Послуга</label>
                                                    <textarea class="form-control1" name="service_id" id="abonent_services"></textarea>
                                                    <label for="id_label_multiple">
                                                        <select class="js-example-basic-multiple js-states form-control" id="id_label_multiple" multiple="multiple"></select>
                                                    </label>
                                                </div>

                                                <div class="col-sm-2 form-group1">
                                                    <label class="control-label">Джерело надходження</label>
                                                    <select class="form-control1" name="source_id" id="">

                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row margin-top">
                                                <div class="col-md-12 text-center">
                                                    <button class="btn btn-primary" type="submit" value="">Додати платіж</button>
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="custom-widgets">
                        <div class="row-one">
                            <div class="stats-info graph">
                                <div class="stats">
                                    <form method="post" action="/payments">
                                        @csrf
                                        <div class="vali-form payment_form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Типи абонентів</label>
                                                </div>

                                                <div class="col-sm-4 form-group1">
                                                    <label class="control-label">Послуга</label>
                                                    <textarea class="form-control1" name="service_id" id="abonent_services"></textarea>
                                                    <label for="id_label_multiple">
                                                        <select class="js-example-basic-multiple js-states form-control" id="id_label_multiple" multiple="multiple"></select>
                                                    </label>
                                                </div>

                                                <div class="col-sm-2 form-group1">
                                                    <label class="control-label">Джерело надходження</label>
                                                    <select class="form-control1" name="source_id" id="">

                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row margin-top">
                                                <div class="col-md-12 text-center">
                                                    <button class="btn btn-primary" type="submit" value="">Додати платіж</button>
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
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

    <script>
        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

@endsection

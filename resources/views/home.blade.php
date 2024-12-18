@extends('layouts.app')

@section('content')

    <div class="inner-content" style="overflow-x: hidden;">
        <div class="custom-widgets">
            <div class="row-one">
                <div class="col-md-6">
                    <div class="stats-left ">
                        <h5>Сьогодні</h5>
                        <h4>Показників</h4>
                    </div>
                    <div class="stats-right">
                        <label>{{ $t_counters }}</label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-6 states-mdl">
                    <div class="stats-left">
                        <h5>Сьогодні</h5>
                        <h4>Платежів</h4>
                    </div>
                    <div class="stats-right">
                        <label>@money($t_payments) грн</label>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
        <!--//custom-widgets-->


        <!--/charts-->
        <div class="charts">
            <div class="chrt-inner">
                <div class="chrt-bars">
                    <div class="row">


                        <div class="col-md-7">
                            <div class="chrt-two">
                                <div id="chart1"></div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="set-1">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <h3 class="sub-tittle">Надходження до каси</h3>
                                    </div>
                                    <div class="col-md-3 ">
                                        <select class="stats" name="service_id" id="payments_date">
                                            <option selected="selected" value="@money($date['day']) грн">День</option>
                                            <option value="@money($date['month']) грн">Місяць</option>
                                            <option value="@money($date['year']) грн">Рік</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="degree">
                                    <span id="payments"></span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row">
                                    <div class="paymentsUser">
                                        <p>Платежів за день користувача {{ $user->name }}: <b>@money($payments_user)
                                            грн</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <!--//bottom-grids-->
    </div>

    <script>
        $(document).ready(function () {

            data = {

                @foreach($months as $month)
                '{{ $month['monthName'] }}': {{ $month['total_sum'] }},
                @endforeach
            };

            $("#chart1").faBoChart({
                time: 500,
                animate: true,
                instantAnimate: true,
                straight: true,
                data: data,
                labelTextColor: "#000",
            });
        });

    </script>

    <script>
        $("#payments_date").ready(function () {
            $("#payments").text($("#payments_date :selected").val());
        }).change(function () {
            $("#payments").text($("#payments_date :selected").val());
        });
    </script>

@endsection

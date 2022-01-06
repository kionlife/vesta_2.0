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


                        <div class="col-md-8">
                        <div class="chrt-two">
                            <div id="chart1"></div>
                        </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

<div class="set-1">
        <div class="row">
            <div class="col-md-3 ">
                <h3 class="sub-tittle">Надходження до каси</h3>
            </div>
            <div class="col-md-3 ">
                <select class="stats-right" name="service_id" id="payments_date">
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
        $(".stats-right").ready(function ()
        {
            $("#payments").text($(".stats-right :selected").val());
        }).change(function ()
        {
            $("#payments").text($(".stats-right :selected").val());
        });
    </script>

@endsection

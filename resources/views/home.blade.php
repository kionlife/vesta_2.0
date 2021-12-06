@extends('layouts.app')

@section('content')

    <div class="inner-content">
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
                    <div class="clearfix"> </div>
                </div>
                <div class="col-md-6 states-mdl">
                    <div class="stats-left">
                        <h5>Сьогодні</h5>
                        <h4>Платежів</h4>
                    </div>
                    <div class="stats-right">
                        <label>{{ $t_payments }} грн</label>
                    </div>
                    <div class="clearfix"> </div>
                </div>

                <div class="clearfix"> </div>
            </div>
        </div>
        <!--//custom-widgets-->


        <!--/charts-->
        <div class="charts">
            <div class="chrt-inner">
                <div class="chrt-bars">
                    <div class="row">

                        <div class="col-md-6 chrt-two">
                            <div id="chart1"></div>

                        </div>

                        <div class="col-md-3 form-group1">
                            <h3 class="sub-tittle">Надходження до каси</h3>
                        </div>
                        <div class="col-sm-3 form-group1">
                            <select class="stats-right" name="service_id" id="abonent_services">
                                <option value="day">День</option>
                                <option value="day">Місяць</option>
                                <option value="day">Рік</option>
                            </select>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <div class="graph-visualization">
            <div class="col-md-6 map-1">
                <h3 class="sub-tittle">Погода</h3>
                <div class="weather">
                    <div class="weather-top">
                        <div class="weather-top-left">
                            <div class="degree">
                                <span>Не так і холодно, но холодно</span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--//bottom-grids-->

    </div>
    <!--/charts-inner-->
    </div>

    <script>
        $(document).ready(function () {
            data = {
                '2010': 300,
                '2011': 200,
                '2012': 100,
                '2013': 500,
                '2014': 400,
                '2015': 200
            };

            $("#chart1").faBoChart({
                time: 500,
                animate: true,
                instantAnimate: true,
                straight: false,
                data: data,
                labelTextColor: "#002561",

                ajax: {
                    url: '/home/months',
                    dataType: 'json',
                    type: "GET",
                    data: function (data) {
                        return {
                            keyword: data.term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: $.map(response, function (response) {
                                return {
                                    text: '(' + response.personal_account + ') ' + response.name,
                                    id: response.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

@endsection

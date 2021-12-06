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
        <div class="chrt-bars">
            <div class="col-md-6 chrt-two">
                <h3 class="sub-tittle">Bar Chart </h3>
                <div id="chart2" class="fabo-chart"><div class="fabo-point" style="padding-left: 2px; width: 16.6667%;"><div class="fabo-point-inner" style="background-color: rgb(204, 204, 204);"><div class="fabo-value-label" style="color: rgb(0, 37, 97);">2010</div><div class="fabo-value-text" style="color: rgb(0, 198, 215);">300</div><div class="fabo-value" style="border-right-color: rgb(0, 37, 97); border-left-color: rgb(0, 37, 97); border-right-width: 105px; height: 60%;"></div></div></div><div class="fabo-point" style="padding-left: 2px; width: 16.6667%;"><div class="fabo-point-inner" style="background-color: rgb(204, 204, 204);"><div class="fabo-value-label" style="color: rgb(0, 37, 97);">2011</div><div class="fabo-value-text" style="color: rgb(0, 198, 215);">200</div><div class="fabo-value" style="border-right-color: rgb(0, 37, 97); border-left-color: rgb(0, 37, 97); border-right-width: 105px; height: 40%;"></div></div></div><div class="fabo-point" style="padding-left: 2px; width: 16.6667%;"><div class="fabo-point-inner" style="background-color: rgb(204, 204, 204);"><div class="fabo-value-label" style="color: rgb(0, 37, 97);">2012</div><div class="fabo-value-text" style="color: rgb(0, 198, 215);">100</div><div class="fabo-value" style="border-right-color: rgb(0, 37, 97); border-left-color: rgb(0, 37, 97); border-right-width: 105px; height: 20%;"></div></div></div><div class="fabo-point" style="padding-left: 2px; width: 16.6667%;"><div class="fabo-point-inner" style="background-color: rgb(204, 204, 204);"><div class="fabo-value-label" style="color: rgb(0, 37, 97);">2013</div><div class="fabo-value-text" style="color: rgb(0, 198, 215);">500</div><div class="fabo-value" style="border-right-color: rgb(0, 37, 97); border-left-color: rgb(0, 37, 97); border-right-width: 105px; height: 100%;"></div></div></div><div class="fabo-point" style="padding-left: 2px; width: 16.6667%;"><div class="fabo-point-inner" style="background-color: rgb(204, 204, 204);"><div class="fabo-value-label" style="color: rgb(0, 37, 97);">2014</div><div class="fabo-value-text" style="color: rgb(0, 198, 215);">400</div><div class="fabo-value" style="border-right-color: rgb(0, 37, 97); border-left-color: rgb(0, 37, 97); border-right-width: 105px; height: 80%;"></div></div></div><div class="fabo-point" style="padding-left: 2px; width: 16.6667%;"><div class="fabo-point-inner" style="background-color: rgb(204, 204, 204);"><div class="fabo-value-label" style="color: rgb(0, 37, 97);">2015</div><div class="fabo-value-text" style="color: rgb(0, 198, 215);">200</div><div class="fabo-value" style="border-right-color: rgb(0, 37, 97); border-left-color: rgb(0, 37, 97); border-right-width: 105px; height: 40%;"></div></div></div></div>
                <script src="js/fabochart.js"></script>
                <script>
                    $(document).ready(function () {
                        data = {
                            '2010' : 300,
                            '2011' : 200,
                            '2012' : 100,
                            '2013' : 500,
                            '2014' : 400,
                            '2015' : 200
                        };

                        $("#chart1").faBoChart({
                            time: 500,
                            animate: true,
                            instantAnimate: true,
                            straight: false,
                            data: data,
                            labelTextColor : "#002561",
                        });
                        $("#chart2").faBoChart({
                            time: 2500,
                            animate: true,
                            data: data,
                            straight: true,
                            labelTextColor : "#002561",
                        });
                    });
                </script>
            </div>

        </div>

        <!--/charts-->
        <div class="charts">
            <div class="chrt-inner">
                <div class="chrt-bars">
                    <div class="row">
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

                    <div class="col-md-6 chrt-two">
                        <div id="chart2"></div>
                        <script src="public/js/fabochart.js"></script>
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
                                });
                                $("#chart2").faBoChart({
                                    time: 2500,
                                    animate: true,
                                    data: data,
                                    straight: true,
                                    labelTextColor: "#002561",
                                });
                            });
                        </script>
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

@endsection

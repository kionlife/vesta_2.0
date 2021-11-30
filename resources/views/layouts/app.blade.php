<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'/>
    <link href="{{ asset('public/css/style.css') }}" rel='stylesheet' type='text/css'/>
    <link href="{{ asset('public/css/font-awesome.css') }}" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
          type='text/css'>
    <link rel="stylesheet" href="{{ asset('public/css/icon-font.min.css') }}" type='text/css'/>
    <script src="{{ asset('public/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('public/js/main.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>

<body>

<div class="page-container">
    <div class="left-content">
        @yield('content')
    </div>
    <div class="sidebar-menu">
        <header class="logo">
            <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="/"> <span id="logo"> <h1>Vesta</h1></span>
                <!--<img id="logo" src="" alt="Logo"/>-->
            </a>
        </header>
        <div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
        <!--/down-->
        <div class="down">
            <img style="width: 110px;" src="/public/images/user.png">
            <span class=" name-caret">{{ $user->name }}</span>
            <p style="text-transform: uppercase;">{{ $user->roles->first()->name }}</p>
            <ul>
                <li><a class="tooltips" href="index.html"><span>Профіль</span><i class="lnr lnr-user"></i></a></li>
                <li><a class="tooltips" href="index.html"><span>Налаштування</span><i class="lnr lnr-cog"></i></a></li>
                <li><a class="tooltips" href="index.html"><span>Вихід</span><i class="lnr lnr-power-switch"></i></a></li>
            </ul>
        </div>
        <!--//down-->
        <div class="menu">
            <ul id="menu" >
                <li><a href="/"><i class="fa fa-home"></i> <span>Головна</span></a></li>
                <li><a href="/counters"><i class="fa fa-tachometer"></i> <span>Показники</span></a></li>
                <li><a href="/abonents"><i class="fa fa-users"></i> <span>Абоненти</span></a></li>
                <li><a href="/"><i class="fa fa-book"></i> <span>Квитанції</span></a></li>
                <li><a href="/"><i class="fa fa-edit"></i> <span>Коригування балансів</span></a></li>
                <li><a href="/"><i class="fa fa-usd"></i> <span>Платежі</span></a></li>

            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <script>
        var toggle = true;

        $(".sidebar-icon").click(function() {
            if (toggle)
            {
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $("#menu span").css({"position":"absolute"});
            }
            else
            {
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function() {
                    $("#menu span").css({"position":"relative"});
                }, 400);
            }

            toggle = !toggle;
        });
    </script>
</div>

{{--<script src="{{ asset('public/js/jquery.nicescroll.js') }}"></script>--}}
<script src="{{ asset('public/js/scripts.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'/>
    <link href="{{ asset('public/css/select2.min.css') }}" rel='stylesheet' type='text/css'/>
    <link href="{{ asset('public/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/fabochart.css') }}" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
          type='text/css'>
    <link rel="stylesheet" href="{{ asset('public/css/icon-font.min.css') }}" type='text/css'/>
    <link href="{{ asset('public/css/style.css') }}" rel='stylesheet' type='text/css'/>

    <script src="{{ asset('public/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('public/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/js/i18n/uk.js') }}"></script>

    <script src="{{ asset('public/js/main.js') }}"></script>
    <script src="{{ asset('public/js/html2canvas.min.js') }}"></script>
    <!-- Chatra {literal} -->
    <script>
        (function(d, w, c) {
            w.ChatraID = 'xbAYW8gimQWxboeQj';
            var s = d.createElement('script');
            w[c] = w[c] || function() {
                (w[c].q = w[c].q || []).push(arguments);
            };
            s.async = true;
            s.src = 'https://call.chatra.io/chatra.js';
            if (d.head) d.head.appendChild(s);
        })(document, window, 'Chatra');
    </script>
    <!-- /Chatra {/literal} -->

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
                <li><a class="tooltips disabled" href="#"><span>Профіль</span><i class="lnr lnr-user"></i></a></li>
                <li><a class="tooltips disabled" href="#"><span>Налаштування</span><i class="lnr lnr-cog"></i></a></li>
                <li><a class="tooltips" href="{{ url('/logout') }}"><span>Вихід</span><i class="lnr lnr-power-switch"></i></a></li>
            </ul>
        </div>
        <!--//down-->
        <div class="menu">
            <ul id="menu" >
                <li><a href="/"><i class="fa fa-home"></i> <span>Головна</span></a></li>
                <li><a href="/counters"><i class="fa fa-tachometer"></i> <span>Показники</span></a></li>
                <li><a href="/abonents"><i class="fa fa-users"></i> <span>Абоненти</span></a></li>
                <li><a href="/receipts"><i class="fa fa-book"></i> <span>Квитанції</span></a></li>
                <li><a class="disabled" href="#"><i class="fa fa-bookmark"></i> <span>Звітність</span></a></li>
                @can('make corrections')
                    <li><a href="/corrections"><i class="fa fa-edit"></i> <span>Коригування балансів</span></a></li>
                @endcan
                <li><a href="/payments"><i class="fa fa-usd"></i> <span>Платежі</span></a></li>

                <button class="screenBtn"><i class="fa fa-camera"></i></button>

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
<script src="{{ asset('public/js/fabochart.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
</body>
</html>

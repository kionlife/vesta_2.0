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
<div class="error_page error">
    <div class="error-top error">
        <h3>4<i class="fa fa-smile-o"></i>4</h3>
        <span>Щось пішло не так</span>
        <p>{{ $response['message'] }}</p>
        <div class="error-btn">
            <a class="read fourth" href="/">Повернутись на головну</a>
        </div>
    </div>
</div>
<div class="footer error">
</div>
</body>
</html>

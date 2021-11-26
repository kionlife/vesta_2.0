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

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>

<body>


    <div class="error_page">
        <div class="error-top">
            <div class="login">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <input name="email" type="text" class="text @error('email') is-invalid @enderror" placeholder="Лоґін">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <input name="password" type="password" class="@error('password') is-invalid @enderror""
                    placeholder="Пароль">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                    <div class="submit"><input type="submit" value="Вхід"></div>
                    <div class="clearfix"></div>

                    <div class="new">
                        <p class="sign"><a href="sign.html">Забули пароль?</a></p>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <div class="footer">
        <p>Розроблено <a href="https://tsukr.tech/" target="_blank">tsukr.tech</a></p>
    </div>

</body>
</html>

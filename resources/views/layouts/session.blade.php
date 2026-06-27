<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>
        <title>
            {{ config('app.name') }}
        </title>
        <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/png"/>
        <link href="{{ asset('fonts/awesome/all.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/bootstrap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/user.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('js/assets/notification.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/loader.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/user.js?v=' . config('app.version')) }}" type="text/javascript"></script>
    </head>
    <body>
        <!-- loader -->
        <loader></loader>
        <!-- content -->
        @yield('content')
        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    </body>
</html>

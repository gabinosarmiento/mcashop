<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            {{ config('app.name') }}
        </title>
        <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/png"/>
        <link href="{{ asset('fonts/roboto/roboto.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/awesome/all.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/bootstrap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/flatcomplete.min.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/wenk.min.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/confirm.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/overlap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/user.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('js/assets/notification.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/flatcomplete.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/loader.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/confirm.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/overlap.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/tool.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/user.js?v=' . config('app.version')) }}" type="text/javascript"></script>
    </head>
    <body>
        <loader></loader>
        <div class="dashboard">
            <header>
                @include('administrative.navbar')
            </header>
            <main>
                @yield('content')
            </main>
            <footer>
                @include('partials.version')
            </footer>
        </div>
        <div id="overapp" class="overlap"></div>
        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    </body>
</html>
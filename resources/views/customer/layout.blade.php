<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>
        <title>
            {{ config('app.name') }}
        </title>
        <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/png"/>
        <link href="{{ asset('fonts/roboto/roboto.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/awesome/all.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/bootstrap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/wenk.min.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/overlap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/site.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/user.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('js/assets/notification.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/imgloader.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/loader.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/overlap.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/site.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/user.js?v=' . config('app.version')) }}" type="text/javascript"></script>
    </head>
    <body>
        @include('customer.mobile')
        <div class="dashboard">
            <loader></loader>
            <header>
                @include('partials.navbar', ['search' => false])
            </header>
            <main>
                @yield('content')
            </main>
            <footer>
                @include('customer.version')
            </footer>
        </div>
        <div id="overlap-one" class="overlap"></div>
        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script>
            document.querySelectorAll("[data-active]").forEach(el => {
                console.log(location.pathname.startsWith(el.dataset.active));
                if (location.pathname.startsWith(el.dataset.active)) {
                    el.classList.add("active");
                }
            });
        </script>
    </body>
</html>

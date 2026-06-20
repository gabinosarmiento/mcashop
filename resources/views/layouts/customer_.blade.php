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
        <link href="{{ asset('fonts/roboto/roboto.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/nunito/nunito.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/awesome/all.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/bootstrap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/tool.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/wenk.min.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/overlap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/site.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/user.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>

        <script src="{{ asset('js/assets/notification.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/imgloader.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/loader.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/tool.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/overlap.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/site.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/user.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        @env('production')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-F9ZPZVBTCL"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-F9ZPZVBTCL');
        </script>
        <script>
            document.addEventListener('click', function(e) {
                const click = e.target.closest('[id^="action-cart-add-"]');
                if (click) {
                    const sku = click.dataset.sku;
                    const name = click.dataset.name;
                    const price = parseFloat(click.dataset.price);
                    const quantity = parseInt(click.dataset.extra);
                    gtag('event', 'add_to_cart', {
                        currency: 'MXN',
                        value: price * quantity,
                        items: [{
                            item_id: sku,
                            item_name: name,
                            price: price,
                            quantity: quantity
                        }]
                    });
                }
            });
        </script>
        @endenv
    </head>
    <body>
        @yield('mobile')
        @sectionMissing('mobile')
        @include('partials.mobile')
        @endif

        <div class="dashboard">
            <loader></loader>
            @include('customer.mobile')
            <header>
                @include('partials.navbar')
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
    </body>
</html>

<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="google-site-verification" content="7PwyRRv6AQHSvmnYZlgKttGlXm5AFPpPdSclKHNkiNk"/>
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>
        <meta name="description" content="@yield('description', 'Descubre una amplia selección de productos de alta calidad en nuestra tienda en línea. Ofrecemos cotizaciones personalizadas para que tu experiencia de compra sea sencilla. ¡Encuentra lo que necesitas hoy mismo!')"/>
        @yield('metatag')
        <title>
            @yield('title', 'MCAShop - Todo lo que necesitas en tecnología y productos de cómputo.')
        </title>
        <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/png"/>
        <link href="{{ asset('fonts/roboto/roboto.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/nunito/nunito.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('fonts/awesome/all.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/bootstrap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/overlap.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/dofinder.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/tool.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/user.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/site.css?v=' . config('app.version')) }}" rel="stylesheet" type="text/css"/>
        <link rel="preload" href="{{ asset('css/magiczoomplus.css') }}" as="style" onload="this.rel='stylesheet'"/>
        <link rel="preload" href="{{ asset('css/cookie.css') }}" as="style" onload="this.rel='stylesheet'"/>
        <script src="{{ asset('js/assets/notification.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/assets/imgloader.js?v=' . config('app.version')) }}" type="text/javascript" async></script>
        <script src="{{ asset('js/assets/loader.js?v=' . config('app.version')) }}" type="text/javascript" async></script>
        <script src="{{ asset('js/tool.js?v=' . config('app.version')) }}" type="text/javascript"></script>
        <script src="{{ asset('js/overlap.js?v=' . config('app.version')) }}" type="text/javascript" async></script>
        <script src="{{ asset('js/dofinder.js?v=' . config('app.version')) }}" type="text/javascript" async></script>
        <script src="{{ asset('js/user.js?v=' . config('app.version')) }}" type="text/javascript" async></script>
        <script src="{{ asset('js/site.js?v=' . config('app.version')) }}" type="text/javascript" async></script>
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
        <div class="content">
            <loader></loader>
            @hasSection('mobile')
            @yield('mobile')
            @else
            @include('partials.mobile')
            @endif
            <header>
                @include('partials.navbar')
                @include('partials.subnavbar')
            </header>
            <main>
                <h1 style="display:none">
                    ¡Bienvenido a MCAShop! Aquí encontrarás todo lo que necesitas en equipos de cómputo, accesorios y consumibles para llevar tu productividad al siguiente nivel.
                </h1>
                @yield('content')
            </main>
            <footer>
                @include('site.footer')
                @include('partials.cookies')
            </footer>
        </div>
        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/cookie.js') }}" type="text/javascript" async></script>
        <script src="{{ asset('js/magiczoomplus.js') }}" type="text/javascript" async></script>
        @vite(['resources/js/app.js'])
    </body>
</html>

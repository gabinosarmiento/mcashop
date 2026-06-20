@extends('layouts.site')
@section('content')
<div class="wrapper-bottom">
    <div class="container">
        {{ Breadcrumbs::render('carrito') }}
        <h2 class="section-title">
            Estás a un paso de disfrutar tu compra
            <div class="section-subtitle">
                El precio y la disponibilidad de los productos de <strong>{{ env('APP_NAME') }}</strong> están sujetos a cambio.
                <span class="d-block text-primary">
                    Los gastos de envío se calculan en la pantalla de pagos
                </span>
            </div>
        </h2>
        <div id="products-html">
            @include('cart.products')
        </div>
    </div>
</div>
@endsection

@extends('layouts.customer')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('carrito') }}
    <h2 class="section-title">
        Estás a un paso de disfrutar tu compra
        <div class="section-message">
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
@endsection
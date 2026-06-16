@extends('layouts.customer')
@section('content')
<div class="container">
    <div class="breadcrumbs">
        {{ Breadcrumbs::render('carrito/depositar') }}
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto text-center">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="pet-wrapper mb-4">
                    <span class="sparkle sparkle-1">
                        <i class="fas fa-sparkle"></i>
                    </span>
                    <span class="sparkle sparkle-2">
                        <i class="fas fa-sparkle"></i>
                    </span>
                    <span class="sparkle sparkle-3">
                        <i class="fas fa-sparkle"></i>
                    </span>
                    <span class="sparkle sparkle-4">
                        <i class="fas fa-sparkle"></i>
                    </span>
                    <div class="img-container pet-container">
                        <img src="{{ asset('images/happy.png') }}" class="img-fluid"/>
                    </div>
                </div>
                <h2 class="section-title mb-4">
                    ¡Gracias por tu compra!
                    <div class="section-message">
                        Dispones de 24 horas para realizar tu transferencia bancaria o depósito en efectivo y enviar tu comprobante de pago a <strong>ventas@mcashop.mx</strong>.
                    </div>
                </h2>
                <div class="console mb-4">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            Si deseas conocer el estado de tu pedido en cualquier momento, puedes dirigirte a la sección
                            <a href="{{ route('cliente/pedido') }}" target="_blank">
                                (Pedidos)
                            </a>
                            en tu cuenta.
                        </li>
                        <li class="mb-2">
                            La factura será enviada al correo registrado en sus datos fiscales.
                        </li>
                    </ul>
                </div>
            </div>
            <a class="btn btn-subtle-flat" href="{{ route('cliente/pedido') }}">
                Ver mi pedido
                <i class="fal fa-arrow-right-long"></i>
            </a>
        </div>
    </div>
</div>
@endsection

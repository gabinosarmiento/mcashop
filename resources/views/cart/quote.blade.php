@extends('layouts.customer')
@section('content')
<div class="container">
    <div class="breadcrumbs">
        {{ Breadcrumbs::render('carrito/cotizar') }}
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
                    ¡Gracias por crear tu cotización!
                    <div class="section-message">
                        Nuestro equipo se pondrá en contacto contigo para confirmar y dar seguimiento a tu pedido.
                    </div>
                </h2>
                <div class="console mb-4">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            Si deseas conocer el estado de tu cotización en cualquier momento, puedes dirigirte a la sección
                            <a href="{{ route('cliente/cotizacion') }}" target="_blank">
                                (Cotizaciones)
                            </a>
                            en tu cuenta.
                        </li>
                    </ul>
                </div>
            </div>
            <a class="btn btn-subtle-flat" href="{{ route('cliente/cotizacion') }}">
                Ver mi cotización
                <i class="fal fa-arrow-right-long"></i>
            </a>
        </div>
    </div>
</div>
@endsection
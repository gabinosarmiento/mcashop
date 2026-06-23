@extends('customer.layout')
@section('content')
<div class="wrapper-bottom">
    <div class="container">
        {{ Breadcrumbs::render('cliente', 'Cotizaciones') }}
        <div class="layout-mca">
            <div class="sidebar-mca d-none d-lg-block">
                @include('customer.sidebar')
            </div>
            <div class="content-mca">
                <div id="records-html">
                    @include('customer.quote.records')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.customer')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('cliente', 'Cotizaciones') }}
    <div class="layout-mca">
        <div class="sidebar-mca">
            @include('customer.sidebar')
        </div>
        <div class="content-mca">
            <div id="records-html">
                @include('customer.quote.records')
            </div>
        </div>
    </div>
</div>
@endsection
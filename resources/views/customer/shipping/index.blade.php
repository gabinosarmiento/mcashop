@extends('layouts.customer')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('cliente', 'Pedidos') }}
    <div class="layout-mca">
        <div class="sidebar-mca">
            @include('customer.sidebar')
        </div>
        <div class="content-mca">
            <div id="records-html">
                @include('customer.shipping.records')
            </div>
        </div>
    </div>
</div>
@endsection
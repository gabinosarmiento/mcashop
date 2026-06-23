@extends('customer.layout')
@section('content')
<div class="wrapper-bottom">
    <div class="container">
        {{ Breadcrumbs::render('cliente', 'Pedidos') }}
        <div class="layout-mca">
            <div class="sidebar-mca d-none d-lg-block">
                @include('customer.sidebar')
            </div>
            <div class="content-mca">
                <div id="records-html">
                    @include('customer.shipping.records')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
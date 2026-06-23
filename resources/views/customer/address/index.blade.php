@extends('customer.layout')
@section('content')
<div class="wrapper-bottom">
    <div class="container">
        {{ Breadcrumbs::render('cliente', 'Dirección') }}
        <div class="layout-mca">
            <div class="sidebar-mca d-none d-lg-block">
                @include('customer.sidebar')
            </div>
            <div class="content-mca">
                <div id="record-html">
                    @include('customer.address.record')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
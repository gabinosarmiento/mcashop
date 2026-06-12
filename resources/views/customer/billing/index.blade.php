@extends('layouts.customer')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('cliente', 'Facturación') }}
    <div class="layout-mca">
        <div class="sidebar-mca">
            @include('customer.sidebar')
        </div>
        <div class="content-mca">
            <div id="record-html">
                @include('customer.billing.record')
            </div>
        </div>
    </div>
</div>
@endsection
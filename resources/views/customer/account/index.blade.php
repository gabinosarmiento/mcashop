@extends('customer.layout')
@section('content')
<div class="wrapper-bottom">
    <div class="container">
        {{ Breadcrumbs::render('cliente', 'Cuenta') }}
        <div class="layout-mca">
            <div class="sidebar-mca d-none d-lg-block">
                @include('customer.sidebar')
            </div>
            <div class="content-mca">
                <div id="record-html">
                    @include('customer.account.record')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
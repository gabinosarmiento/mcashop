@extends('layouts.customer')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('cliente', 'Cuenta') }}
    <div class="layout-mca">
        <div class="sidebar-mca">
            @include('customer.sidebar')
        </div>
        <div class="content-mca">
            <div id="account-html">
                @include('customer.account.record')
            </div>
        </div>
    </div>
</div>
@endsection
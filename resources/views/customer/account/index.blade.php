@extends('layouts.site')
@section('content')
<div class="container">
    {{ Breadcrumbs::render('cliente', 'Cuenta') }}
    <div class="layout-mca">
        <div class="sidebar-mca">
            @include('customer.sidebar')
        </div>
        <div class="content-mca">
            <div id="record-html">
                @include('customer.account.record')
            </div>
        </div>
    </div>
</div>
@endsection
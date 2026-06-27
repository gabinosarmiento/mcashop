@extends('administrative.layout')
@section('content')
<main class="wrapper-top">
    <div class="container-fluid">
        <div class="d-flex flex-column gap-4">
            <div class="row">
                <div class="col-md-8">
                    @include('administrative.assistant.product.actions')
                </div>
                <div class="col-md-4">
                    @include('administrative.search')
                </div>
            </div>
            <div class="row-administrative">
                <div class="sidebar-administrative">
                    @include('administrative.assistant.sidebar')
                </div>
                <div class="content-administrative">
                    <div id="records">
                        @include('administrative.assistant.product.records')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

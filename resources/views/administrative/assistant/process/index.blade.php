@extends('administrative.layout')
@section('content')
<main class="wrapper-top">
    <div class="container-fluid">
        <div class="d-flex flex-column gap-4">
            <div class="row">
                <div class="col-md-12">
                    @include('administrative.assistant.process.actions')
                </div>
            </div>
            <div class="row-administrative">
                <div class="sidebar-administrative">
                    @include('administrative.assistant.sidebar')
                </div>
                <div class="content-administrative">
                    <div id="records">
                        @include('administrative.assistant.process.records')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('administrative.layout')
@section('content')
<main class="wrapper-top">
    <div class="container-fluid">
        <div class="d-flex flex-column gap-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" id="action-add-administrative" class="btn btn-outline-secondary" data-route="agregar" data-overlap-show="#overapp" data-wenk="Agregar">
                            <i class="fal fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    @include('administrative.search')
                </div>
            </div>
            <div class="row-administrative">
                <div class="sidebar-administrative">
                    @include('administrative.administration.sidebar')
                </div>
                <div class="content-administrative">
                    <div id="records">
                        @include('administrative.administration.administrative.records')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

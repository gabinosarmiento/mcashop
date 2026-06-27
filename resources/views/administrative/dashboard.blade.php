@extends('layouts.session')
@section('content')
<main class="container">
    <div class="fullscreen gap-4">
        <div class="picture picture-circle picture-lg picture-border-dashed">
            <img src="{{ asset(auth('administrative')->user()->image) }}" alt="...">
        </div>
        <header class="text-center">
            <h3 class="mb-0">
                {{ auth('administrative')->user()->name }}
            </h3>
            <small class="d-block font-monospace">
                {{ auth('administrative')->user()->department }}
            </small>
        </header>
        <nav class="navbar-module">
            @foreach($data['modules'] as $module)
            <a href="{{ $module['module'] }}" class="btn btn-module btn-light">
                {{ MODULE[$module['module']] }}
                <i class="fa-light fa-angle-right"></i>
            </a>
            @endforeach
        </nav>
        <a href="{{ route('administrativo/salir') }}" class="btn btn-link icon-link">
            Salir
            <i class="fal fa-arrow-right-long"></i>
        </a>
    </div>
</main>
@endsection

@extends('layouts.session')
@section('content')
<main class="row g-0 h-100">
    <div class="col-md-6 bg-image-administrative"></div>
    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
        <div class="col-sesion text-center">
            <div class="mx-auto mb-4">
                <a href="{{ route('inicio') }}">
                    <img src="{{ asset('images/logo.svg') }}" class="img-fluid" alt="MCAShop" width="200"/>
                </a>
            </div>
            <div class="text-mca mb-4">
                Ingresar
            </div>
            <form id="ajax-administrative-form" data-action="{{ route('administrativo/acceso/validar') }}" data-method="post">
                @csrf
                <div class="mb-2">
                    <label class="visually-hidden" for="email">
                        Correo
                    </label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Correo electrónico"/>
                </div>
                <div class="mb-2">
                    <label class="visually-hidden" for="password">
                        Contraseña
                    </label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña"/>
                </div>
                <div class="mb-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-mca w-100">
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
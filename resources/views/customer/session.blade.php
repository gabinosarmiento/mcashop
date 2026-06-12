@extends('layouts.session')
@section('content')
<section class="row g-0 h-100">
    <div class="col-md-6 bg-image-customer"></div>
    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
        <div class="col-sesion text-center">
            <div class="logo mx-auto mb-4">
                <a href="{{ route('inicio') }}">
                    <img src="{{ asset('images/logo.svg') }}" class="img-fluid" alt="MCAShop" width="200"/>
                </a>
            </div>
            <ul class="nav nav-pills justify-content-center mb-4">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="session-tab-button" data-bs-toggle="pill" data-bs-target="#session-tab" type="button" role="tab" aria-controls="session-tab" aria-selected="true">
                        Ingresar
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab-button" data-bs-toggle="pill" data-bs-target="#register-tab" type="button" role="tab" aria-controls="register-tab" aria-selected="false">
                        Registrarse
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="session-tab" role="tabpanel" aria-labelledby="session-tab-button" tabindex="0">
                    <form id="submit-customer-validate-form" data-action="{{ route('cliente/acceso/validar') }}" data-method="post">
                        @csrf
                        <div class="mb-2">
                            <label class="visually-hidden" for="login-email">
                                Correo
                            </label>
                            <input type="text" id="login-email" name="email" class="form-control" placeholder="Correo electrónico"/>
                        </div>
                        <div class="mb-2">
                            <label class="visually-hidden" for="login-password">
                                Contraseña
                            </label>
                            <input type="password" id="login-password" name="password" class="form-control" placeholder="Contraseña"/>
                        </div>
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check text-start">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1"/>
                                <label class="form-check-label" for="remember">
                                    Recordar
                                </label>
                            </div>
                            <a href="{{ route('cliente/restablecer') }}">
                                Restablecer contraseña
                            </a>
                        </div>
                        <button type="submit" class="btn btn-mca w-100">
                            Iniciar sesión
                        </button>
                    </form>
                </div>
                <div class="tab-pane fade" id="register-tab" role="tabpanel" aria-labelledby="register-tab-button" tabindex="0">
                    <form id="submit-customer-create-form" data-action="{{ route('cliente/crear') }}" data-method="post">
                        @csrf
                        <div class="mb-2">
                            <label class="visually-hidden" for="firstname">
                                Nombre
                            </label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nombre"/>
                        </div>
                        <div class="mb-2">
                            <label class="visually-hidden" for="lastname">
                                Apellido
                            </label>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellido"/>
                        </div>
                        <div class="mb-2">
                            <label class="visually-hidden" for="phone">
                                Teléfono
                            </label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Teléfono"/>
                        </div>
                        <div class="mb-2">
                            <label class="visually-hidden" for="register-email">
                                Correo
                            </label>
                            <input type="text" id="register-email" name="email" class="form-control" placeholder="Correo electrónico"/>
                        </div>
                        <div class="mb-2">
                            <label class="visually-hidden" for="register-password">
                                Contraseña
                            </label>
                            <input type="password" id="register-password" name="password" class="form-control" placeholder="Contraseña"/>
                            <div class="form-text fs-8">
                                Mínimo 6 caracteres, un número y un carácter especial
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="visually-hidden" for="repassword">
                                Confirmar contraseña
                            </label>
                            <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Repetir contraseña"/>
                        </div>
                        <div class="mb-4 text-start">
                            <div class="form-check">
                                <input type="checkbox" id="terms" name="terms" value="1" class="form-check-input"/>
                                <label class="form-check-label" for="terms">
                                    Acepto las
                                    <a href="{{ route('terminos_condiciones') }}" target="_blank">
                                        políticas de privacidad
                                    </a>
                                </label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-mca w-100">
                                Crear cuenta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

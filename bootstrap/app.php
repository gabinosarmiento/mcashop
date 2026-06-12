<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath:dirname(__DIR__))->withRouting(
    web:__DIR__ . '/../routes/web.php',
    commands:__DIR__ . '/../routes/console.php',
    channels:__DIR__ . '/../routes/channels.php',
    health:'/up',
)->withMiddleware(function (Middleware $middleware): void{
    $middleware->alias([
        'has_cart'                     => \App\Http\Middleware\HasCart::class,
        'authenticate_administrative'  => \App\Http\Middleware\AuthenticateAdministrative::class,
        'authenticated_administrative' => \App\Http\Middleware\AuthenticatedAdministrative::class,
        'administrative_module'        => \App\Http\Middleware\AdministrativeModule::class,
        'authenticate_customer'        => \App\Http\Middleware\AuthenticateCustomer::class,
        'authenticated_customer'       => \App\Http\Middleware\AuthenticatedCustomer::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

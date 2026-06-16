<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site;
use App\Http\Controllers\Store;
use App\Http\Controllers\Cart;
use App\Http\Controllers\Customer\Account;
use App\Http\Controllers\Customer\Session;
use App\Http\Controllers\Customer\Reset;
use App\Http\Controllers\Customer\ResetPassword;

# --------------------------------------------------------------------------
# Web routes SITE
# --------------------------------------------------------------------------
Route::permanentRedirect('/', '/inicio');

Route::get('inicio', [Site::class, 'index'])->name('inicio');
Route::get('marcas', [Store::class, 'brands'])->name('marcas');
Route::get('marca/{value}/{slug}', [Store::class, 'brand'])->name('marca');
Route::get('categorias/{value}/{slug}', [Store::class, 'categories'])->name('categorias');
Route::get('categorias/categoria/{value}/{slug}', [Store::class, 'category'])->name('categorias/categoria');
Route::get('producto/descargar/{value}', [Store::class, 'download'])->name('producto/descargar');
Route::get('producto/{value}/{slug}', [Store::class, 'product'])->name('producto');
Route::get('preguntas_frecuentes', [Site::class, 'questions'])->name('preguntas_frecuentes');
Route::get('terminos_condiciones', [Site::class, 'terms'])->name('terminos_condiciones');
Route::get('aviso_privacidad', [Site::class, 'privacy'])->name('aviso_privacidad');
Route::get('devoluciones', [Site::class, 'returns'])->name('devoluciones');
Route::get('envios', [Site::class, 'shipping'])->name('envios');
Route::get('contacto', [Site::class, 'contact'])->name('contacto');
Route::post('enviar', [Site::class, 'send'])->name('enviar');
Route::get('buscar', [Site::class, 'search'])->name('buscar');
Route::get('indexado', [Store::class, 'indexing'])->name('indexado');
Route::get('sitemap', [Store::class, 'sitemap'])->name('sitemap');

# --------------------------------------------------------------------------
# Web routes CART
# --------------------------------------------------------------------------
Route::prefix('carrito')->group(function () {
   Route::get('/', [Cart::class, 'index'])->name('carrito');
   Route::get('/agregar/{id}', [Cart::class, 'add'])->name('carrito/agregar');
   Route::get('/remover/{id}', [Cart::class, 'remove'])->name('carrito/remover');
   Route::get('/actualizar/{id}', [Cart::class, 'update'])->name('carrito/actualizar');

   Route::get('/exito', [Cart::class, 'success'])->middleware('has_success')->name('carrito/exito');

   Route::middleware('has_cart')->group(function () {
      Route::get('/cotizar', [Cart::class, 'quote'])->name('carrito/cotizar');
      Route::get('/continuar', [Cart::class, 'checkout'])->name('carrito/continuar');
      Route::get('/facturar', [Cart::class, 'invoice'])->name('carrito/facturar');
      Route::get('/depositar', [Cart::class, 'wiretransfer'])->name('carrito/depositar');
      Route::get('/mercadopago', [Cart::class, 'mercadopago'])->name('carrito/mercadopago');
      Route::post('/mercadopago/pagar', [Cart::class, 'mercadopago_payment'])->name('carrito/mercadopago/pagar');
   });
});

# --------------------------------------------------------------------------
# Web routes CUSTOMER not autenticated
# --------------------------------------------------------------------------
Route::redirect('cliente', 'cliente/acceso')->name('cliente');

Route::middleware('authenticated_customer')->prefix('cliente')->name('cliente/')->group(function () {
   Route::post('crear', [Account::class, 'create'])->name('crear');
   Route::get('acceso', [Session::class, 'showLoginForm'])->name('acceso');
   Route::post('acceso/validar', [Session::class, 'login'])->name('acceso/validar');
   Route::get('restablecer', [Reset::class, 'showLinkRequestForm'])->name('restablecer');
   Route::post('restablecer/correo', [Reset::class, 'sendResetLinkEmail'])->name('restablecer/correo');
   Route::get('restablecer/formulario/{token}', [ResetPassword::class, 'showResetForm'])->name('restablecer/formulario');
   Route::post('restablecer/contrasena', [ResetPassword::class, 'reset'])->name('restablecer/contrasena');
});

# --------------------------------------------------------------------------
# Web routes CUSTOMER autenticated
# --------------------------------------------------------------------------
Route::middleware('authenticate_customer')->prefix('cliente')->name('cliente/')->group(function () {
   Route::get('salir', [Session::class, 'logout'])->name('salir');
   Route::get('cuenta', [Account::class, 'account'])->name('cuenta');
   Route::get('cuenta/editar', [Account::class, 'account_edit'])->name('cuenta/editar');
   Route::post('cuenta/actualizar', [Account::class, 'account_update'])->name('cuenta/actualizar');

   Route::get('direccion', [Account::class, 'address'])->name('direccion');
   Route::get('direccion/agregar', [Account::class, 'address_add'])->name('direccion/agregar');
   Route::post('direccion/guardar', [Account::class, 'address_save'])->name('direccion/guardar');
   Route::get('direccion/editar/{id}', [Account::class, 'address_edit'])->name('direccion/editar');
   Route::post('direccion/actualizar', [Account::class, 'address_update'])->name('direccion/actualizar');
   Route::get('direccion/ubicacion', [Account::class, 'address_location'])->name('direccion/ubicacion');

   Route::get('cotizacion', [Account::class, 'quote'])->name('cotizacion');
   Route::get('cotizacion/ver/{id}', [Account::class, 'quote_see'])->name('cotizacion/ver');

   Route::get('pedido', [Account::class, 'shipping'])->name('pedido');
   Route::get('pedido/ver/{id}', [Account::class, 'shipping_see'])->name('pedido/ver');
   Route::get('pedido/ticket/{id}', [Account::class, 'shipping_ticket'])->name('pedido/ticket');

   Route::get('facturacion', [Account::class, 'billing'])->name('facturacion');
   Route::get('facturacion/agregar', [Account::class, 'billing_add'])->name('facturacion/agregar');
   Route::post('facturacion/guardar', [Account::class, 'billing_save'])->name('facturacion/guardar');
   Route::get('facturacion/editar/{id}', [Account::class, 'billing_edit'])->name('facturacion/editar');
   Route::post('facturacion/actualizar', [Account::class, 'billing_update'])->name('facturacion/actualizar');
});
<?php

use App\Http\Controllers\Administrative\Administration;
use App\Http\Controllers\Administrative\Administration\Administrative;
use App\Http\Controllers\Administrative\Assistant;
use App\Http\Controllers\Administrative\Assistant\Attribute;
use App\Http\Controllers\Administrative\Assistant\Brand;
use App\Http\Controllers\Administrative\Assistant\Category;
use App\Http\Controllers\Administrative\Assistant\Feature;
use App\Http\Controllers\Administrative\Assistant\Health;
use App\Http\Controllers\Administrative\Assistant\Process;
use App\Http\Controllers\Administrative\Assistant\Product;
use App\Http\Controllers\Administrative\Assistant\Supplier;
use App\Http\Controllers\Administrative\Dashboard;
use App\Http\Controllers\Administrative\Sale;
use App\Http\Controllers\Administrative\Sale\Shipping;
use App\Http\Controllers\Administrative\Session as AdministrativeSession;
use App\Http\Controllers\Cart;
use App\Http\Controllers\Customer\Account;
use App\Http\Controllers\Customer\Reset;
use App\Http\Controllers\Customer\ResetPassword;
use App\Http\Controllers\Customer\Session as CustomerSession;
use App\Http\Controllers\Site;
use App\Http\Controllers\Store;
use Illuminate\Support\Facades\Route;

# --------------------------------------------------------------------------
# Web routes SITE
# --------------------------------------------------------------------------
Route::permanentRedirect('/', '/inicio');

Route::get('inicio', [Site::class, 'index'])->name('inicio');
Route::get('marcas', [Store::class, 'brands'])->name('marcas');
Route::get('marca/{value}/{slug}', [Store::class, 'brand'])->name('marca');
Route::get('categorias/{value}/{slug}', [Store::class, 'categories'])->name('categorias');
Route::get('categoria/{value}/{slug}', [Store::class, 'category'])->name('categoria');
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
    Route::get('acceso', [CustomerSession::class, 'showLoginForm'])->name('acceso');
    Route::post('acceso/validar', [CustomerSession::class, 'login'])->name('acceso/validar');
    Route::get('restablecer', [Reset::class, 'showLinkRequestForm'])->name('restablecer');
    Route::post('restablecer/correo', [Reset::class, 'sendResetLinkEmail'])->name('restablecer/correo');
    Route::get('restablecer/formulario/{token}', [ResetPassword::class, 'showResetForm'])->name('restablecer/formulario');
    Route::post('restablecer/contrasena', [ResetPassword::class, 'reset'])->name('restablecer/contrasena');
});

# --------------------------------------------------------------------------
# Web routes CUSTOMER autenticated
# --------------------------------------------------------------------------
Route::middleware('authenticate_customer')->prefix('cliente')->name('cliente/')->group(function () {
    Route::get('salir', [CustomerSession::class, 'logout'])->name('salir');
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

Route::redirect('administrativo', 'administrativo/acceso')->name('administrativo');

Route::group(['middleware' => 'authenticated_administrative'], function () {
    Route::group(['prefix' => 'administrativo', 'as' => 'administrativo/'], function () {
        Route::get('acceso', [AdministrativeSession::class, 'showLoginForm'])->name('acceso');
        Route::post('acceso/validar', [AdministrativeSession::class, 'login'])->name('acceso/validar');
    });
});

Route::group(['middleware' => 'authenticate_administrative'], function () {
    Route::group(['prefix' => 'administrativo', 'as' => 'administrativo/'], function () {
        Route::get('salir', [AdministrativeSession::class, 'logout'])->name('salir');
        Route::get('tablero', [Dashboard::class, 'index'])->name('tablero');

        Route::group(['middleware' => ['administrative_module']], function () {
            Route::get('administracion', [Administration::class, 'index'])->name('administracion');

            Route::group(['prefix' => 'administracion', 'as' => 'administracion/'], function () {
                Route::get('administrativo', [Administrative::class, 'index'])->name('administrativo');
                Route::get('administrativo/registros', [Administrative::class, 'records'])->name('administrativo/registros');
                Route::get('administrativo/agregar', [Administrative::class, 'add'])->name('administrativo/agregar');
                Route::post('administrativo/guardar', [Administrative::class, 'save'])->name('administrativo/guardar');
                Route::get('administrativo/ver', [Administrative::class, 'see'])->name('administrativo/ver');
                Route::post('administrativo/imagen', [Administrative::class, 'imagen'])->name('administrativo/imagen');
                Route::get('administrativo/editar', [Administrative::class, 'edit'])->name('administrativo/editar');
                Route::post('administrativo/actualizar', [Administrative::class, 'update'])->name('administrativo/actualizar');
                Route::get('administrativo/eliminar', [Administrative::class, 'delete'])->name('administrativo/eliminar');
                Route::post('administrativo/modulo/guardar', [Administrative::class, 'module_save'])->name('administrativo/modulo/guardar');
                Route::get('administrativo/modulo/eliminar', [Administrative::class, 'module_delete'])->name('administrativo/modulo/eliminar');
            });

            Route::get('auxiliar', [Assistant::class, 'index'])->name('auxiliar');

            Route::group(['prefix' => 'auxiliar', 'as' => 'auxiliar/'], function () {
                Route::get('marcas', [Product::class, 'brands'])->name('marcas');
                Route::get('categorias', [Product::class, 'categories'])->name('categorias');
                Route::get('producto', [Product::class, 'index'])->name('producto');
                Route::get('producto/registros', [Product::class, 'records'])->name('producto/registros');
                Route::get('producto/agregar', [Product::class, 'add'])->name('producto/agregar');
                Route::post('producto/guardar', [Product::class, 'save'])->name('producto/guardar');
                Route::get('producto/ver', [Product::class, 'see'])->name('producto/ver');
                Route::get('producto/editar', [Product::class, 'edit'])->name('producto/editar');
                Route::post('producto/actualizar', [Product::class, 'update'])->name('producto/actualizar');

                Route::get('administrativo/eliminar', [Administrative::class, 'delete'])->name('administrativo/eliminar');

                Route::get('producto/prompt', [Product::class, 'prompt'])->name('producto/prompt');
                Route::get('producto/icecat', [Product::class, 'icecat'])->name('producto/icecat');
                Route::get('producto/publicando', [Product::class, 'publishing'])->name('producto/publicando');
                Route::get('producto/publicar', [Product::class, 'publish'])->name('producto/publicar');
                Route::get('salud', [Health::class, 'index'])->name('salud');
                Route::get('salud/test', [Health::class, 'test'])->name('salud/test');

                Route::get('categoria', [Category::class, 'index'])->name('categoria');
                Route::get('marca', [Brand::class, 'index'])->name('marca');
                Route::get('proveedor', [Supplier::class, 'index'])->name('proveedor');
                Route::get('caracteristica', [Feature::class, 'index'])->name('caracteristica');
                Route::get('atributo', [Attribute::class, 'index'])->name('atributo');

                Route::get('proceso', [Process::class, 'index'])->name('proceso');
                Route::get('proceso/ver', [Process::class, 'see'])->name('proceso/ver');
                Route::get('proceso/cancelar', [Process::class, 'cancel'])->name('proceso/cancelar');
                Route::get('proceso/reintentar', [Process::class, 'retry'])->name('proceso/reintentar');
                Route::get('proceso/ejecutar', [Process::class, 'execute'])->name('proceso/ejecutar');
            });

            Route::get('venta', [Sale::class, 'index'])->name('venta');

            Route::group(['prefix' => 'venta', 'as' => 'venta/'], function () {
                Route::get('pedido', [Shipping::class, 'index'])->name('pedido');
                Route::get('pedido/registros/{page}', [Shipping::class, 'records'])->name('pedido/registros');
                Route::get('pedido/ver/{id}', [Shipping::class, 'see'])->name('pedido/ver');
                Route::post('pedido/buscar', [Shipping::class, 'find'])->name('pedido/buscar');
                Route::get('pedido/busqueda/{page}', [Shipping::class, 'query'])->name('pedido/busqueda');
                Route::get('pedido/procesar/{id}', [Shipping::class, 'process'])->name('pedido/procesar');
                Route::post('pedido/enviar', [Shipping::class, 'send'])->name('pedido/enviar');
                Route::get('pedido/completar/{id}', [Shipping::class, 'complete'])->name('pedido/completar');
                Route::get('pedido/cancelar/{id}', [Shipping::class, 'cancel'])->name('pedido/cancelar');
            });

        });
    });
});

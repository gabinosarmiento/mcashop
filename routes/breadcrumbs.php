<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for ('inicio', function (BreadcrumbTrail $trail) {
   $trail->push('Inicio', route('inicio'));
});

Breadcrumbs::for ('preguntas_frecuentes', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Preguntas frecuentes', route('preguntas_frecuentes'));
});

Breadcrumbs::for ('terminos_condiciones', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Términos y condiciones', route('terminos_condiciones'));
});

Breadcrumbs::for ('aviso_privacidad', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Aviso de privacidad', route('aviso_privacidad'));
});

Breadcrumbs::for ('devoluciones', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Devoluciones', route('devoluciones'));
});

Breadcrumbs::for ('envios', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Envios', route('envios'));
});

Breadcrumbs::for ('contacto', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Contacto', route('contacto'));
});

Breadcrumbs::for ('producto', function (BreadcrumbTrail $trail, $data, $sku) {
   $trail->parent('inicio');

   foreach ($data as $crumb) {
      $trail->push($crumb['name']);
   }

   $trail->push($sku);
});

Breadcrumbs::for ('marcas', function (BreadcrumbTrail $trail) {
   $trail->parent('inicio');
   $trail->push('Marcas', route('marcas'));
});

Breadcrumbs::for ('marca', function (BreadcrumbTrail $trail, $brand) {
   $trail->parent('marcas');

   $trail->push($brand['name']);
});

Breadcrumbs::for ('categoria', function (BreadcrumbTrail $trail, $data) {
   $trail->parent('inicio');

   foreach ($data as $crumb) {
      $trail->push($crumb['name']);
   }
});

Breadcrumbs::for ('cliente', function (BreadcrumbTrail $trail, $route) {
   $trail->push('Cliente', route('cliente'));

   $trail->push($route, route('cliente', $route));
});

Breadcrumbs::for ('carrito', function (BreadcrumbTrail $trail) {
   $trail->push('Carrito', route('carrito'));
});

Breadcrumbs::for ('carrito/cotizar', function (BreadcrumbTrail $trail) {
   $trail->parent('carrito');

   $trail->push('Cotizar', route('carrito/cotizar'));
});

Breadcrumbs::for ('carrito/depositar', function (BreadcrumbTrail $trail) {
   $trail->parent('carrito');

   $trail->push('Depositar', route('carrito/depositar'));
});

Breadcrumbs::for ('carrito/error', function (BreadcrumbTrail $trail) {
   $trail->parent('carrito');

   $trail->push('Error', route('carrito/error'));
});

Breadcrumbs::for ('carrito/exito', function (BreadcrumbTrail $trail) {
   $trail->parent('carrito');

   $trail->push('Éxito', route('carrito/exito'));
});

Breadcrumbs::for ('carrito/continuar', function (BreadcrumbTrail $trail) {
   $trail->parent('carrito');

   $trail->push('Continuar', route('carrito/continuar'));
});

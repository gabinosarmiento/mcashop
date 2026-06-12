<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class HasCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cart = Session::get('_cart');

        if (empty($cart['products'])) {
            return redirect('carrito');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class HasSuccess
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
        if (Session::has('_success')) {
            return $next($request);
        }

        return redirect('/');
    }
}
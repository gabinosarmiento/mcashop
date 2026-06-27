<?php

namespace App\Http\Middleware;

use Closure;

class AdministrativeModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $exists = auth('administrative')->user()->modules()->where('module', $request->segment(2))->exists();

        if ($exists) {
            return $next($request);
        }

        abort(404);
    }
}

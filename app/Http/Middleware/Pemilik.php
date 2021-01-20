<?php

namespace App\Http\Middleware;

use Closure;

class Pemilik
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
        if (auth()->user()->pengurusGudang->status != 0) {
            return $next($request);
        }
        return abort(401);
        // return $next($request);
    }
}

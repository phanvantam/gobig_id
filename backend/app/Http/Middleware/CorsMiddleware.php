<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
        header('access-control-allow-origin: *');
        header('access-control-allow-credentials: true');
        header('access-control-allow-headers: Content-Type, Authorization');
        header('access-control-allow-methods: GET,POST,OPTIONS,PUT,DELETE,PATCH');
        if ($request->isMethod('OPTIONS')) {
            header('access-control-max-age: 1728000');
            return response()->json();
        } else {
            return $next($request);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\TokenJWT;

class AuthMiddleware
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
        $token_jwt = new TokenJWT;
        $result = $token_jwt->verify();
        if($result === null) {
            return response('Unauthorized.', 401);
        } else {
            define('USER_CODE', $result['payload']['data']['user_code']);
            return $next($request);
        }
    }
}

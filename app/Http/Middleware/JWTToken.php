<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JwtAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class JWTToken 
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
        try {
           $user = JWTAuth::parseToken()->authenticate();
        }catch(JWTException $e)
        {
            if ($e instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException)
                return response()->json(['message'=>'token_expired'], $e->getStatusCode());
            else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException)
                return response()->json(['message'=>'token_invalid'], $e->getStatusCode());
            else 
                return response()->json(['message'=>'token_absent'], $e->getStatusCode());
        }
        return $next($request);
    }
}

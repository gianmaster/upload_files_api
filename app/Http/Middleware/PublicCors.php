<?php

namespace App\Http\Middleware;
use Closure;
class PublicCors
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

        header('Access-Control-Allow-Origin: http://192.168.1.240');
        header('Access-Control-Allow-Headers: Authorization');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        return $next($request);
    }
}
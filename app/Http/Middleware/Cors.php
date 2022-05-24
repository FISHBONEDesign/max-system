<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $response = $next($request);
        $accept_origins = ['*'];
        $accept_types = ['Content-Type', 'XMLHttpRequest'];
        $response->header('Access-Control-Allow-Origin', implode(', ', $accept_origins));
        $response->header('Access-Control-Allow-Headers', implode(', ', $accept_types));
        return $response;
    }
}

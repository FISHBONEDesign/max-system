<?php

namespace App\Http\Middleware;

use Closure;

class ApiForceJsonResponse
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
        $is_request_to_api = (bool)preg_match('/^api\/.*$/', $request->path());
        if ($is_request_to_api) $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}

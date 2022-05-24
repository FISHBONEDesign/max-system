<?php

namespace App\Http\Middleware;

use Closure;

class ApiAllowOptionOrGetRequest
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
        $is_options_request = (bool) preg_match('/^(options)$/i', $request->method());
        $is_get_request = (bool) preg_match('/^(get)$/i', $request->method());
        $is_request_to_api = (bool)preg_match('/^api\/.*$/', $request->path());
        if (($is_get_request || $is_options_request) && $is_request_to_api) {
            $accept_origins = ['*'];
            $accept_types = ['*'];
            $response->header('Access-Control-Allow-Origin', implode(', ', $accept_origins));
            $response->header('Access-Control-Allow-Headers', implode(', ', $accept_types));
        }
        return $response;
    }
}

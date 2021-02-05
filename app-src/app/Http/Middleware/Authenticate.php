<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        $redirect_target = $this->redirectTo($request);
        if (in_array('admin', $guards)) {
            $redirect_target = $this->redirectToAdminLogin($request);
        }

        if (in_array('user', $guards) || $guards[0] === null) {
            $redirect_target = $this->redirectToUserLogin($request);
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $redirect_target
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectToAdminLogin($request)
    {
        if (!$request->expectsJson()) {
            return route('auth.admin.login');
        }
    }

    protected function redirectToUserLogin($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return 'not found';
        }
    }
}

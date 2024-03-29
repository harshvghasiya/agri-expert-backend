<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (\Auth::user() == null || \Auth::user()->is_deleted != 1) {

            flashMessage('error', trans('message.login_fail'));
            return route('admin.login');
        } else {

        }
        return $next($request);
    }
}

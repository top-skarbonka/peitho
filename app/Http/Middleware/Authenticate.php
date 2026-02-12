<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        $prefix = $request->route()?->getPrefix();

        if (str_starts_with($prefix, '/client')) {
            return route('client.login');
        }

        if (str_starts_with($prefix, '/admin')) {
            return route('admin.login');
        }

        if (str_starts_with($prefix, '/company')) {
            return route('company.login');
        }

        return route('company.login');
    }
}

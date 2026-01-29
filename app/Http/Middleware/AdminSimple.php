<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminSimple
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('admin_logged')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

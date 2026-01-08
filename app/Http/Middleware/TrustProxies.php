<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Trust all proxies (VPS / load balancer / nginx)
     */
    protected $proxies = '*';

    /**
     * Use all forwarded headers
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}

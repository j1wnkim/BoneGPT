<?php

namespace App\Http\Middleware;

use Closure;
use phpCAS;

class CasAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0, 'login.uconn.edu', 443, '/cas');
        phpCAS::setNoCasServerValidation(); // Disable SSL validation for testing
        phpCAS::setFixedServiceURL('https://rossa.soc.uconn.edu/cas-login'); // Set the service URL

        // Force CAS Authentication
        phpCAS::forceAuthentication();

        // Retrieve the authenticated user's NetID
        $netId = phpCAS::getUser();

        // Store the NetID in the session
        session(['net_id' => $netId]);

        return $next($request);
    }
}
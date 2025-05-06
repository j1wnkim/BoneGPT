<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CasAuthController extends Controller
{
    public function login()
    {
        // Initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0, 'login.uconn.edu', 443, '/cas');
        phpCAS::setNoCasServerValidation(); // Disable SSL validation for testing
        phpCAS::setFixedServiceURL('https://rossa.soc.uconn.edu/cas-login'); // Set the service URL

        // Force CAS Authentication
        phpCAS::forceAuthentication();

        // Retrieve the authenticated user's NetID
        $netId = phpCAS::getUser();

        // Log the CAS login URL for debugging
        Log::info('CAS Login URL: ' . phpCAS::getServerLoginURL());

        // Find or create the user in your database
        $user = \App\Models\User::firstOrCreate(
            ['net_id' => $netId], // Match by NetID
            ['name' => $netId]   // Default values for new users
        );

        // Log the user in (if using Laravel's Auth system)
        auth()->login($user);

        // Redirect to the intended page or dashboard
        return redirect()->intended('/dashboard');
    }

    public function logout()
    {
        // Initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0, 'login.uconn.edu', 443, '/cas');
        phpCAS::setNoCasServerValidation(); // Disable SSL validation for testing

        // Log the user out of CAS and redirect to the home page
        phpCAS::logoutWithRedirectService(url('/'));
    }
}


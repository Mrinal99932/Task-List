<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and if 'is_admin' is 1
        if (auth()->check() && auth()->user()->is_admin == 1) {
            return $next($request); // Allow access to the route
        }

        // Redirect if the user is not an admin
        return redirect('login'); // Or any route you'd like to redirect to
    }
}

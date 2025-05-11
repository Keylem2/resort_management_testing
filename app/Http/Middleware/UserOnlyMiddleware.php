<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user is logged in and is a "user" type
        if (auth()->check() && !auth()->user()->isCustomer()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}




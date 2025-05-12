<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StaffHeadMiddleware
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
        // Check if the authenticated user is a Staff Head
        if (Auth::check() && Auth::user()->usertype === 'staff_head') {
            return $next($request);
        }

        // Redirect to home if not a Staff Head
        return redirect('/')->with('error', 'Access denied.');
    }
}

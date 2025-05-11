<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HRMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isHR()) {
            return $next($request);
        }

        // Option 1: Redirect to home with error
        return redirect()->route('home')->with('error', 'You do not have HR access.');
        
        // Option 2: Show 403 forbidden page
        // abort(403, 'Unauthorized HR access.');
    }
}
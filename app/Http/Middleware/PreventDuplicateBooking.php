<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDuplicateBooking
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('booking') && $request->isMethod('POST')) {
            if (session()->has('booking_id')) {
                return redirect()->route('gcash.payment');
            }
        }
        
        return $next($request);
    }
}
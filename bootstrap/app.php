<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\FrontDeskMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,
            'admin' => AdminMiddleware::class,
            'front_desk' => FrontDeskMiddleware::class,
            'user_only' => \App\Http\Middleware\UserOnlyMiddleware::class,
            'finance' => \App\Http\Middleware\FinanceMiddleware::class,
            'prevent.duplicate.booking' => \App\Http\Middleware\PreventDuplicateBooking::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

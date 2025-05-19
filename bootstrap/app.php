<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isCoordinator;
use App\Http\Middleware\isCrew;
use App\Http\Middleware\isParticipant;
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
            'auth' => AuthMiddleware::class,
            'guest' => GuestMiddleware::class,
            'isAdmin' => isAdmin::class,
            'isCoordinator' => isCoordinator::class,
            'isCrew' => isCrew::class,
            'isParticipant' => isParticipant::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

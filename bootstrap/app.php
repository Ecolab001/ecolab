<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'subscription' => \App\Http\Middleware\CheckSubscription::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // ✅
        'representative' => \App\Http\Middleware\CheckRole::class,
    ]);

    // 🔥 IMPORTANT : autoriser webhook
    $middleware->validateCsrfTokens(except: [
        'payment/webhook',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

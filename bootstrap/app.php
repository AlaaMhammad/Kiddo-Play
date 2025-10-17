<?php

use App\Http\Middleware\CheckParent;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\isAuth;
use App\Http\Middleware\isKid;
use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [__DIR__ . '/../routes/web.php', __DIR__.'/../routes/admin.php'],
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'isAuth' => isAuth::class,
            'isAdmin' => IsAdmin::class,
            'role' => CheckRole::class,
            'isParent' => CheckParent::class,
            'isKid' => isKid::class,
        ]);
        $middleware->appendToGroup('web', Localization::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

<?php

use App\Http\Middleware\SetLocale;
use App\Http\Middleware\CheckRole;
use \Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Đăng ký middleware toàn cục
    ->withMiddleware(function ($middleware) {
        // $middleware->prepend(StartSession::class);
        // $middleware->prepend(SetLocale::class); // Đăng ký Middleware SetLocale
//        $middleware->prepend(CheckRole::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Xử lý ngoại lệ nếu cần
    })
    ->create();


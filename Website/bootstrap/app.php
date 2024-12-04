<?php

use App\Http\Middleware\LocaleMiddleware;
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

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Xử lý ngoại lệ nếu cần
    })
    ->create();


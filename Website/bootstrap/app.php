<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        // Đăng ký toàn cục
        // // Đăng ký middleware CheckRole vào chuỗi middleware
        // // Chú ý là không dùng push(), hãy đơn giản thêm middleware vào đây
        // $middleware->prepend(CheckRole::class); // Thêm middleware vào đầu chuỗi middleware
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

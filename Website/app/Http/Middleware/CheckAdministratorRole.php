<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckAdministratorRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có role_id là 1 (admin)
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request); // Tiếp tục nếu là admin
        }

        // Nếu không phải admin, chuyển hướng hoặc xử lý khác
        return redirect('/home'); // Hoặc trang khác
    }
}

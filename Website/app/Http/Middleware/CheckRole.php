<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
//        // Lấy vai trò từ session hoặc từ database
//        $userRole = Session::get('role_name'); // Giả sử session lưu thông tin role
//
//        // Kiểm tra vai trò của người dùng có nằm trong danh sách vai trò yêu cầu không
//        if (!$userRole || !in_array($userRole, $roles)) {
//            // Trả về thông báo không có quyền truy cập
//            return response()->view('errors.no_permission', [], 403); // Trả về trang lỗi 403 với thông báo
//        }

//        if (!Session::has('user_id')) {
//            return redirect()->route('login');
//        }

        return $next($request);
    }
}

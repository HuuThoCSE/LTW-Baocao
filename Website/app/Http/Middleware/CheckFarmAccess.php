<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckFarmerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy vai trò của người dùng từ session
        $userRole = Session::get('role_name');  // Giả sử bạn đã lưu role_name trong session

        // Kiểm tra nếu người dùng là IT nông trại và đang cố gắng truy cập vào các trang chỉ dành cho farmer
        if ($userRole === 'it_farm' && $this->isFarmerPage($request)) {
            // Nếu là IT nông trại và đang truy cập vào các trang của nông dân, chuyển hướng về trang chính
            return redirect()->route('home')->withErrors(['Bạn không có quyền truy cập vào trang của nông dân']);
        }

        return $next($request);
    }

    /**
     * Kiểm tra nếu URL là trang của nông dân.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isFarmerPage(Request $request): bool
    {
        // Ví dụ: kiểm tra nếu URL chứa các trang dành cho farmer
        return in_array($request->path(), [
            'farmer/dashboard',     // Trang dashboard của nông dân
            'farmer/tasks',         // Trang công việc của nông dân
            'farmer/goats',         // Trang quản lý dê của nông dân
            // Thêm các route khác mà bạn muốn hạn chế quyền truy cập cho IT nông trại
        ]);
    }
}

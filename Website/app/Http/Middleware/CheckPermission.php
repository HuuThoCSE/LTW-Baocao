<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $dev_mode = true;
        if ($dev_mode == false){
            // Lấy user_id từ session
            $user_id = Session::get('user_id');

            // Kiểm tra xem người dùng có quyền truy cập vào các hành động này không
            $userPermissions = DB::table('user_permissions')
                ->where('user_id', $user_id)
                ->pluck('permission_id')
                ->toArray();

            // Kiểm tra xem người dùng có quyền nào trong danh sách quyền yêu cầu
            $requiredPermissions = DB::table('permissions')
                ->whereIn('name', $permissions)
                ->pluck('permission_id')
                ->toArray();

            if (empty(array_intersect($userPermissions, $requiredPermissions))) {
                // Nếu không có quyền, redirect về trang home
                return redirect()->route('home')->withErrors(['Bạn không có quyền truy cập vào trang này']);
            }
        }
        

        return $next($request);
    }
}

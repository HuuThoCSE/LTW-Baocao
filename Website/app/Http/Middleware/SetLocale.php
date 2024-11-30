<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy ngôn ngữ từ session hoặc dùng ngôn ngữ mặc định
        $locale = Session::get('locale', config('app.locale')); // Sử dụng ngôn ngữ mặc định nếu session không có giá trị

        \Log::info('Locale from session 1: ' . $locale); // Ghi log để kiểm tra giá trị

        // Đặt ngôn ngữ cho ứng dụng
        App::setLocale($locale);

        \Log::info('Session before: ' . Session::get('locale'));
        Session::put('locale', 'en');
        Session::save();
        \Log::info('Session after: ' . Session::get('locale'));

        return $next($request);
    }
}

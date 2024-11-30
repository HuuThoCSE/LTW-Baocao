<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage($locale)
    {
        // Lấy danh sách ngôn ngữ được hỗ trợ từ cấu hình
        $supportedLocales = config('app.supported_locales', ['en', 'vi']);

        // Kiểm tra nếu ngôn ngữ hợp lệ
        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale); // Lưu ngôn ngữ vào session

            \Log::info('Locale from session 2: ' . $locale); // Ghi log để kiểm tra giá trị
        }

        // Quay lại trang trước hoặc về trang chủ nếu không có
        return redirect()->back() ?: redirect('/');
    }
}

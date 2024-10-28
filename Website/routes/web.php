<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListGoatController;
use App\Http\Controllers\GoatDetailController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ListFarmController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AdminController;

Route::get('/', [DashboardController::class, 'getView'])->name('home');
Route::get('/danhsachde', [DashboardController::class, 'getViewQLD'])->name('quanlyde');
Route::get('/login', [LoginController::class, 'getView'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login_post');
Route::get('/listgoat', [ListGoatController::class, 'getView'])->name('listgoat');
Route::get('/account', [AccountController::class, 'getView'])->name('account');
Route::get('/farms', [ListFarmController::class, 'getView'])->name('listfarm');

Route::get('/dashboard', function () {
    // Chỉ người dùng đã đăng nhập mới có thể truy cập
})->middleware('auth');

Route::get('goatdetail/{goat_id}', [GoatDetailController::class, 'getview'])->name('goatdetail');
Route::get('/admin', [AdminController::class, 'getView'])->name('Admin');
# Medication Management

Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
Route::post('/medication', [MedicationController::class, 'addData'])->name('medication_add');
Route::delete('/medication/{id}', [MedicationController::class, 'delData'])->name('medication.del');
Route::put('/medication/{id}', [MedicationController::class, 'delData'])->name('medication.put');

#registry an account

Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->middleware('admin')->name('admin.register.view');
Route::post('/admin/register', [AdminController::class, 'register'])->middleware('admin')->name('admin.register');
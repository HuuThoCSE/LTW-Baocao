<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListGoatController;
use App\Http\Controllers\GoatDetailController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ListFarmController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoatController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/goats/{id}', [GoatController::class, 'show'])->name('goats.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'getView'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    # Medication Management
    Route::post('/medication', [MedicationController::class, 'addData'])->name('medication_add');
    Route::delete('/medication/{id}', [MedicationController::class, 'delData'])->name('medication.del');

    Route::get('/admin', [AdminController::class, 'getView'])->name('admin.view');
    Route::post('/admin/add', [AdminController::class, 'addUser'])->name('user.add');
    Route::post('/goats', [GoatController::class, 'addGoat'])->name('goats.add');

});

Route::get('/danhsachde', [DashboardController::class, 'getViewQLD'])->name('quanlyde');
Route::get('/account', [AccountController::class, 'getView'])->name('account');

Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->middleware('admin')->name('admin.register.view');
Route::post('/admin/register', [AdminController::class, 'register'])->middleware('admin')->name('admin.register');

Route::get('/dashboard', function () {
    // Chỉ người dùng đã đăng nhập mới có thể truy cập
})->middleware('auth');

Route::get('goatdetail/{goat_id}', [GoatDetailController::class, 'getview'])->name('goatdetail');
Route::get('/admin', [AdminController::class, 'getView'])->name('Admin');
# Medication Management

Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
Route::put('/medication/{id}', [MedicationController::class, 'putData'])->name('medication.put');

# List_Farm Management
Route::get('/farms', [ListFarmController::class, 'getView'])->name('listfarm');
Route::post('/farms', [ListFarmController::class, 'addFarm'])->name('listfarm.add');
Route::delete('/farms/{farm_id}', [ListFarmController::class, 'delFarm'])->name('listfarm.del');
Route::put('/farms/{farm_id}', [ListFarmController::class, 'putFarm'])->name('listfarm.put');

# List_Goat Management
Route::delete('/goats/{goat_id}', [ListGoatController::class, 'delGoat'])->name('listgoat.del');
Route::put('/goats/{goat_id}', [ListGoatController::class, 'putGoat'])->name('listgoat.put');



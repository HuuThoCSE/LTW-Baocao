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
use App\Http\Controllers\FoodController;
use App\Http\Controllers\DeviceController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/goats/{id}', [GoatController::class, 'show'])->name('goats.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'getView'])->name('dashboard');

    Route::get('/admin', [AdminController::class, 'getView'])->name('admin.view');
    Route::post('/admin', [AdminController::class, 'addUser'])->name('user.add');
    Route::delete('/account/{id}', [AccountController::class, 'delAccount'])->name('account.del');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    Route::get('/account', [AccountController::class, 'getView'])->name('account');

    Route::get('/admin', [AdminController::class, 'getView'])->name('Admin');
    Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->middleware('admin')->name('admin.register.view');
    Route::post('/admin/register', [AdminController::class, 'register'])->middleware('admin')->name('admin.register');


    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    # Medication Management
    Route::post('/medication', [MedicationController::class, 'addData'])->name('medication_add');
    Route::delete('/medication/{id}', [MedicationController::class, 'delData'])->name('medication.del');
    
    # List_Goat Management
    Route::get('/goats', [GoatController::class, 'getView'])->name('goats.list');
    Route::post('/goats', [GoatController::class, 'addGoat'])->name('goats.add');
    Route::get('goatdetail/{goat_id}', [GoatDetailController::class, 'getview'])->name('goatdetail');
    Route::delete('/goats/{goat_id}', [GoatController::class, 'delGoat'])->name('goats.del');
    Route::put('/goats/{goat_id}', [GoatController::class, 'udpGoat'])->name('goats.udp');
    Route::get('/goats/create', [GoatController::class, 'createGoatForm'])->name('goats.create');
        
    #Food Management
    Route::get('/food', [FoodController::class, 'getView'])->name('food');
    Route::delete('/food/{id}', [FoodController::class, 'delFood'])->name('food.del');

    #Device Management
    Route::get('/devices', [DeviceController::class, 'getView'])->name('device.list');
    Route::get('/devices/{id}', [DeviceController::class, 'detailDevice'])->name('device.detail');
    Route::post('/devices/add', [DeviceController::class, 'addDevice'])->name('device.add');
    Route::post('/devices/{id}/edit', [DeviceController::class, 'ediDevice'])->name('device.edit');
    Route::put('/devices/{id}/maintenance', [DeviceController::class, 'delDevice'])->name('device.maintenance'); // Lịch sử và lịch trình bảo trì
    Route::put('/devices/{id}/status', [DeviceController::class, 'delDevice'])->name('device.putStatus');
    Route::delete('/devices/{id}/delete', [DeviceController::class, 'delDevice'])->name('device.del');

    # Medication Management
    Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
    Route::put('/medication/{id}', [MedicationController::class, 'putData'])->name('medication.put');

    #Food Management
    Route::post('/food', [FoodController::class, 'addFood'])->name('food.add');

    # List_Farm Management
    Route::get('/farms', [ListFarmController::class, 'getView'])->name('listfarm');
    Route::post('/farms', [ListFarmController::class, 'addFarm'])->name('listfarm.add');
    Route::delete('/farms/{farm_id}', [ListFarmController::class, 'delFarm'])->name('listfarm.del');
    Route::put('/farms/{farm_id}', [ListFarmController::class, 'udpFarm'])->name('listfarm.udp');
});
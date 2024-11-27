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
<<<<<<< Updated upstream
use App\Http\Controllers\GoatController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\APIController;
use App\Http\Middleware\CheckAdministratorRole;
=======
>>>>>>> Stashed changes

Route::middleware([CheckAdministratorRole::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    // Các route khác dành cho admin
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/goats/{id}', [GoatController::class, 'show'])->name('goats.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'getView'])->name('home');

    Route::get('/admin', [AdminController::class, 'getView'])->name('admin.view');
    Route::post('/account', [AccountController::class, 'addUser'])->name('user.add');
    Route::put('/account/{id}', [AccountController::class, 'udpAcc'])->name('account.udp');
    Route::get('/account', [AccountController::class, 'getView'])->name('account');
    Route::delete('/account/{id}', [AccountController::class, 'delAccount'])->name('account.del');
    Route::get('/account/{id}', [AccountController::class, 'showAccount'])->name('account.show');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/admin', [AdminController::class, 'getView'])->name('Admin');
    Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->middleware('admin')->name('admin.register.view');
    Route::post('/admin/register', [AdminController::class, 'register'])->middleware('admin')->name('admin.register');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
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
    Route::put('/food/{id}', [FoodController::class, 'udpFood'])->name('foods.udp');

<<<<<<< Updated upstream
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

    # List_Area Management
    Route::get('/areas', [AreaController::class, 'getView'])->name('listarea');
    Route::post('/areas', [AreaController::class, 'addArea'])->name('listarea.add');
    Route::delete('/areas/{areas_id}', [AreaController::class, 'delArea'])->name('listarea.del');
    Route::put('/areas/{areas_id}', [AreaController::class, 'udpArea'])->name('listarea.udp');
    Route::get('/dashboard', [DashboardController::class, 'getGoatData'])->name('dashboard.data');
});

# API
// Route::get('/api/farm1/zone1/barn1/sensor/humidity', [APIController::class, 'getView'])->name('api.humidity');
Route::get('/api/sensor', [APIController::class, 'addHumidity'])->name('api.addHumidity');
=======
    Route::get('/admin', [AdminController::class, 'getView'])->name('admin');
    Route::post('/admin', [AdminController::class, 'addUser'])->name('User_add');
    Route::post('/goats', [GoatController::class, 'addGoat'])->name('listgoat.add');
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


>>>>>>> Stashed changes

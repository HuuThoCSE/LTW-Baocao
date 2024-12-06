<?php
// Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BreedController;

use App\Http\Controllers\GoatDetailController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoatController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BarnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

// Middleware
use App\Http\Middleware\CheckFarmerAccess;
use App\Http\Middleware\CheckPermission;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LocaleMiddleware;

// API
Route::get('/api/account/owners', [AccountController::class, 'getOwners'])->name('api.getOwners');


// Các route công khai
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Các route dành riêng cho farmer (nông dân)
Route::middleware([])->group(function () {
//    Route::get('/farmer/dashboard', [FarmerController::class, 'dashboard'])->name('farmer.dashboard');
//    Route::get('/farmer/tasks', [FarmerController::class, 'tasks'])->name('farmer.tasks');
    Route::get('/farmer/goats', [GoatController::class, 'farmerGfarmeroats'])->name('farmer.goats');
    Route::post('/farmer/goats', [GoatController::class, 'addGoat'])->name('farmer.goats.add');
    Route::put('/farmer/goats/{id}', [GoatController::class, 'updateGoat'])->name('farmer.goats.update');
});

Route::middleware([CheckPermission::class])->group(function () {
    // Các route của administrator, farm_owner, không cho phép it_farm
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('administrator.dashboard');
    Route::get('/admin/farm-list', [FarmController::class, 'list'])->name('admin.farm_list');

    // Route dành cho nông dân
//    Route::get('/farmer/dashboard', [FarmerController::class, 'dashboard'])->name('farmer.dashboard')->middleware(CheckFarmerAccess::class);
//    Route::get('/farmer/tasks', [FarmerController::class, 'tasks'])->name('farmer.tasks')->middleware(CheckFarmerAccess::class);
    Route::get('/farmer/goats', [GoatController::class, 'farmerGoats'])->name('farmer.goats')->middleware(CheckFarmerAccess::class);
});

/// ------------------------

// Admin
Route::middleware([CheckPermission::class . ':administrator'])->group(function () {
    Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->name('admin.register.view');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    // Các route dành cho quản trị viên
    Route::get('/farms', [FarmController::class, 'getView'])->name('listfarm');
    Route::post('/farms/add', [FarmController::class, 'addFarm'])->name('listfarm.add');
    Route::delete('/farms/{farm_id}', [FarmController::class, 'delFarm'])->name('listfarm.del');
    Route::put('/farms/{farm_id}', [FarmController::class, 'udpFarm'])->name('listfarm.udp');
});

// Chủ nông trại
Route::middleware([CheckPermission::class . ':farm_owner'])->group(function () {
    // List_Farm Management
    // Các route cho chủ nông trại
});

// IT nông trại
Route::middleware([CheckPermission::class . ':farm_it'])->group(function () {
    // Device Management
    Route::get('/devices/{id}', [DeviceController::class, 'detailDevice'])->name('device.detail');
    Route::post('/devices/add', [DeviceController::class, 'addDevice'])->name('device.add');
    Route::post('/devices/{id}/edit', [DeviceController::class, 'ediDevice'])->name('device.edit');
    Route::put('/devices/{id}/maintenance', [DeviceController::class, 'delDevice'])->name('device.maintenance'); // Lịch sử và lịch trình bảo trì
    Route::put('/devices/{id}/status', [DeviceController::class, 'delDevice'])->name('device.putStatus');
    Route::delete('/devices/{id}/delete', [DeviceController::class, 'delDevice'])->name('device.del');
    // Các route dành cho IT nông trại
});

// Nông dân
Route::middleware([CheckPermission::class . ':farmer'])->group(function () {
    // List_Goat Management
    Route::get('/goats', [GoatController::class, 'getView'])->name('goats.list');
    Route::post('/goats', [GoatController::class, 'addGgoatsoat'])->name('goats.add');
    Route::get('goatdetail/{goat_id}', [GoatDetailController::class, 'getview'])->name('goatdetail');
    Route::delete('/goats/{goat_id}', [GoatController::class, 'delGoat'])->name('goats.del');
    Route::put('/goats/{goat_id}', [GoatController::class, 'udpGoat'])->name('goats.udp');
    Route::get('/goats/create', [GoatController::class, 'createGoatForm'])->name('goats.create');
});

// Người dùng bình thường
Route::middleware([CheckPermission::class . ':regular_user'])->group(function () {
    Route::get('/goats/{id}', [GoatController::class, 'show'])->name('goats.show');
    // Các route cho người dùng bình thường
});

Route::middleware('auth')->group(function () {

});

Route::get('/api/dashboard', [DashboardController::class, 'getGoatData'])->name('dashboard.data');

//Route::get('/change-language/{locale}', [LanguageController::class, 'changeLanguage'])->name('change.language');


// Language - chuyển đổi ngôn ngữ
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        session(['locale' => $locale]);
    }
    Log::info('Change language to ' . $locale);
    Log::info('Current session locale: ' . session('locale'));
    Log::info('Current locale: ' . App::getLocale());
    return redirect()->back();
})->name('change.language');


    # Medication Management
    Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
    Route::put('/medication/{id}', [MedicationController::class, 'putData'])->name('medication.put');

    #Food Management
    Route::post('/food', [FoodController::class, 'addFood'])->name('food.add');

    # List_Area Management

    // routes/web.php
    Route::post('/get-areas-by-zone', [AreaController::class, 'getAreasByZone']);



     # List_Zone Management
     Route::post('/get-area-by-zone', [ZoneController::class, 'getAreaByZone']);
    //  Route::get('/dashboard', [DashboardController::class, 'getGoatData'])->name('dashboard.data');

      # List_Barn Management

    //   Route::get('/dashboard', [DashboardController::class, 'getGoatData'])->name('dashboard.data')


Route::middleware(['auth', LocaleMiddleware::class])->group(function () {

    // Admin
        Route::get('/admin', [DashboardController::class, 'getView'])->name('admin.dashboard');
        Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->middleware('admin')->name('admin.register.view');
        Route::post('/admin/register', [AdminController::class, 'register'])->middleware('admin')->name('admin.register');

        // Chủ nông trại
        Route::get('/account', [AccountController::class, 'getView'])->name('account');
        Route::post('/account', [AccountController::class, 'addUser'])->name('account.add');
        Route::put('/account/{id}', [AccountController::class, 'udpAcc'])->name('account.udp');
        Route::delete('/account/{id}', [AccountController::class, 'delAccount'])->name('account.del');
        Route::get('/account/{id}', [AccountController::class, 'showAccount'])->name('account.show');

    // IT nông trại
        #Device Management
        Route::get('/devices', [DeviceController::class, 'getView'])->name('device.list');
        Route::get('/devices/{id}', [DeviceController::class, 'detailDevice'])->name('device.detail');
        Route::post('/devices/add', [DeviceController::class, 'addDevice'])->name('device.add');
        Route::post('/devices/{id}/edit', [DeviceController::class, 'ediDevice'])->name('device.edit');
        Route::put('/devices/{id}', [DeviceController::class, 'udpDevice'])->name('device.upd');
        Route::put('/devices/{id}/maintenance', [DeviceController::class, 'delDevice'])->name('device.maintenance'); // Lịch sử và lịch trình bảo trì
        Route::put('/devices/{id}/status', [DeviceController::class, 'delDevice'])->name('device.putStatus');
        Route::delete('/devices/{id}/delete', [DeviceController::class, 'delDevice'])->name('device.del');

    // Nông dân

        # Medication Management
        Route::post('/medication', [MedicationController::class, 'addData'])->name('medication.add');
        Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
        Route::put('/medication/{medication_id}', [MedicationController::class, 'putData'])->name('medication.put');
        Route::delete('/medication/{medication_id}', [MedicationController::class, 'delData'])->name('medication.del');

        # List_Zone Management
        Route::get('/zones', [ZoneController::class, 'getView'])->name('listzone.dashboard');
        Route::post('/zones', [ZoneController::class, 'addZone'])->name('listzone.add');
        Route::delete('/zones/{id}', [ZoneController::class, 'delZone'])->name('listzone.del');
        Route::put('/zones/{id}', [ZoneController::class, 'udpZone'])->name('listzone.udp');

        # List_Area Management
        Route::get('/areas', [AreaController::class, 'getView'])->name('listarea.dashboard');
        Route::post('/areas', [AreaController::class, 'addArea'])->name('listarea.add');
        Route::delete('/areas/{area_id}', [AreaController::class, 'delArea'])->name('listarea.del');
        Route::put('/areas/{area_id}', [AreaController::class, 'udpArea'])->name('listarea.udp');
        Route::post('/areas.get-by-zone', [AreaController::class, 'getAreasByZone']);

        #Food Management
        Route::post('/food', [FoodController::class, 'addFood'])->name('food.add');

        # List_Barn Management
        Route::get('/barns/{id}', [BarnController::class, 'show'])->name('barn.show');
        Route::get('/barns', [BarnController::class, 'getView'])->name('barn.dashboard');
        Route::post('/barns', [BarnController::class, 'addBarn'])->name('barn.add');
        Route::delete('/barns/{id}', [BarnController::class, 'delBarn'])->name('barn.del');
        Route::put('/barns/{id}', [BarnController::class, 'udpBarn'])->name('barn.udp');

    // Chung chung
        Route::get('/dashboard', [DashboardController::class, 'getView'])->name('dashboard.view');
        Route::get('', [HomeController::class, 'getView'])->name('home');

        Route::get('/farms/{id}', [FarmController::class, 'show'])->name('farms.show'); // Chi tiết farm theo id

        Route::get('/breeds', [BreedController::class, 'getView'])->name('breed.list');
        Route::post('/breeds', [BreedController::class, 'add'])->name('breed.add');
        Route::put('/breeds/{id}', [BreedController::class, 'udp'])->name('breed.udp');
        Route::delete('/breeds/{id}', [BreedController::class, 'del'])->name('breed.del');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        # List_Goat Management
        Route::get('/goats/create', [GoatController::class, 'showGoatForm'])->name('goats.create');
        Route::get('/goats', [GoatController::class, 'getView'])->name('goats.list');
        Route::post('/goats', [GoatController::class, 'addGoat'])->name('goats.add');
        Route::get('goat/{goat_id}', [GoatController::class, 'show'])->name('goat.show');
        Route::delete('/goats/{goat_id}/del', [GoatController::class, 'delGoat'])->name('goats.del');
        Route::put('/goats/{goat_id}/udp', [GoatController::class, 'udpGoat'])->name('goats.udp');

        #Food Management
        Route::get('/food', [FoodController::class, 'getView'])->name('food.list');
        Route::delete('/food/{id}', [FoodController::class, 'delFood'])->name('food.del');
        Route::put('/food/{id}', [FoodController::class, 'udpFood'])->name('foods.udp');
});

# API
// Route::get('/api/farm1/zone1/barn1/sensor/humidity', [APIController::class, 'getView'])->name('api.humidity');
Route::get('/api/sensor', [APIController::class, 'addHumidity'])->name('api.addHumidity');


// Route::middleware([CheckPermission::class, 'permission:view_farm_list'])->group(function () {
//     Route::get('/farms', [FarmController::class, 'getView'])->name('listfarm');
//     // Các route khác của farmer
// });

// Route::middleware([CheckPermission::class, 'permission:edit_farm_list'])->group(function () {
//     Route::post('/farms', [FarmController::class, 'addFarm'])->name('listfarm.add');
//     // Các route khác của farm owner hoặc admin
// });

// Route::middleware([CheckPermission::class, 'permission:edit_device'])->group(function () {
//     Route::post('/devices/add', [DeviceController::class, 'addDevice'])->name('device.add');
//     // Các route khác dành cho IT nông trại
// });

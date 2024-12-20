<?php
// Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BreedController;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoatController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BarnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TypeFoodController;
use App\Http\Controllers\IoTController;

use App\Http\Controllers\API\SensorDataController;

// Middleware
use App\Http\Middleware\CheckAuthMiddleware;
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
//    Route::get('/farmer/goats', [GoatController::class, 'farmerGfarmeroats'])->name('farmer.goats');
//    Route::post('/farmer/goats', [GoatController::class, 'addGoat'])->name('farmer.goats.add');
//    Route::put('/farmer/goats/{id}', [GoatController::class, 'updateGoat'])->name('farmer.goats.update');
});

Route::middleware([CheckPermission::class])->group(function () {
    // Các route của administrator, farm_owner, không cho phép it_farm
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('administrator.dashboard');
    Route::get('/admin/farm-list', [FarmController::class, 'list'])->name('admin.farm_list');

    // Route dành cho nông dân
//    Route::get('/farmer/dashboard', [FarmerController::class, 'dashboard'])->name('farmer.dashboard')->middleware(CheckFarmerAccess::class);
//    Route::get('/farmer/tasks', [FarmerController::class, 'tasks'])->name('farmer.tasks')->middleware(CheckFarmerAccess::class);
//    Route::get('/farmer/goats', [GoatController::class, 'farmerGoats'])->name('farmer.goats')->middleware(CheckFarmerAccess::class);
});

/// ------------------------

// Admin
Route::middleware([CheckPermission::class . ':administrator'])->group(function () {
    Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->name('admin.register.view');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    // Các route dành cho quản trị viên
    Route::get('/farms', [FarmController::class, 'index'])->name('farms.index');
    Route::post('/farms/add', [FarmController::class, 'add'])->name('farms.add');
    Route::delete('/farms/{farm_id}', [FarmController::class, 'del'])->name('farms.del');
    Route::put('/farms/{farm_id}', [FarmController::class, 'udp'])->name('farms.udp');
});

// Chủ nông trại
Route::middleware([CheckPermission::class . ':farm_owner'])->group(function () {
    // List_Farm Management
    // Các route cho chủ nông trại
});

// Nông dân
Route::middleware([CheckPermission::class . ':farmer'])->group(function () {
    // List_Goat Management
//    Route::get('/goats', [GoatController::class, 'getView'])->name('goats.list');
//    Route::post('/goats', [GoatController::class, 'addGgoatsoat'])->name('goats.add');
//    Route::get('goats/{goat_id}', [GoatController::class, 'getview'])->name('goats.show');
//    Route::delete('/goats/{goat_id}', [GoatController::class, 'delGoat'])->name('goats.del');
//    Route::put('/goats/{goat_id}', [GoatController::class, 'udpGoat'])->name('goats.udp');
//    Route::get('/goats/create', [GoatController::class, 'createGoatForm'])->name('goats.create');
});

// Người dùng bình thường
Route::middleware([CheckPermission::class . ':regular_user'])->group(function () {
//    Route::get('/goats/{id}', [GoatController::class, 'show'])->name('goats.show');
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

    # Area Management

    // routes/web.php
    Route::post('/get-areas-by-zone', [AreaController::class, 'getAreasByZone']);



     # Zone Management
     Route::post('/get-area-by-zone', [ZoneController::class, 'getAreaByZone']);
    //  Route::get('/dashboard', [DashboardController::class, 'getGoatData'])->name('dashboard.data');

      # Barn Management

    //   Route::get('/dashboard', [DashboardController::class, 'getGoatData'])->name('dashboard.data')


Route::middleware(['auth', LocaleMiddleware::class, CheckAuthMiddleware::class])->group(function () {

    // Admin
        Route::get('/admin', [DashboardController::class, 'getView'])->name('admin.dashboard');
        Route::get('/admin/register', [AdminController::class, 'getRegisterView'])->middleware('admin')->name('admin.register.view');
        Route::post('/admin/register', [AdminController::class, 'register'])->middleware('admin')->name('admin.register');

        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

        // Chủ nông trại
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::post('/account', [AccountController::class, 'add'])->name('account.add');
        Route::put('/account/{id}', [AccountController::class, 'udp'])->name('account.udp');
        Route::delete('/account/{id}', [AccountController::class, 'del'])->name('account.del');
        Route::get('/account/{id}', [AccountController::class, 'show'])->name('account.show');

    // IT nông trại
//        Route::get('/dashboard/it', [ItController::class, 'index'])->name('dashboard.it');

        #Device Management
        Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
        Route::get('/devices/{id}', [DeviceController::class, 'show'])->name('devices.show');
        Route::post('/devices/add', [DeviceController::class, 'add'])->name('devices.add');
        Route::post('/devices/{id}/edit', [DeviceController::class, 'edi'])->name('devices.edit');
        Route::put('/devices/{id}', [DeviceController::class, 'udp'])->name('devices.upd');
        Route::delete('/devices/{id}/delete', [DeviceController::class, 'del'])->name('devices.del');
        Route::put('/devices/{id}/maintenance', [DeviceController::class, 'maintenance'])->name('devices.maintenance'); // Lịch sử và lịch trình bảo trì
        Route::put('/devices/{id}/status', [DeviceController::class, 'status'])->name('devices.putStatus');
    // Nông dân

        # Medication Management
        Route::post('/medication', [MedicationController::class, 'addData'])->name('medication.add');
        Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
        Route::put('/medication/{medication_id}', [MedicationController::class, 'putData'])->name('medication.put');
        Route::delete('/medication/{medication_id}', [MedicationController::class, 'delData'])->name('medication.del');

        # Zone Management
        Route::get('/zones', [ZoneController::class, 'getView'])->name('zones.index');
        Route::post('/zones', [ZoneController::class, 'addZone'])->name('zones.add');
        Route::delete('/zones/{id}', [ZoneController::class, 'delZone'])->name('zones.del');
        Route::put('/zones/{id}', [ZoneController::class, 'udpZone'])->name('zones.udp');

        # Area Management
        Route::get('/areas', [AreaController::class, 'getView'])->name('areas.index');
        Route::post('/areas', [AreaController::class, 'addArea'])->name('areas.add');
        Route::delete('/areas/{area_id}', [AreaController::class, 'delArea'])->name('areas.del');
        Route::put('/areas/{area_id}', [AreaController::class, 'udpArea'])->name('areas.udp');
        Route::post('/areas.get-by-zone', [AreaController::class, 'getAreasByZone']);

        #Food Management
        Route::post('/food', [FoodController::class, 'addFood'])->name('foods.add');

        # Barn Management
        Route::get('/barns', [BarnController::class, 'index'])->name('barns.index');
        Route::get('/barns/{id}', [BarnController::class, 'show'])->name('barns.show');
        Route::post('/barns', [BarnController::class, 'addBarn'])->name('barns.add');
        Route::delete('/barns/{id}', [BarnController::class, 'delBarn'])->name('barns.del');
        Route::put('/barns/{id}', [BarnController::class, 'udpBarn'])->name('barns.udp');
        Route::get('/barns/{barn}/data', [BarnController::class, 'getData'])->name('barns.getData');

    // Chung chung
//        Route::get('/dashboard', [DashboardController::class, 'getView'])->name('dashboard.view');
        Route::get('', [HomeController::class, 'redirectToDashboard'])->name('home');

        Route::get('/farms/{id}', [FarmController::class, 'show'])->name('farms.show'); // Chi tiết farm theo id

        Route::get('/breeds', [BreedController::class, 'index'])->name('breeds.index');
        Route::post('/breeds', [BreedController::class, 'add'])->name('breeds.add');
        Route::put('/breeds/{id}', [BreedController::class, 'udp'])->name('breeds.udp');
        Route::delete('/breeds/{id}', [BreedController::class, 'del'])->name('breeds.del');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        # Goat Management
        Route::get('/goats', [GoatController::class, 'index'])->name('goats.index');
        Route::get('goats/{id}', [GoatController::class, 'show'])->name('goats.show');
        Route::post('/goats', [GoatController::class, 'add'])->name('goats.add');
        Route::post('/goats/{id}/addWeight', [GoatController::class, 'addWeight'])->name('goats.addWeight');
        Route::post('/goats/{id}/addDisease', [GoatController::class, 'addDisease'])->name('goats.addDisease');
        Route::post('/goats/{id}/addFood', [GoatController::class, 'addFood'])->name('goats.addFood');
        Route::post('/goats/{id}/transferBarn', [GoatController::class, 'transferBarn'])->name('goats.transferBarn');

        Route::get('/goats/create', [GoatController::class, 'showGoatForm'])->name('goats.create');
        Route::delete('/goats/{goat_id}/del', [GoatController::class, 'delGoat'])->name('goats.del');
        Route::put('/goats/{goat_id}/udp', [GoatController::class, 'udpGoat'])->name('goats.udp');

        #Food Management
        Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
        Route::post('/foods', [FoodController::class, 'add'])->name('foods.add');
        Route::delete('/foods/{id}', [FoodController::class, 'delFood'])->name('foods.del');
        Route::put('/foods/{id}', [FoodController::class, 'udpFood'])->name('foods.udp');

        #Food Management
        Route::get('/typefoods', [TypeFoodController::class, 'index'])->name('typefoods.index');
        Route::post('/typefoods', [TypeFoodController::class, 'add'])->name('typefoods.add');
        Route::delete('/typefoods/{id}', [TypeFoodController::class, 'delFood'])->name('typefoods.del');
        Route::put('/typefoods/{id}', [TypeFoodController::class, 'udpFood'])->name('typefoods.udp');

        # IoT Management
        Route::group(['prefix' => 'iot'], function () {
            Route::get('/', [IoTController::class, 'index'])->name('iot.index');
            Route::post('/control', [IoTController::class, 'control'])->name('iot.control');
        });
});

# API
// Route::get('/api/farm1/zone1/barn1/sensor/humidity', [APIController::class, 'getView'])->name('api.humidity');
Route::post('/api/sensor-data', [SensorDataController::class, 'store']);
Route::get('/api/sensor-data', [SensorDataController::class, 'index']);

Route::get('/api/barn-data/{deviceId}/humidity', [BarnController::class, 'getHumidityData']);

// Route::middleware([CheckPermission::class, 'permission:view_farm_list'])->group(function () {
//     Route::get('/farms', [FarmController::class, 'getView'])->name('listfarm');
//     // Các route khác của farmer
// });

// Route::middleware([CheckPermission::class, 'permission:edit_farm_list'])->group(function () {
//     Route::post('/farms', [FarmController::class, 'addFarm'])->name('listfarm.add');
//     // Các route khác của farm owner hoặc admin
// });

// Route::middleware([CheckPermission::class, 'permission:edit_device'])->group(function () {
//     // Các route khác dành cho IT nông trại
// });



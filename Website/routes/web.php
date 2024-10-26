<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListGoatController;
use App\Http\Controllers\GoatDetailController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ListFarmController;
use App\Http\Controllers\MedicationController;

Route::get('/', [DashboardController::class, 'getView'])->name('home');
Route::get('/danhsachde', [DashboardController::class, 'getViewQLD'])->name('quanlyde');
Route::get('/login', [LoginController::class, 'getView'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login_post');
Route::get('/account', [AccountController::class, 'getView'])->name('account');
// Route::get('/farms', [ListFarmController::class, 'getView'])->name('listfarm');

Route::get('goatdetail/{goat_id}', [GoatDetailController::class, 'getview'])->name('goatdetail');

# Medication Management

Route::get('/medication', [MedicationController::class, 'getView'])->name('medication');
Route::post('/medication', [MedicationController::class, 'addData'])->name('medication_add');
Route::delete('/medication/{id}', [MedicationController::class, 'delData'])->name('medication.del');
Route::put('/medication/{id}', [MedicationController::class, 'putData'])->name('medication.put');

# List_Farm Management
Route::get('/farms', [ListFarmController::class, 'getView'])->name('listfarm');
Route::post('/farms', [ListFarmController::class, 'addFarm'])->name('listfarm.add');
Route::delete('/farms/{farm_id}', [ListFarmController::class, 'delFarm'])->name('listfarm.del');
Route::put('/farms/{farm_id}', [ListFarmController::class, 'putFarm'])->name('listfarm.put');

# List_Goat Management
Route::get('/goats', [ListGoatController::class, 'getView'])->name('listgoat');
Route::post('/goats', [ListGoatController::class, 'addGoat'])->name('listgoat.add');
Route::delete('/goats/{goat_id}', [ListGoatController::class, 'delGoat'])->name('listgoat.del');
Route::put('/goats/{goat_id}', [ListGoatController::class, 'putGoat'])->name('listgoat.put');

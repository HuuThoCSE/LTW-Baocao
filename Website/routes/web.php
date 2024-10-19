<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListGoatController;
use App\Http\Controllers\GoatDetailController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ListFarmController;

Route::get('/', [DashboardController::class, 'getView'])->name('home');
Route::get('/danhsachde', [DashboardController::class, 'getViewQLD'])->name('quanlyde');
Route::get('/login', [LoginController::class, 'getView'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login_post');
Route::get('/listgoat', [ListGoatController::class, 'getView'])->name('listgoat');
Route::get('/account', [AccountController::class, 'getView'])->name('account');
Route::get('/farms', [ListFarmController::class, 'getView'])->name('listfarm');

Route::get('goatdetail/{goat_id}', [GoatDetailController::class, 'getview'])->name('goatdetail');
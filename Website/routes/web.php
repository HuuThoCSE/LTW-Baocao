<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListGoatController;

Route::get('/', [DashboardController::class, 'getViewDashboard'])->name('home');
Route::get('/danhsachde', [DashboardController::class, 'getViewQLD'])->name('quanlyde');
Route::get('/login', [LoginController::class, 'getView'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login_post');
Route::get('/listgoat', [ListGoatController::class, 'getView'])->name('listgoat');
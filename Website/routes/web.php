<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\GoatManagementController;
use App\Http\Controllers\BreedManagementController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListGoatController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\DashboardController@getViewDashboard')->name('home');
Route::get('/danhsachde', 'App\Http\Controllers\DashboardController@getViewQLD')->name('quanlyde');
Route::get('/login', 'App\Http\Controllers\LoginController@getView')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login_post');

Route::get('/listgoat', 'App\Http\Controllers\ListGoatController@getview')->name('listgoat');

Route::get('/goat-management', 'App\Http\Controllers\GoatManagementController@getView')->name('/goat-management');

Route::get('/breed-management', 'App\Http\Controllers\BreedManagementController@getView')->name('/breed-management');

// Route::get('/health-check', ['HealthCheckController::class', 'getViewQLD'])->name('health-check');
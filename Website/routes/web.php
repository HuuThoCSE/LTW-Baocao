<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\DashboardController@getViewDashboard')->name('home');
Route::get('/danhsachde', 'App\Http\Controllers\DashboardController@getViewQLD')->name('quanlyde');
Route::get('/login', 'App\Http\Controllers\LoginController@getView')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login_post');

Route::get('/health-check', 'App\Http\Controllers\HealthCheckController@getView')->name('health-check');
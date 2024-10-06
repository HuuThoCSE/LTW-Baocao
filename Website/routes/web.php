<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\DashboardController@getViewDashboard')->name('home');
Route::get('/danhsachde', 'App\Http\Controllers\DashboardController@getViewQLD')->name('quanlyde');
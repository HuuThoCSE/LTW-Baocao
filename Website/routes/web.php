<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthCheckController;

use Illuminate\Support\Facades\Route;


Route::get('/', ['DashboardController', 'getViewDashboard'])->name('home');

Route::get('/health-check', 'App\Http\Controllers\HealthCheckController@getView')->name('health-check');

// Route::get('/health-check', ['HealthCheckController::class', 'getViewQLD'])->name('health-check');
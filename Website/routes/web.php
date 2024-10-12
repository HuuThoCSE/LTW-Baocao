<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\GoatManagementController;
use App\Http\Controllers\BreedManagementController;

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\DashboardController@getView')->name('home');

Route::get('/health-check', 'App\Http\Controllers\HealthCheckController@getView')->name('health-check');

Route::get('/goat-management', 'App\Http\Controllers\GoatManagementController@getView')->name('/goat-management');

Route::get('/breed-management', 'App\Http\Controllers\BreedManagementController@getView')->name('/breed-management');

// Route::get('/health-check', ['HealthCheckController::class', 'getViewQLD'])->name('health-check');
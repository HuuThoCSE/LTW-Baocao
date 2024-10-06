<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/', 'middleware' => 'isLogin'], function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    })->name('root');
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@getViewDashboard')->name('home');
    Route::post('/dashboard/update-todo', 'App\Http\Controllers\DashboardController@UpdateTodo');
    Route::post('/dashboard/update-sub-todo', 'App\Http\Controllers\DashboardController@UpdateSubTodo');

    Route::get('/login-history', 'App\Http\Controllers\AccountController@loginHistory');
    Route::group(['prefix' => '/account'], function () {
        Route::get('/', 'App\Http\Controllers\AccountController@getView');
        Route::put('/add', 'App\Http\Controllers\AccountController@add');
        Route::post('/update', 'App\Http\Controllers\AccountController@update');
        Route::delete('/delete', 'App\Http\Controllers\AccountController@delete');


        Route::delete('/clear-history', 'App\Http\Controllers\AccountController@clearHistory');

        Route::get('/demo', function () {
            return view('auth.account.account_import_demo');
        });
        Route::get('/demo', 'App\Http\Controllers\AccountController@demoView');
        Route::post('/demo', 'App\Http\Controllers\AccountController@import');
    });
});
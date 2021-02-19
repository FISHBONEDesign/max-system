<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::prefix('admin')->group(function () {

    Route::name('auth.admin.')->namespace('AuthAdmin')->group(function () {
        Route::middleware('guest:admin')->group(function () {
            Route::get('/login', 'LoginController@showLoginForm')->name('login');
            Route::post('/login', 'LoginController@login');

            Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('/register', 'RegisterController@register');
        });

        Route::post('/logout', 'LoginController@logout')->name('logout');

        Route::prefix('/password')->group(function () {
            Route::middleware('auth:admin')->group(function () {
                Route::get('/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
                Route::post('/confirm', 'ConfirmPasswordController@confirm');
            });

            Route::name('password.')->group(function () {
                Route::post('/email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
                Route::get('/reset', 'ForgotPasswordController@showLinkRequestForm')->name('request');
                Route::post('/reset', 'ResetPasswordController@reset')->name('update');
                Route::get('/reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
            });
        });
    });

    Route::middleware('auth:admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return view('adminhome');
        })->name('home');

        Route::name('manage.')->group(function () {
            Route::resource('devices', 'DeviceController');

            Route::resource('firmwares', 'FirmwareController');
            Route::prefix('/firmwares')->name('firmwares.')->group(function () {
                Route::get('/list/{device}', 'FirmwareController@list')->name('list');
                Route::get('/create/{device}', 'FirmwareController@create')->name('create');
                Route::post('/store/{device}', 'FirmwareController@store')->name('store');
            });
        });
    });
});

Route::get('/download/firmwares/{device}/{version}/{action}', 'FirmwareController@download')->name('download.firmware');

Route::get('/', function () {
    return view('welcome');
});

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

        Route::middleware('auth:admin')->group(function () {
            Route::get('/profile', 'AdminController@show')->name('profile');
            Route::get('/profile/edit', 'AdminController@edit')->name('profile.edit');
            Route::patch('/profile', 'AdminController@update')->name('profile.update');
            Route::middleware('admin.password.confirm')->get('/password', 'AdminController@showPassword')->name('passwords.show');
            Route::patch('/password', 'AdminController@updatePassword')->name('passwords.update');
        });
    });

    Route::middleware('auth:admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.projects.index');
        })->name('home');

        Route::resource('groups', 'GroupController');

        Route::name('groups')->resource('/groups/{group}/members', 'Group\MemberController');

        Route::prefix('/projects')->name('projects.')->group(function () {
            Route::get('/', 'ProjectController@index')->name('index');
            Route::post('/', 'ProjectController@store')->name('store');
            Route::get('/create', 'ProjectController@create')->name('create');
            Route::get('/{project}', 'ProjectController@show')->name('show');
            Route::get('/{project}/edit', 'ProjectController@edit')->name('edit');
            Route::patch('/{project}/update', 'ProjectController@update')->name('update');
            Route::delete('/{project}/destroy', 'ProjectController@destroy')->name('destroy');

            Route::prefix('/{project}/folders')->name('folders.')->group(function () {
                Route::get('/show/{folder?}', 'FolderController@show')->name('show');
                Route::get('/create/{folder?}', 'FolderController@create')->name('create');
                Route::post('/{folder?}', 'FolderController@store')->name('store');
                Route::get('/{folder}/edit', 'FolderController@edit')->name('edit');
                Route::patch('/{folder}/update', 'FolderController@update')->name('update');
                Route::delete('/{folder}', 'FolderController@destroy')->name('destroy');
            });

            Route::prefix('/{project}/devices')->name('devices.')->group(function () {
                Route::get('/create/{folder?}', 'DeviceController@create')->name('create');
                Route::post('/', 'DeviceController@store')->name('store');
                Route::get('/show/{folder?}', 'DeviceController@show')->name('show');
                Route::get('/{device}/edit', 'DeviceController@edit')->name('edit');
                Route::patch('/{device}/update', 'DeviceController@update')->name('update');
                Route::delete('/{device}', 'DeviceController@destroy')->name('destroy');
            });

            Route::prefix('/{project}/firmwares')->name('firmwares.')->group(function () {
                Route::get('/{device}', 'FirmwareController@list')->name('list');
                Route::get('/{device}/create', 'FirmwareController@create')->name('create');
                Route::post('/{device}/store', 'FirmwareController@store')->name('store');
                Route::get('/{firmware}/edit', 'FirmwareController@edit')->name('edit');
                Route::patch('/{firmware}/update', 'FirmwareController@update')->name('update');
                Route::delete('/{firmware}/destroy', 'FirmwareController@destroy')->name('destroy');
            });
        });
    });
});

Route::get('/download/firmwares/{project}/{device}/{version}/{action}', 'FirmwareController@download')->name('download.firmware');

Route::get('/', function () {
    return view('welcome');
});

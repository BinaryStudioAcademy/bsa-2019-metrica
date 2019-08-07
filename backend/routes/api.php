<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::group([
        'namespace' => 'Api',
        'middleware' => 'auth:jwt'
    ], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::put('/{id}', 'UserController@update')->where('id', '[0-9]+');
        });
        Route::post('/login', 'Auth\\AuthController@login');

        Route::group(['prefix' => 'websites'], function () {
            Route::post('/add', 'WebsiteController@add');
        });
    });
});

Route::prefix('v1')->group(function () {
    Route::group([
        'prefix' => 'auth',
        'namespace' => 'Api\\Auth'
    ], function () {
        Route::post('/register', 'RegisterController@create');
    });

    Route::group([
        'middleware' => 'guest',
        'namespace' => 'Api\\Auth'
    ], function () {
        Route::post('/reset-password', 'ResetPasswordController@sendPasswordResetLink');
    });
});

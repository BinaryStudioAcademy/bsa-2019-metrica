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
        'prefix' => 'auth',
        'namespace' => 'Api\\Auth'
    ], function () {
        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
        Route::post('/reset-password', 'ResetPasswordController@sendPasswordResetLink');
        Route::put('/confirm-email', 'ResetPasswordController@confirmEmail');
        Route::get('/me', 'AuthController@getCurrentUser')->middleware('auth:api');
        Route::group(['prefix' => '/social'], function () {
            Route::get('/{provider}/redirect', 'AuthController@redirect');
            Route::get('/{provider}/callback', 'AuthController@oauthCallback');
        });
    });

    Route::group([
        'namespace' => 'Api',
        'middleware' => 'auth:api'
    ], function () {
        Route::group([
            'prefix' => 'users'
        ], function () {
            Route::put('/me', 'UserController@update');
        });

        Route::group([
            'prefix' => 'websites'
        ], function () {
            Route::get('/', 'WebsiteController@getCurrentUserWebsite');
            Route::post('/', 'WebsiteController@add');
            Route::put('/{id}', 'WebsiteController@update');
        });

        Route::group([
            'prefix' => 'visitors'
        ], function () {
            Route::get('/', 'VisitorController@getAllVisitors');
            Route::get('/by-table', 'VisitorController@getVisitorsByParameter');
            Route::get('/new', 'VisitorController@getNewVisitors');
            Route::get('/new/count', 'VisitorController@getNewVisitorsCountForFilterData');
            Route::get('/bounce-rate', 'VisitorController@getVisitorsBounceRate');
            Route::get('/bounce-rate/total', 'VisitorController@getBounceRate');
            Route::get('/new-visitors-table', 'VisitorController@getNewVisitorsForTableByParameter');
        });

        Route::group([
            'prefix' => 'visits'
        ], function () {
            Route::get('/by-table', 'VisitController@getPageViewsByParameter');
        });

        Route::group([
            'prefix' => 'sessions',
        ], function () {
            Route::get('/', 'SessionController@getAllSessions');
            Route::get('/count', 'SessionController@getCountOfSessions');
            Route::get('/average', 'SessionController@getAverageSession');
            Route::get('/param', 'SessionController@getSessionsByParameter');
        });

        Route::group([
            'prefix' => 'table-sessions'
        ], function () {
            Route::get('/avg-session-time', 'SessionController@getAvgSessionTimeByParameter');
        });

        Route::group([
            'prefix' => 'chart-visits'
        ], function () {
            Route::get('/', 'VisitController@getPageViews');
            Route::get('/unique','VisitController@getUniquePageViewsChart');
        });

        Route::group([
            'prefix' => 'chart-sessions',
        ], function () {
            Route::get('/', 'SessionController@getSessions');
        });

        Route::group([
            'prefix' => 'chart-average-sessions'
        ], function () {
            Route::get('/', 'SessionController@getAverageSessionByInterval');
        });

        Route::group([
            'prefix' => 'chart-new-visitors'
        ], function () {
            Route::get('/', 'VisitorController@getNewVisitorsByDateRange');
        });

        Route::get('/chart-total-visitors', 'VisitorController@getTotalVisitorsByDateRange');

        Route::group([
            'prefix' => 'button-page-views'
        ], function () {
            Route::get('/count', 'VisitController@getPageViewsCountForFilterData');
        });

        Route::get('/button-visitors', 'VisitorController@getVisitorsCount');

        Route::get('/geo-location-items', 'GeoLocationController');
    });

    Route::group([
        'namespace' => 'OpenApi'
    ], function () {
        Route::group([
            'prefix' => 'visits'
        ], function () {
            Route::post('/', 'VisitController@createVisit');
        });

        Route::group([
            'prefix' => 'visitors'
        ], function () {
            Route::post('/', 'VisitorController@createVisitor')->middleware('x-website');
        });
    });
});

Route::get('/v1/health', function () {
    return "healthy";
});

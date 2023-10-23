<?php

use App\Middlewares\AuthMiddleware;
use Pecee\SimpleRouter\SimpleRouter as Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => '/api/v1/'], function () {
    Route::get('ping', 'HealthController@ping');

    Route::group(['prefix' => '/link/'], function () {

        Route::group(['middleware' => AuthMiddleware::class], function () {
            Route::post('/', 'LinkController@short');

            Route::get('/', 'LinkController@myLinks');
            Route::get('{short}', 'LinkController@get');
            Route::patch('{short}', 'LinkController@update');
            Route::delete('{short}', 'LinkController@delete');
        });
    });

    Route::group(['prefix' => '/auth/'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
    });
});
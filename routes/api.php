<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\PermissionMiddleware;
use Pecee\SimpleRouter\SimpleRouter as Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => '/api/v1/'], function () {
    Route::get('ping', 'HealthController@ping');

    Route::group(['prefix' => '/link/'], function () {
        Route::post('/', 'LinkController@short');
        Route::get('{short}', 'LinkController@get');
        Route::get('/', 'LinkController@myLinks')->addMiddleware(AuthMiddleware::class);
        Route::patch('{short}', 'LinkController@update')->addMiddleware(AuthMiddleware::class);
        Route::delete('{short}', 'LinkController@delete')->addMiddleware(AuthMiddleware::class);
    });

    Route::group(['prefix' => '/domain/', 'middleware' => [AuthMiddleware::class, PermissionMiddleware::class]], function () {
        Route::post('/', 'DomainController@store');
        Route::get('/', 'DomainController@all');
        Route::patch('{short}', 'DomainController@update');
        Route::delete('{short}', 'DomainController@delete');
    });

    Route::group(['prefix' => '/auth/'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
    });
});
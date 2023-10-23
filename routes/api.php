<?php

use Pecee\SimpleRouter\SimpleRouter as Route;


Route::group(['namespace' => 'Api\V1', 'prefix' => '/api/v1/'], function () {
    Route::get('ping', 'HealthController@ping');

    Route::group(['prefix' => '/link/'], function () {
        Route::get('/', 'LinkController@myLinks');
        Route::post('/', 'LinkController@short');
        Route::get('{short}', 'LinkController@get');
        Route::delete('{short}', 'LinkController@delete');
    });
});
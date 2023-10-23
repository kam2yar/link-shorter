<?php

use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::group(['namespace' => 'Api\V1', 'prefix' => '/api/v1/'], function () {
    SimpleRouter::get('ping', 'HealthController@ping');


    SimpleRouter::group(['prefix' => '/link/'], function () {
        SimpleRouter::get('my', 'LinkController@myLinks');
        SimpleRouter::post('short', 'LinkController@short');
    });
});
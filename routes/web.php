<?php

use Pecee\SimpleRouter\SimpleRouter as Route;

Route::group(['namespace' => 'Web'], function () {
    Route::get('{short}', 'RedirectController@redirect');

});

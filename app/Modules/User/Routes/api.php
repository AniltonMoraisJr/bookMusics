<?php

Route::group([
    'prefix' => 'auth',
    'middleware' => 'auth:api'
], function () {
   Route::resource('users', 'UserController');
   Route::get('user', 'UserController@getUserInfo');
});
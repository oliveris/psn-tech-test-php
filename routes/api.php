<?php

use Illuminate\Support\Facades\Route;

// Video endpoints
Route::get('api/videos', [
    'as'   => 'videos',
    'uses' => 'VideoController@index'
]);

Route::post('api/videos', [
    'as'   => 'videos',
    'uses' => 'VideoController@store'
]);

Route::get('api/videos/{id}', [
    'as'   => 'videos',
    'uses' => 'VideoController@show'
]);

Route::delete('api/videos/{id}', [
    'as'   => 'videos',
    'uses' => 'VideoController@destroy'
]);

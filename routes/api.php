<?php

use Illuminate\Support\Facades\Route;

// Video endpoints
Route::get('api/videos', [
    'as'   => 'videos',
    'uses' => 'VideoController@index'
]);

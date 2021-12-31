<?php

use Illuminate\Support\Facades\Route;

// Video endpoints
Route::get('videos', [
    'as'   => 'videos', 
    'uses' => 'VideoController@index'
]);
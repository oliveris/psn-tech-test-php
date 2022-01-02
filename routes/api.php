<?php

use Illuminate\Support\Facades\Route;

// Video endpoints
Route::get('api/videos', [
    'as'   => 'videos.index',
    'uses' => 'VideoController@index'
]);

Route::post('api/videos', [
    'as'   => 'videos.store',
    'uses' => 'VideoController@store'
]);

Route::get('api/videos/{id}', [
    'as'   => 'videos.show',
    'uses' => 'VideoController@show'
]);

Route::delete('api/videos/{id}', [
    'as'   => 'videos.delete',
    'uses' => 'VideoController@destroy'
]);

// Endpoint for indexing the filtering the video
Route::get('api/filter-videos', [
    'as'   => 'filter-videos',
    'uses' => 'VideoController@indexFilter'
]);

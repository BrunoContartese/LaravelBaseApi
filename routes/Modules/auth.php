<?php
use Illuminate\Support\Facades\Route;

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/forgot-password', 'App\Http\Controllers\AuthController@forgotPassword');
Route::post('/reset-password', 'App\Http\Controllers\AuthController@passwordReset');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');

    Route::group(['prefix' => 'auth'], function() {
        Route::get('user', 'App\Http\Controllers\AuthController@user');
        Route::put('updatePassword', 'App\Http\Controllers\AuthController@updatePassword');
        Route::put('updateProfile', 'App\Http\Controllers\AuthController@updateProfile');
    });

});

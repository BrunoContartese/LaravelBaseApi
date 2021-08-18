<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'administration', 'middleware' => 'auth:api'], function () {
    Route::apiResource('users', 'App\Http\Controllers\Administration\UsersController');
    Route::get('users/paginated/index', 'App\Http\Controllers\Administration\UsersController@paginated');
    Route::post('users/{user}/restore', 'App\Http\Controllers\Administration\UsersController@restore');

    Route::apiResource('roles', 'App\Http\Controllers\Administration\RolesController');
    Route::get('roles/paginated/index/{query?}', 'App\Http\Controllers\Administration\RolesController@paginated');
    Route::post('roles/{role}/syncPermissions', 'App\Http\Controllers\Administration\RolesController@syncPermissions');

    Route::get('permissions', 'App\Http\Controllers\Administration\PermissionsController@index');

    Route::post('files', 'App\Http\Controllers\Administration\FilesController@store');
});

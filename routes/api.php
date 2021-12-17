<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users','App\Http\Controllers\Api\V1\RegisterController@getUsers');
Route::post('/user-register' , 'App\Http\Controllers\Api\V1\RegisterController@register');
Route::post('/add-user-image/{id}', 'App\Http\Controllers\Api\V1\RegisterController@uploadImage');
Route::delete('/user-delete/{id}' , 'App\Http\Controllers\Api\V1\RegisterController@deleteUser');




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

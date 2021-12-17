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

Route::group(['namespace' => 'App\Http\Controllers\Api\V1',], function () {
    Route::get('/users','RegisterController@getUsers');
    Route::post('/user-register' , 'RegisterController@register');
    Route::post('/add-user-image/{id}', 'RegisterController@uploadImage');
    Route::delete('/user-delete/{id}' , 'RegisterController@deleteUser');
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

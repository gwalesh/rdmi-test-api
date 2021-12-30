<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Api\V1',], function () {
    Route::get('/users','RegisterController@getUsers');
    Route::post('/user-register' , 'RegisterController@register');
    Route::post('/add-user-image/{id}', 'RegisterController@uploadImage');
    Route::delete('/user-delete/{id}' , 'RegisterController@deleteUser');
    Route::post('/login' , 'LoginController@login')->name('login');
}); 

Route::group(['namespace' => 'App\Http\Controllers\Api\V1' , 'middleware' => 'auth:sanctum'] , function(){    
    Route::get('/getUser' , 'LoginController@checkUser')->name('checkuser');
    Route::post('/logout' , 'LoginController@logout')->name('logout');
    Route::post('/selectCourse/{id}' , 'RegisterController@selectCourse')->name('selectCourse');
});

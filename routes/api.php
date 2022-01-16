<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('/register','App\Http\Controllers\UserController@register');
Route::post('/login','\App\Http\Controllers\UserController@login');
Route::get('/getall','\App\Http\Controllers\UserController@getAll');
Route::group(['middleware' => ['auth:api']],function(){
    Route::get('/get-user','\App\Http\Controllers\UserController@getDetails');
    Route::get('/get-all-product','\App\Http\Controllers\ProductController@getAll');
});
Route::post('/forgot-password','\App\Http\Controllers\UserController@forgot');
Route::post('/reset-user-pass','\App\Http\Controllers\UserController@reset');

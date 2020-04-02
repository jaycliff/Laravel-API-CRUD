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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    // Prepend the token with "Bearer "!!!!! F@$#!!!
    // Headers -> Authorization -> Bearer iKeOUrIyWB6d9uZO3yn3c9P1SrSYUut1qXUndX6C3OR1pUEfgAjKPZcBUa74PMqNMRL9gugU4FXqSL0T
    Route::resource('/user', 'UserController');
    Route::post('revoke', 'UserController@revoke')->name('revoke');
});

Route::post('login', 'UserController@login')->name('login');
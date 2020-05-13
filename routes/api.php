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
    // Set 'Content-Type' and 'Accept' to 'application/json' inside Headers
    Route::resource('/user', 'UserController');
    Route::post('signout', 'UserController@signout')->name('signout');
    Route::post('/post', 'PostController@store')->name('post.store');
    Route::match(['put', 'patch'], '/post/{post}', 'PostController@update')->name('post.update');
    Route::delete('/post/{post}', 'PostController@destroy')->name('post.delete');
});

Route::post('login', 'UserController@login')->name('login');
Route::get('/post', 'PostController@index')->name('post.index');
Route::get('/post/{post}', 'PostController@show')->name('post.show');
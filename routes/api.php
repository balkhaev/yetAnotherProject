<?php

use App\Models\User;

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

Route::middleware('auth:sanctum')->get('items', 'App\Http\Controllers\ItemController@index');
Route::middleware('auth:sanctum')->get('items/{name}', 'App\Http\Controllers\ItemController@show');
Route::middleware('auth:sanctum')->post('items', 'App\Http\Controllers\ItemController@upload');

Route::middleware('auth:sanctum')->get('users', 'App\Http\Controllers\UserController@index');
Route::middleware('auth:sanctum')->post('users', 'App\Http\Controllers\UserController@create');
Route::middleware('auth:sanctum')->get('user', 'App\Http\Controllers\UserController@current');

Route::middleware('auth:sanctum')->get('tokens', 'App\Http\Controllers\TokenController@index');
Route::middleware('auth:sanctum')->delete('tokens/{id}', 'App\Http\Controllers\TokenController@delete');
Route::middleware('auth:sanctum')->post('tokens/create', 'App\Http\Controllers\TokenController@create');

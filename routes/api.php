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

Route::middleware('auth:sanctum')->get('items', 'App\Http\Controllers\ItemController@index');
Route::middleware('auth:sanctum')->get('items/{name}', 'App\Http\Controllers\ItemController@show');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/tokens', function (Request $request) {
    return $request->user()->tokens->all();
});

Route::middleware('auth:sanctum')->delete('/tokens/{id}', function (Request $request, $id) {
    return $request->user()->tokens->where('id', $id)->delete();
});

Route::middleware('auth:sanctum')->post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('denuncia', 'DenunciaController@denuncia');

Route::get('survivor', 'SurvivorController@index');
Route::get('survivor/{id}', 'SurvivorController@show');
Route::post('survivor', 'SurvivorController@store');
Route::put('survivor/{id}', 'SurvivorController@update');
Route::delete('survivor/{id}', 'SurvivorController@destroy');

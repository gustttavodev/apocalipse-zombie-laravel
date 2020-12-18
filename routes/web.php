<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(array('prefix' => 'api'), function (){

    Route::get('/', function (){
        return response()->json([
            'status' => 'Survivor Connected'
        ]);
    });

    Route::resource('survivor', 'SurvivorController');

    Route::get('survivor/relatorio', 'SurvivorController@relatorio');

    Route::get('/items', 'ItemsController@index');
    Route::post('/items/trocas', 'ItemsController@trocas');


    Route::get('/', function (){
        return redirect('/survivor');
    });
});

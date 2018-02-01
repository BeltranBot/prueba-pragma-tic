<?php

use Illuminate\Http\Request;

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

Route::get('clients', 'API\ClientController@get');
Route::get('clients/{client}', 'API\ClientController@getClient');
Route::post('clients', 'API\ClientController@store');
Route::delete('clients/{client}', 'API\ClientController@destroy');
Route::put('clients/{client}', 'API\ClientController@update');
Route::put('clients/{client}/restore', 'API\ClientController@restore');

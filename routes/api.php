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

// Client
Route::get('clients', 'API\ClientController@get');
Route::get('clients/{client}', 'API\ClientController@getClient');
Route::post('clients', 'API\ClientController@store');
Route::delete('clients/{client}', 'API\ClientController@destroy');
Route::put('clients/{client}', 'API\ClientController@update');
Route::put('clients/{client}/restore', 'API\ClientController@restore');

// Printer
Route::get('printers', 'API\PrinterController@get');
Route::get('printers/{printer}', 'API\PrinterController@getPrinter');
Route::post('printers', 'API\PrinterController@store');
Route::delete('printers/{printer}', 'API\PrinterController@destroy');
Route::put('printers/{printer}', 'API\PrinterController@update');
Route::put('printers/{printer}/restore', 'API\PrinterController@restore');

// Paper
Route::get('papers', 'API\PaperController@get');
Route::get('papers/{paper}', 'API\PaperController@getPaper');
Route::post('papers', 'API\PaperController@store');
Route::delete('papers/{paper}', 'API\PaperController@destroy');
Route::put('papers/{paper}', 'API\PaperController@update');
Route::put('papers/{paper}/restore', 'API\PaperController@restore');

// Operators
Route::get('operators', 'API\OperatorController@get');
Route::get('operators/{operator}', 'API\OperatorController@getOperator');
Route::post('operators', 'API\OperatorController@store');
Route::delete('operators/{operator}', 'API\OperatorController@destroy');
Route::put('operators/{operator}', 'API\OperatorController@update');
Route::put('operators/{operator}/restore', 'API\OperatorController@restore');

// Pricings
Route::get('pricings', 'API\PricingController@get');
Route::get('pricings/{pricing}', 'API\PricingController@getPricing');
Route::post('pricings', 'API\PricingController@store');
Route::delete('pricings/{pricing}', 'API\PricingController@destroy');
Route::put('pricings/{pricing}', 'API\PricingController@update');
Route::put('pricings/{pricing}/restore', 'API\PricingController@restore');

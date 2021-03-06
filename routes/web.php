<?php

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

Route::get('/', function () {
    // return view('welcome');
    return view('main.index');
});


Route::get('clients', 'ClientController@index');
Route::get('printers', 'PrinterController@index');
Route::get('papers', 'PaperController@index');
Route::get('operators', 'OperatorController@index');
Route::get('pricings', 'PricingController@index');
Route::get('pricings/{pricing}', 'PricingController@show');

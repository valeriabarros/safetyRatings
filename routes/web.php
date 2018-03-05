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
// Route::get('user/{id}', function ($id) {

// Route::resource('vehicles/{year}/{manufacturer}/{model}', 'VehicleController');
Route::get('vehicles/{year}/{manufacturer}/{model}', 'VehicleController@getVehicle');
Route::post('vehicles', 'VehicleController@postVehicle');


// Route::get('/', function () {
//     return view('welcome');
// });

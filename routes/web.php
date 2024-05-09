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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('clients', ClientsController::class)->except(['edit', 'update']);

    Route::get('/clients/{client}/bookings', 'BookingsController@index');
    Route::delete('/bookings/{booking}', 'BookingsController@destroy');

    Route::get('/clients/{client}/journals', 'JournalsController@index');
    Route::post('/clients/{client}/journals', 'JournalsController@store');
    Route::delete('/clients/{client}/journals/{journal}', 'JournalsController@destroy');
});

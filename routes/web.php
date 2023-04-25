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

Route::redirect('/', '/bookings');

Route::get('/bookings', 'BookingController@index');

Route::post('/booking/checkin/{booking}', 'BookingController@checkin');
Route::post('/booking/checkout/{booking}', 'BookingController@checkout');

Route::post('/booking/cancel/{booking}', 'BookingController@cancel');

Auth::routes([
    'register' => false, 
    'reset' => false,
    'verify' => false, 
]);


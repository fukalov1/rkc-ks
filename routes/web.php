<?php

use App\Http\Controllers\ClientController;
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
    return view('index');
});

Route::get('about', function () {
    return view('about');
});

Route::get('customer', function () {
    return view('customer', [
        'qr_auth' => 0,
        'check_day_start' => env('CHECK_DAY_START', 15),
        'check_day_end' => env('CHECK_DAY_END', 25),
        ]);
});

Route::get('docs', function () {
    return view('docs');
});

Route::get('info', function () {
    return view('info');
});

Route::get('news', function () {
    return view('news');
});

Route::get('qr/{account}/{code}', [ClientController::class, 'authQR']);

Route::group(['prefix' => 'data'], function() {
    Route::post('/auth', [ClientController::class, 'auth']);
    Route::post('/slips', [ClientController::class, 'listSlips']);
    Route::post('/send', [ClientController::class, 'sendData']);
});

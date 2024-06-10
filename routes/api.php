<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LEDDataController;
use App\Http\Controllers\SensorDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/led7cbfyre3ftywe7tf7iw34reyt9v3w7f973w4i7u3v7berfg974ity9i743r', [LEDDataController::class, 'sendtoesp']);
Route::post('/sensor', [SensorDataController::class, 'sentfromesp']);

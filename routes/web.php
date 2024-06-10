<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LEDDataController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard', ['title' => 'Dashboard']);
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard', ['title' => 'Dashboard']);
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/led', [LEDDataController::class, 'showledtoweb'])->middleware(['auth', 'verified'])->name('led');
Route::post('/led', [LEDDataController::class, 'storeledtodb']);
Route::put('/led/{id}', [LEDDataController::class, 'updateledtodb']);
Route::delete('/led/{id}', [LEDDataController::class, 'destroyfromdb']);

Route::get('/sensor', [SensorDataController::class, 'showsensortoweb'])->middleware(['auth', 'verified'])->name('sensor');
Route::get('/sensor/latest', [SensorDataController::class, 'updatechart'])->middleware(['auth', 'verified']);
Route::get('/sensor/latest2', [SensorDataController::class, 'updatedashboard'])->middleware(['auth', 'verified']);

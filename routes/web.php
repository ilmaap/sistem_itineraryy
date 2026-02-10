<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LiburNasionalController;

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

Route::get('/', function () {
    return view('landing');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Logout Routes (bisa diakses via GET atau POST)
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard', ['user' => auth()->user()]);
    })->name('admin.dashboard');
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('destinasi', DestinasiController::class);
        Route::resource('paket', PaketController::class);
        Route::resource('user', UserController::class);
        Route::resource('libur_nasional', LiburNasionalController::class);
    });



    
    Route::get('/wisatawan/dashboard', function () {
        return view('wisatawan.dashboard', ['user' => auth()->user()]);
    })->name('wisatawan.dashboard');

});

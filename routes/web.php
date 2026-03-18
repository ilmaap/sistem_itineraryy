<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PaketWisatawanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LiburNasionalController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AkomodasiController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\PermohonanAkunController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WisatawanDashboardController;

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
})->name('landing');

// Public Paket Wisata Routes (Landing Page)
Route::get('/paket-wisata', [PaketWisatawanController::class, 'publicIndex'])->name('paket.public.index');
Route::get('/paket-wisata/{id}', [PaketWisatawanController::class, 'publicShow'])->name('paket.public.show');

// Public About Us Route (Landing Page)
Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');

// Public Form Permohonan Routes (Landing Page)
Route::get('/form-permohonan', [PermohonanAkunController::class, 'create'])->name('form-permohonan');
Route::post('/form-permohonan', [PermohonanAkunController::class, 'store'])->name('form-permohonan.store');

// Login Routes - Single UI untuk semua role
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Legacy routes - tetap ada demi kompatibilitas, tapi diarahkan ke login tunggal
Route::get('/login/wisatawan', function () {
    return redirect()->route('login');
})->name('login.wisatawan');
Route::post('/login/wisatawan', [LoginController::class, 'login'])->name('login.wisatawan.submit');

Route::get('/login/admin', function () {
    return redirect()->route('login');
})->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'login'])->name('login.admin.submit');

Route::get('/login/super-admin', function () {
    return redirect()->route('login');
})->name('login.super-admin');

// Logout Routes (bisa diakses via GET atau POST)
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes (Protected)
Route::middleware(['auth', 'prevent.back'])->group(function () {
    // Admin Routes - hanya untuk admin & super_admin
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::name('admin.')->group(function () {
            Route::resource('destinasi', DestinasiController::class);
            Route::resource('paket', PaketController::class);
            Route::resource('user', UserController::class);
            Route::resource('libur_nasional', LiburNasionalController::class);
            Route::resource('restaurant', RestaurantController::class);
            Route::resource('akomodasi', AkomodasiController::class);
        });
    });

    // Wisatawan Routes - hanya untuk wisatawan
    Route::prefix('wisatawan')->group(function () {
        Route::get('/dashboard', [WisatawanDashboardController::class, 'index'])->name('wisatawan.dashboard');

        Route::name('wisatawan.')->group(function () {
            Route::get('/itinerary', [ItineraryController::class, 'index'])->name('itinerary.index');
            Route::get('/itinerary/create', [ItineraryController::class, 'create'])->name('itinerary.create');
            Route::get('/itinerary/destinations', [ItineraryController::class, 'getDestinations'])->name('itinerary.destinations');
            Route::post('/itinerary/generate', [ItineraryController::class, 'generate'])->name('itinerary.generate');
            Route::post('/itinerary/reoptimize', [ItineraryController::class, 'reoptimize'])->name('itinerary.reoptimize');
            Route::get('/api/holiday-info', [ItineraryController::class, 'getHolidayInfo'])->name('api.holiday-info');
            Route::get('/api/restaurant-recommendations', [ItineraryController::class, 'getRestaurantRecommendations'])->name('api.restaurant-recommendations');
            Route::get('/api/akomodasi-recommendations', [ItineraryController::class, 'getAkomodasiRecommendations'])->name('api.akomodasi-recommendations');
            Route::post('/itinerary', [ItineraryController::class, 'store'])->name('itinerary.store');
            Route::get('/itinerary/{id}', [ItineraryController::class, 'show'])->name('itinerary.show');
            Route::get('/itinerary/{id}/edit', [ItineraryController::class, 'edit'])->name('itinerary.edit');
            Route::delete('/itinerary/{id}', [ItineraryController::class, 'destroy'])->name('itinerary.destroy');
            Route::get('/paket', [PaketWisatawanController::class, 'index'])->name('paket.index');
            Route::get('/paket/{id}', [PaketWisatawanController::class, 'show'])->name('paket.show');
        });
    });
});
